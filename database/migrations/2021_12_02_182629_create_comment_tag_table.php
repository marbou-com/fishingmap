<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id'); //この行を追加
            $table->unsignedBigInteger('comment_id'); //この行を追加
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade'); //この行を追加
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
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
        Schema::dropIfExists('comment_tag');
    }
}
