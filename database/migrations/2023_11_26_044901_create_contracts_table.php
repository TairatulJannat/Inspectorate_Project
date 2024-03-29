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
            $table->integer('insp_id');
            $table->integer('sec_id');
            $table->integer('sender');
            $table->string('reference_no');
            $table->integer('received_by');
            $table->string('additional_documents')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('item_type_id')->nullable();
            $table->string('ltr_no_of_contract');
            $table->date('ltr_date_contract');
            $table->string('contract_no');
            $table->date('contract_date');
            $table->string('contract_state')->nullable();
            $table->string('con_fin_year')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->decimal('contracted_value', 10, 2)->nullable();
            $table->text('delivery_schedule')->nullable();
            $table->string('currency_unit')->nullable();
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
