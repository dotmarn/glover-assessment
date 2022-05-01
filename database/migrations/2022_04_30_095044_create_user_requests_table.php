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
            $table->unsignedBigInteger('admin_id');
            $table->integer('user_id')->nullable();
            $table->enum('request_type',['create', 'update', 'delete']);
            $table->json('payload')->nullable();
            $table->enum('status',['pending', 'approved', 'declined'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')
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
