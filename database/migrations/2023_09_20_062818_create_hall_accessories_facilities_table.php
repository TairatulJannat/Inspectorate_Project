<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallAccessoriesFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_accessories_facilities', function (Blueprint $table) {
            $table->id();
            $table->integer('hall_id')->nullable()->default(12);
            $table->integer('floor_id')->nullable()->default(12);
            $table->string('num_of_extra_room')->nullable();
            $table->string('num_of_chair')->nullable();
            $table->string('num_of_table')->nullable();
            $table->string('num_of_sofa')->nullable();
            $table->string('car_parking_limit')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hall_accessories_facilities');
    }
}
