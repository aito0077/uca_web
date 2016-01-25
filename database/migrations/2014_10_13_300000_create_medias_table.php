<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration {

	public function up() {
		Schema::create('medias', function(Blueprint $table) {
			$table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('type', ['VIDEO', 'IMAGE', 'DATA'])->default('IMAGE');

            $table->string('name');
            $table->string('ext');
            $table->string('title')->nullable();

            $table->string('author')->nullable();
            $table->string('link')->nullable();
            $table->mediumtext('description')->nullable();

            $table->mediumtext('path')->nullable();
            $table->mediumtext('tags')->nullable();

            $table->string('bucket')->nullable();

            $table->mediumtext('thumb_path')->nullable();
            $table->mediumtext('url')->nullable();

            $table->boolean('cloud')->default(false);
            $table->boolean('disabled')->default(false);

			$table->timestamps();
		});
	}

	public function down() {
		Schema::drop('medias');
	}


}


