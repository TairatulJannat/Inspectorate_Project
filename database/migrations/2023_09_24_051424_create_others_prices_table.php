<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('hall_id')->nullable()->default(12);
            $table->string('security_amount')->nullable();
            $table->string('extra_amount_per_hour')->nullable();
            $table->string('service_charge_for_defence')->nullable();
            $table->string('service_charge_for_non_defence')->nullable();
            $table->string('vat_in_percentage')->nullable();
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
        Schema::dropIfExists('others_prices');
    }
}
