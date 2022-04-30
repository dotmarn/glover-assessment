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
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requester_id');
            $table->integer('user_id');
            $table->enum('request_type',['create', 'update', 'delete']);
            $table->json('payload');
            $table->enum('status',['pending', 'approved', 'declined'])->default('pending');
            $table->unsignedBigInteger('approved_by');
            $table->timestamps();

            $table->foreign('requester_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('approved_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
};