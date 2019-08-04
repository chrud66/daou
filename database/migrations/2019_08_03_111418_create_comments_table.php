<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('고유번호');
            $table->unsignedBigInteger('author_id')->comment('작성자 고유번호');
            $table->unsignedBigInteger('board_id')->comment('게시판 글 번호');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('부모 댓글 번호');
            $table->text('content')->comment('내용');
            $table->timestamp('created_at')->nullable()->comment('작성일시');
            $table->timestamp('updated_at')->nullable()->comment('수정일시');
            //$table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
