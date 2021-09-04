<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('secret_code');
            $table->integer('type');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('ticket_current')->nullable();
            $table->integer('ticket_last')->nullable();
            $table->integer('ticket_limit')->nullable();
            $table->datetime('valid_until')->nullable();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('queues');
    }
}
