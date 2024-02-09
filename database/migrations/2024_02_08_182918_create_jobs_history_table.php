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
        Schema::create('jobs_history', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id');
            $table->uuid('job_id');
            $table->longText('payload');
            $table->string('errors')->nullable();

            $table->foreign('batch_id')
                ->references('id')
                ->on('job_batches')
                ->onDelete('cascade');

            $table->index(['batch_id', 'job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_history');
    }
};
