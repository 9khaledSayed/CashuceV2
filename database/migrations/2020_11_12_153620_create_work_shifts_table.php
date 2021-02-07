<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('work_days');
            $table->time('shift_start_time')->nullable();
            $table->time('shift_end_time')->nullable();
            $table->time('second_shift_start_time')->nullable();
            $table->time('second_shift_end_time')->nullable();
            $table->integer('work_hours')->nullable();
            $table->time('check_in_time')->nullable();
            $table->time('overtime_hours');
            $table->boolean('is_delay_allowed')->default(false);
            $table->boolean('is_default')->default(false);
            $table->time('time_delay_allowed')->nullable();
            $table->enum('type', ['normal', 'divided', 'flexible', 'once']);
            $table->timestamps();

            $table->unique(['company_id', 'name_ar']);
            $table->unique(['company_id', 'name_en']);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_shifts');
    }
}
