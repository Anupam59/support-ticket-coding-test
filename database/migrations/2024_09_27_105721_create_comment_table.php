<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->text('comment_text');
            $table->integer('ticket_id');

            $table->tinyInteger('status')->default(1);
            $table->integer('creator');
            $table->integer('modifier');
            $table->dateTime('created_date');
            $table->dateTime('modified_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
