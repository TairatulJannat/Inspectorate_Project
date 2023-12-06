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
        Schema::create('assign_parameter_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parameter_name');
            $table->longText('parameter_value');
            $table->unsignedBigInteger('parameter_group_id');

            $table->foreign('parameter_group_id')
                ->references('id')->on('parameter_groups')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_parameter_values');
    }
};
