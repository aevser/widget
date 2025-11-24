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
        // Статусы заявок
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('ticket_statuses')->insert([
            [
                'name' => 'Новый',
                'type' => 'new',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'В работе',
                'type' => 'in_progress',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Обработан',
                'type' => 'processed',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Заявки
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('ticket_statuses')->cascadeOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->timestamp('manager_replied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_statuses');
    }
};
