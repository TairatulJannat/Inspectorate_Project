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
        Schema::create('comparison_remarks', function (Blueprint $table) {
            $table->id();
            $table->string('indent_ref_no');
            $table->string('tender_ref_no');
            $table->string('offer_ref_no');
            $table->string('final_spec_ref_no');
            $table->string('draft_contract_ref_no')->nullable();
            $table->string('contract_ref_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparison_remarks');
    }
};
