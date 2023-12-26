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
        Schema::create('supplier_spec_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tender_id');
            $table->unsignedBigInteger('indent_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('parameter_group_id');
            $table->unsignedBigInteger('parameter_id');
            $table->string('parameter_name');
            $table->longText('parameter_value');
            $table->string('compliance_status');
            $table->longText('remarks');

            // Add foreign keys
            // $table->foreign('indent_id')->references('id')->on('indents')->onDelete('cascade');
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            // $table->foreign('tender_id')->references('id')->on('tenders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_spec_data');
    }
};
