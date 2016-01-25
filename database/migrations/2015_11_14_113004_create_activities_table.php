<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration {

    public function up() {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->longText('coordinators')->nullable();

            $table->longText('description')->nullable();
            $table->longText('details')->nullable();

			$table->dateTime('event_date')->nullable();

            $table->mediumText('main_picture')->nullable();
            $table->integer('media_id')->unsigned()->nullable();

            $table->string('link')->nullable();

            $table->string('twitter_hashtag')->nullable();
            $table->string('instagram_hashtag')->nullable();

            $table->boolean('remark')->default(false);
            $table->boolean('novelty')->default(false);

            $table->timestamps();
        });


    }

    public function down() {
        Schema::drop('activities');
    }

}
