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
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ltr_no_of_contract');
            $table->date('ltr_date_contract');
            $table->string('contract_no');
            $table->date('contract_date');
            $table->string('contract_state');
            $table->string('con_fin_year');
            $table->integer('supplier_id');
            $table->decimal('contracted_value', 10, 2);
            $table->text('delivery_schedule');
            $table->string('currency_unit');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
