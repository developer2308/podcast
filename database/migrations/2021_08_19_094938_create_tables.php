<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artwork_url', 2048);
            $table->string('rss_feed_url', 2048)->nullable();
            $table->longText('description');
            $table->string('language');
            $table->string('website_url', 2048);
            $table->timestamps();
        });

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('podcast_id')->unsigned();
            $table->string('title');
            $table->longText('description');
            $table->string('audio_url', 2048);
            $table->timestamps();

            $table->foreign('podcast_id', 'fk_episode_podcast_id')
               ->references('id')->on('podcasts')
               ->onUpdate('cascade')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('podcasts');
    }
}
