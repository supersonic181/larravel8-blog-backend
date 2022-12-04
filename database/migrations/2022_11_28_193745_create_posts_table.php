<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId("author_id")->constrained("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("title");
            $table->mediumText("body");
            $table->string("thumbnail")->nullable();
            $table->enum("post_type",["text","video"]);
            $table->foreignId("category_id")->constrained("categories")->cascadeOnDelete()->cascadeOnUpdate();
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
