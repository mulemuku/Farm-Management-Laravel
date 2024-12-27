<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number');
            $table->string('nrcs_number')->unique();
            $table->date('date_of_birth');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('next_of_kin');
            $table->string('email')->nullable();
            $table->string('type_of_farm');
            $table->enum('category', ['commercial', 'subsistent']);
            $table->double('land_area')->nullable();
            $table->string('nrc_passport_file')->nullable();
            $table->string('bank_statement')->nullable();
            $table->text('other_documents')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('farmers');
    }
};
