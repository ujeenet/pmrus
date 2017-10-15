<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('resource_id');
            $table->integer('priority')->nullable();
            $table->string('title');
            $table->float('estimated_duration')->nullable();;
            $table->integer('real_duration')->nullable();
            $table->enum('status', ['on_hold','in_process','done','discard','additional'])->nullable();;
            $table->text('start_date')->nullable();;
            $table->text('finish_date')->nullable();;
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
        Schema::dropIfExists('checkpoints');
    }
}
