<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parameter_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('inspectorate_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();

            // Foreign keys
            // $table->foreign('inspectorate_id')->references('id')->on('inspectorates');
            // $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_groups');
    }
};
