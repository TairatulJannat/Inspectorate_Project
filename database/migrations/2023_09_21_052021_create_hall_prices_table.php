<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('hall_id')->nullable()->default(12);
            $table->string('floor_id')->nullable();
            $table->string('user_category_id')->nullable();
            $table->string('specify_event')->nullable();
            $table->string('event_name')->nullable();
            $table->string('specify_month')->nullable();
            $table->string('months')->nullable();
            $table->string('specify_ramadan')->nullable();
            $table->string('specify_holiday')->nullable();
            $table->string('specify_shift_charge')->nullable();
            $table->integer('shift_id')->nullable()->default(12);
            $table->string('price')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('hall_prices');
    }
}
