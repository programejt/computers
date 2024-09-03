<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComputersComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('computers_components', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('computer_id');
        $table->unsignedBigInteger('type_id');
        $table->string('name');

        $table->foreign('computer_id')->references('id')->on('computers')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('type_id')->references('id')->on('components_types')->onUpdate('cascade')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('computers_components');
    }
}
