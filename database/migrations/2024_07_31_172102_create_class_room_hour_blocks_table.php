<?php

use Carbon\WeekDay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_room_hour_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hour_block_id')
                    ->constrained('hour_blocks')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('class_room_id')
                    ->constrained('class_rooms')
                    ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->enum('weekday', [
                WeekDay::Monday->value,
                WeekDay::Tuesday->value,
                WeekDay::Wednesday->value,
                WeekDay::Thursday->value,
                WeekDay::Friday->value,
                WeekDay::Saturday->value,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_room_hour_blocks');
    }
};
