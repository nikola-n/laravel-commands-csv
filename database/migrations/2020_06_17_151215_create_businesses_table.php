<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('Industry_aggregation_NZSIOC');
            $table->string('Industry_code_NZSIOC');
            $table->string('Industry_name_NZSIOC');
            $table->string('Units');
            $table->string('Variable_code');
            $table->string('Variable_name');
            $table->string('Variable_category');
            $table->string('Value');
            $table->string('Industry_code_ANZSIC06');
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
        Schema::dropIfExists('businesses');
    }
}
