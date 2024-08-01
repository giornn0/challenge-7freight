<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booked_classes', function (Blueprint $table) {
            $table->foreignId('class_room_hour_block_id')
                    ->constrained('class_room_hour_blocks')
                    ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                    ->constrained('students')
                    ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('was_canceled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_classes');
    }
};
