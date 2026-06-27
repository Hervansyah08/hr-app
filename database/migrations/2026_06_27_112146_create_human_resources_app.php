<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // up ini untuk make/membuat
    public function up(): void
    {
        // Create departments table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // nullable: boleh jika deskripsinya kosong
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // nullable: boleh jika deskripsinya kosong
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Create employees table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            // unique ini setiap buat data baru harus unik/tidak boleh sama
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->text('address');
            $table->timestamp('birth_date');
            $table->timestamp('hire_date');
            // ini membuat relasi dengan tabel departments
            $table->foreignId('department_id')->constrained('departments');
            // ini membuat relasi dengan tabel roles
            $table->foreignId('role_id')->constrained('roles');
            $table->string('status');
            // ini nanti angka nya 10 digit maksimal, dan 2 digit dibelakang koma
            $table->decimal('salary', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create tasks table
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // nullable: boleh jika deskripsinya kosong
            $table->text('description')->nullable();
            // ini membuat relasi dengan tabel employees
            $table->foreignId('assigned_to')->constrained('employees');
            $table->timestamp('due_date');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create payroll/gaji table
        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            // ini membuat relasi dengan tabel employees
            $table->foreignId('employee_id')->constrained('employees');
            // ini nanti angka nya 10 digit maksimal, dan 2 digit dibelakang koma
            $table->decimal('salary', 10, 2);
            // nullable: boleh jika deskripsinya kosong
            $table->decimal('bonuses', 10, 2)->nullable();
            $table->decimal('deductions', 10, 2)->nullable();
            // ini nanti angka nya 10 digit maksimal, dan 2 digit dibelakang koma
            $table->decimal('net_salary', 10, 2);
            $table->timestamp('pay_date');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create attendance/absensi table
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            // ini membuat relasi dengan tabel employees
            $table->foreignId('employee_id')->constrained('employees');
            $table->timestamp('check_in');
            $table->timestamp('check_out');
            $table->date('date');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create leave_requests/izin cuti table
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            // ini membuat relasi dengan tabel employees
            $table->foreignId('employee_id')->constrained('employees');
            $table->string('leave_type');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    // down ini untuk drop/menghapus
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('presences');
        Schema::dropIfExists('payroll');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('departments');
    }
};
