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
        Schema::create('contract_progress', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('additional_doc_type_id')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('member')->nullable();
            $table->string('receive_status')->nullable();
            $table->date('receive_date')->nullable();
            $table->date('asking_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_progress');
    }
};
