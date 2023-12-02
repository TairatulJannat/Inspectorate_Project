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
        Schema::create('parameter_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_type_id');
            $table->integer('item_id');
            $table->integer('parameter_group_id');
            $table->integer('parameter_id');
            $table->string('parameter_name');
            $table->integer('user_id');
            $table->integer('action_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_logs');
    }
};
