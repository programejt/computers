<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Computer;
use App\Models\ComputersComponent;
use App\Models\ComponentsTypes;

class ComputersController extends Controller
{
  public function index() {
    return view('computers.index', [
      'title' => 'Komputery',
      'computers' => Computer::get()
    ]);
  }

  public function show(int $computerId) {
    $computer = Computer::get($computerId);

    if ($computer) {
      $compComponents = ComputersComponent::getForComputer($computerId);
      $title = $computer->name.' - Komputer';
    } else {
      $compComponents = null;
      $title = 'Nie ma takiego komputera';
    }

    return view('computers.show', [
      'title' => $title,
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
      'computer' => null,
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
      'computer' => $comp,
      'componentsTypes' => $componentsTypes,
      'formMethod' => 'put',
      'title' => $comp->name.' - '.$title,
      'h1' => $title
    ]);
  }

  public function store(Request $req) {
    $compId = $req->input('computer-id');
    $compName = $req->input('computer-name');

    $req->validate(
      [
      'computer-name' => 'required|max:255',
      'computer-photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1000',
      ],
      [
        'required' => 'Nazwa komputera nie może być pusta',
        'image' => 'Plik musi być obrazkiem',
        'mimes' => 'Typ obrazka nie może być inny niż: :values',
        'max' => 'Maksymalna wielkość obrazka to: :max'
      ]
    );

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

    $photo = $req->file('computer-photo');

    if ($req->input('delete-computer-photo')) {
      $photo = $comp->getPhoto();
      if (file_exists($photo)) {
        unlink($photo);
      }
    } else if ($photo) {
      $photo->move(
        Computer::getPhotoPath($comp->id),
        'photo.'.$photo->extension()
      );
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

    return redirect(
      route('computer.show', ['id' => $comp->id])
    );
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

    return redirect(route('home'));
  }
}
