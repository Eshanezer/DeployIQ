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
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logs_id');
            $table->timestamp('timestamp')->nullable();
            $table->string('level')->nullable();
            $table->string('event_id')->nullable();
            $table->text('message')->nullable();
            $table->text('event_template')->nullable();
            $table->text('suggestion')->nullable();
            $table->string('pipeline_stage')->nullable();
            $table->string('technology_stack')->nullable();
            $table->string('triggered_by')->nullable();
            $table->string('error_level')->nullable();
            $table->string('security_vulnerability')->nullable();
            $table->string('error_impact_area')->nullable();
            $table->string('error_priority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
