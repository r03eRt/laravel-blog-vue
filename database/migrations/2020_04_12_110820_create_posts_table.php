<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            //creamos el schema
            $table->string('title');
            // ponemos unique para que no se repitan la url
            $table->string('url')->unique();
            $table->mediumText('iframe')->nullable();
            $table->mediumText('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            // Para dar a cada post un usuario, no e snulo porque todos los post tienen suaurio
            $table->integer('user_id')->unsigned();

            // Con esta sentencia hacemos que cuando se elimine un usuairo se eliminen los posts del usuario
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('posts');
    }
}
