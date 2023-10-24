<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('hall_id')->nullable()->default(12);
            $table->longText('logo')->nullable();
            $table->string('email')->nullable();
            $table->longText('contact_information')->nullable();
            $table->longText('location')->nullable();
            $table->longText('facebook_link')->nullable();
            $table->longText('instagram_link')->nullable();
            $table->longText('youtube_link')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('policy')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
