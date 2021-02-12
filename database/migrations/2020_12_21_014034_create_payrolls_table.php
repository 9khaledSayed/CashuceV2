<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('year_month');
            $table->date('date');
            $table->dateTime('issue_date');
            $table->integer('status')->default(0);
            $table->boolean('has_changes')->default(false);
            $table->boolean('include_attendance')->default(true);
            $table->integer('employees_no');
            $table->decimal('total_deductions');
            $table->decimal('total_net_salary')->default(0);
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

//            $table->unique(['company_id', 'year_month']);
            $table->unique(['company_id', 'provider_id', 'year_month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
