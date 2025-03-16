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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('appointment_datetime');
            $table->string('client_name');
            $table->string('egn', 10)->comment('ЕГН на клиента');
            $table->text('description')->nullable();
            $table->enum('notification_method', ['sms', 'email'])->default('email');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Индекси за по-бързо търсене
            $table->index('appointment_datetime');
            $table->index('egn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
