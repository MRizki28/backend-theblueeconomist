<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_article', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('date');
            $table->string('image_article');
            $table->string('doc_image');
            $table->string('title');
            $table->string('author');
            $table->text('description');
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
        Schema::dropIfExists('tb_article');
    }
};
