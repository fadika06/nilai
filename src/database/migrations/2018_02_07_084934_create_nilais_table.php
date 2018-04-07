<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('nilais', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->Integer('siswa_id');
			$table->decimal('akademik')->default(0);
			$table->decimal('prestasi')->default(0);
			$table->decimal('zona')->default(0);
			$table->decimal('sktm')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('nilais');
	}
}