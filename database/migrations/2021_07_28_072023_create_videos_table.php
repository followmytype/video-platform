<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->comment('唯一字串id');
            $table->unsignedBigInteger('channel_id')->comment('所屬的頻道id');
            $table->string('title')->comment('標題');
            $table->text('description')->nullable()->comment('影片敘述');
            $table->integer('views')->default(0)->comment('觀看次數');
            $table->text('path')->nullable()->comment('檔名');
            $table->string('thumbnail_image')->nullable();
            $table->string('processed_file')->nullable();
            $table->enum('visibility', ['private', 'public', 'unlisted'])->default('private')->comment('觀看權限');

            $table->boolean('processed')->default(false);
            $table->boolean('allow_likes')->default(false)->comment('允許點讚');
            $table->boolean('allow_comments')->default(false)->comment('允許評論');

            $table->string('processing_percentage')->default(false);

            $table->foreign('channel_id')->references('id')->on('channels')
                ->onDelete('cascade');

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
        Schema::dropIfExists('videos');
    }
}
