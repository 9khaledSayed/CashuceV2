<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('work_shift_id')->nullable();
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->unique(['company_id', 'job_number']); // 1 - 1 - 100   // 1 - 1 -100
            $table->string('name_ar')->nullable();
            $table->string('name_en');
//            $table->string('tname_ar')->nullable();
//            $table->string('lname_ar')->nullable();
//            $table->string('fname_en');
//            $table->string('sname_en')->nullable();
//            $table->string('tname_en')->nullable();
//            $table->string('lname_en')->nullable();
            $table->string('photo')->nullable(); // new
//            $table->string('city_name_ar')->nullable();
//            $table->string('city_name_en')->nullable();
            $table->string('job_number');
            $table->date('birthdate');
            $table->integer('marital_status')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('test_period')->nullable();
            $table->string('id_num');
            $table->date('id_issue_date')->nullable();
            $table->date('id_expire_date')->nullable();
            $table->string('passport_num')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->string('issue_place')->nullable();
//            $table->date('joined_date');
            $table->string('contract_type');
            $table->date('contract_start_date');
            $table->date('contract_end_date')->nullable();
            $table->integer('contract_period')->nullable();
            $table->string('allowance', 1000)->nullable();
            $table->string('phone');
            $table->integer('leave_balance')->default(30);
            $table->string('barcode');
            $table->boolean('service_status')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->decimal('salary')->default(0);
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on('employees');

            $table->foreign('work_shift_id')
                ->references('id')
                ->on('work_shifts');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
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
        Schema::dropIfExists('employees');
    }
}
