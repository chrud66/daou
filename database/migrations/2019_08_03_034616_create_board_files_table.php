<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_files', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('고유번호');
            $table->unsignedBigInteger('board_id')->comment('게시물 번호')->nullable()->index();
            $table->string('real_name')->comment('원본 파일명');
            $table->string('save_name')->comment('저장 파일명');
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
        Schema::dropIfExists('board_files');
    }
}
