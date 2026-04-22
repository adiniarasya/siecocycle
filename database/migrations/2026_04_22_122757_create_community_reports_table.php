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
        Schema::create('community_reports', function (Blueprint $table) {
            $table->id();
            $table->string('rw_name', 20);
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_weight', 12, 2)->default(0);
            $table->decimal('total_co2', 12, 2)->default(0);
            $table->decimal('total_saving', 15, 2)->default(0);
            $table->string('file_pdf', 255)->nullable();
            $table->timestamps();

            $table->index(['rw_name', 'period_start', 'period_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_reports');
    }
};