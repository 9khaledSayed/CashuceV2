<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacation_type_id')->nullable();
            $table->string('reason_ar')->nullable();
            $table->string('reason_en')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->boolean('paid_in_advance')->default(false);
            $table->timestamps();

            $table->foreign('vacation_type_id')
                ->references('id')
                ->on('vacation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
