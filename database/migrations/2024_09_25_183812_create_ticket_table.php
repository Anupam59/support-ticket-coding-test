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
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('ticket_id');
            $table->string('ticket_title',200);
            $table->text('ticket_description')->nullable();

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
        Schema::dropIfExists('ticket');
    }
};
