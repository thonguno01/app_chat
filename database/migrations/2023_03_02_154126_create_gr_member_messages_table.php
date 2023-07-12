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
        Schema::create('gr_member_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('gr_message_id');
            $table->unsignedInteger('gr_receiver_id');
            $table->unsignedInteger('gr_sender_id');
            $table->unsignedInteger('gr_id');
            $table->string('status', 2);
            $table->timestamps();


            $table->foreign('gr_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('gr_message_id')->references('id')->on('gr_messages')->onDelete('cascade');
            $table->foreign('gr_sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gr_receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gr_members');
    }
};
