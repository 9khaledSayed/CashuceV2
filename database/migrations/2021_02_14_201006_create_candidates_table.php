<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('name_en');
            $table->string('residence_profession')->nullable();
            $table->string('enterprise')->nullable();
            $table->string('id_num');
//            $table->string('phone');
            $table->text('skills')->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', [1,2,3,4])->default(1);
            $table->boolean('hr_approval')->default(false);
            $table->boolean('supervisor_approval')->default(false);
            $table->decimal('salary')->default(0);
            $table->date('birthdate');
            $table->date('interview_date');
            $table->date('training_start_date')->nullable();
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
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
        Schema::dropIfExists('candidates');
    }
}
