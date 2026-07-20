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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists')->cascadeOnDelete();
            $table->string('name');
            $table->text('details')->nullable();
            $table->boolean('starred')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->unsignedTinyInteger('priority')->nullable();        //1=low, 2=medium, 3=high
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['list_id', 'is_completed']);
            $table->index(['list_id', 'priority']);
            $table->index(['list_id', 'due_at']);
            $table->index(['list_id', 'starred']);
            $table->index('due_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
