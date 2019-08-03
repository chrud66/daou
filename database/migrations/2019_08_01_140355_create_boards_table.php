<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('고유번호');
            $table->unsignedBigInteger('author_id')->comment('작성자 고유 번호');
            $table->string('subject', 200)->comment('제목');
            $table->text('content')->comment('내용');
            $table->timestamp('created_at')->nullable()->comment('작성일시');
            $table->timestamp('updated_at')->nullable()->comment('수정일시');
            // $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
