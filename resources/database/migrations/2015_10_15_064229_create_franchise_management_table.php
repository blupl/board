<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseManagementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('franchise_management', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('accredit_category', 20);
            $table->string('name_franchise');
            $table->string('name_applicant');
            $table->string('nationality');
            $table->string('passport_nid', 19);
            $table->string('role');
            $table->string('date_of_birth');
            $table->string('country_of_birth');
            $table->string('phone', 20);
            $table->string('passport_expire_date');
            $table->string('noc');
            $table->string('mail');
            $table->string('photo');
            $table->string('attachment');
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
		Schema::drop('franchise_management');
	}
}