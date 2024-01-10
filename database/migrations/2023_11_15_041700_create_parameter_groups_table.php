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
            $table->longText('name');
            $table->unsignedBigInteger('item_type_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('inspectorate_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('status');
            $table->timestamps();

            // Foreign keys
            // $table->foreign('item_type_id')->references('id')->on('item_types')->onDelete('set null');
            // $table->foreign('item_id')->references('id')->on('items')->onDelete('set null');
            // $table->foreign('inspectorate_id')->references('id')->on('inspectorates');
            // $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('parameter_groups', function (Blueprint $table) {
        //     $table->dropForeign(['item_type_id']);
        //     $table->dropForeign(['item_id']);
        //     $table->dropForeign(['inspectorate_id']);
        //     $table->dropForeign(['section_id']);
        // });

        Schema::dropIfExists('parameter_groups');
    }
};
