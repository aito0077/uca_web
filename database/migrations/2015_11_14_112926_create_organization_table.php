<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name');
            $table->string('slug');

            $table->boolean('show_title')->default(true);
            $table->boolean('is_current')->default(false);

            $table->mediumText('slogan')->nullable();
            $table->longText('description')->nullable();
            $table->longText('details')->nullable();
            $table->longText('more_details')->nullable();

			$table->dateTime('start_event_date')->nullable();
			$table->dateTime('finish_event_date')->nullable();

            $table->mediumText('instagram_hashtag')->nullable();
            $table->mediumText('twitter_hashtag')->nullable();
            $table->mediumText('website')->nullable();

            $table->mediumText('main_picture')->nullable();
            $table->integer('media_id')->unsigned()->nullable();

            $table->boolean('remark')->default(false);


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
        Schema::drop('organizations');
    }
}
