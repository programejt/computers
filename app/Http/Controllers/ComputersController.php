<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Computer;
use App\Models\ComputersComponent;
use App\Models\ComponentsTypes;

class ComputersController extends Controller
{
  public function index() {
    $computers = Computer::select('computers.id as computer_id', 'computers.name as computer_name', 'users.id as user_id', 'users.name as user_name')->join('users', 'users.id', '=', 'user_id')->get();

    return view('computers.index', [
      'title' => 'Komputery',
      'computers' => $computers
    ]);
  }

  public function show($computerId) {
    // $comp = Computer::select('computers.name as computer_name', 'users.name as user_name')
    // ->leftJoin('computers_components', 'computers.id', '=', 'computers_components.computer_id')
    // ->where('computers.id', $computerId);

    // $comp = DB::select('computers.name as computer_name', 'users.name as user_name')
    // ->leftJoin('computers_components', 'computers.id', '=', 'computers_components.computer_id')
    // ->where('computers.id', $computerId);

    $computer = DB::select(
      "SELECT c.id as id, c.name as name, u.id as user_id, u.name as user_name
      FROM computers c
      INNER JOIN users u ON c.user_id = u.id
      WHERE c.id = :computer_id",
      ['computer_id' => $computerId]
    );

    $compComponents = DB::select(
      "SELECT ct.name as type_name, cc.name as component_name
      FROM computers_components cc
      INNER JOIN components_types ct ON cc.type_id = ct.id
      WHERE cc.computer_id = :comp_id",
      ['comp_id' => $computerId]
    );

    $computer = count($computer) ? $computer[0] : null;

    return view('computers.show', [
      'title' => $computer->name.' - Komputer',
      'comp' => $computer,
      'compComponents' => $compComponents
    ]);
  }

  public function add() {
    $componentsTypes = ComponentsTypes::all();

    foreach ($componentsTypes as &$type) {
      $type->value = '';
    }

    $title = 'Dodaj';

    return view('computers.add_or_edit', [
      'computerId' => null,
      'computerName' => '',
      'componentsTypes' => $componentsTypes,
      'formMethod' => 'post',
      'title' => $title,
      'h1' => $title
    ]);
  }

  public function edit(int $id) {
    $comp = Computer::where('id', $id)->first();

    if ($comp == null) {
      return view('computers.edit_error', [
        'msg' => 'Komputer nie istnieje'
      ]);
    }

    if ($comp->user_id != Auth::id()) {
      return view('computers.edit_error', [
        'msg' => 'Nie masz uprawnień do edycji tego komputera'
      ]);
    }

    $componentsTypes = ComponentsTypes::all();
    $compComponents = ComputersComponent::where('computer_id', $id)->get();

    foreach ($componentsTypes as &$type) {
      $type->value = '';
      foreach ($compComponents as &$component) {
        if ($component->type_id == $type->id) {
          $type->value = $component->name;
          break;
        }
      }
    }

    $title = 'Edytuj';

    return view('computers.add_or_edit', [
      'computerId' => $id,
      'computerName' => $comp->name,
      'componentsTypes' => $componentsTypes,
      'formMethod' => 'put',
      'title' => $comp->name.' - '.$title,
      'h1' => $title
    ]);
  }

  public function store(Request $req) {
    $compId = $req->input('computer-id');
    $compName = $req->input('computer-name');

    if (! $compName) {
      return back()->withErrors([
        'computer-name' => 'Nazwa komputera nie może być pusta',
      ]);
    }

    if ($compId != null) {
      $comp = Computer::where('id', $compId)->first();

      if ($comp == null) {
        return back()->withErrors([
          'computer-id' => 'Nie udało się pobrać danych komputera do edycji',
        ]);
      }

      if ($comp->user_id != Auth::id()) {
        return back()->withErrors([
          'computer-id' => 'Nie możesz edytować nieswojego komputera',
        ]);
      }
    } else {
      $comp = new Computer();
      $comp->user_id = Auth::id();
    }

    $comp->name = $compName;

    if (! $comp->save()) {
      return back()->withErrors([
        'computer' => 'Nie udało się utworzyć komputera.',
      ]);
    }

    $componentsTypes = ComponentsTypes::all();

    $errors = [];

    foreach ($componentsTypes as &$type) {
      $componentName = $req->input('component-'.$type->id) ?? '';
      $compComponent = ComputersComponent::where([
        ['type_id', $type->id],
        ['computer_id', $comp->id]
      ])->first();

      if (! $componentName) {
        if ($compComponent) {
          $compComponent->delete($compComponent->id);
        }
        continue;
      }

      if (! $compComponent) {
        $compComponent = new ComputersComponent();
      }

      $compComponent->computer_id = $comp->id;
      $compComponent->type_id = $type->id;
      $compComponent->name = $componentName;

      if (! $compComponent->save()) {
        $errors[] = $type->id;
      }
    }

    if (! empty($errors)) {
      return back()->withErrors([
        'components' => 'Nie udało się dodać niektórych podzespołów do komputera.',
      ]);
    }

    return redirect('/computer/'.$comp->id);
  }

  public function delete(Computer $computer) {
    if (Auth::id() != $computer->user_id) {
      return;
    }

    return view('computers.delete', [
      'title' => $computer->name.' - Usuń komputer',
      'computerId' => $computer->id,
      'computerName' => $computer->name
    ]);
  }

  public function remove(Request $req) {
    $computerId = $req->input('computer-id');

    $computer = Computer::where('id', $computerId)->first();

    if ($computer == null) {
      return back()->withErrors([
        'computer' => 'Komputer nie istnieje.',
      ]);
    }

    if (Auth::id() != $computer->user_id) {
      return back()->withErrors([
        'computer' => 'Nie masz uprawnień do usunięcia tego komputera.',
      ]);
    }

    $computer->delete($computerId);

    return redirect('/');
  }
}
