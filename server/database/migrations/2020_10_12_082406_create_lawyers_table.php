<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawyersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lawyers', function (Blueprint $table) {
			$table->integer('lawyer_id')->comment('弁護士登録番号')->unique();
			$table->string('last_name')->comment('姓');
			$table->string('last_name_kana')->comment('姓カナ');
			$table->string('first_name')->comment('名');
			$table->string('first_name_kana')->comment('名カナ');
			$table->tinyInteger('gender')->length(1)->comment('性別');
			$table->string('face_photo')->comment('顔写真')->nullable();
			$table->string('email')->comment('登録メールアドレス')->nullable();
			// パスワードはとりあえずNULL許容しておく→後で変更する
			$table->string('password')->comment('パスワード')->nullable();
			$table->integer('tel')->comment('電話番号')->nullable();
			$table->integer('fax')->comment('ファックス番号')->nullable();
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
		Schema::dropIfExists('lawyers');
	}
}
