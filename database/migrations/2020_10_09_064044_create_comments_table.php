<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigInteger('id', true, true);
            $table->text('description');
            $table->enum('status', ['approved', 'declined', 'neutral']);
            $table->integer('status_int');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');;
            $table->foreignId('phone_id')->constrained('phones')->onDelete('cascade');;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
