<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('classifications', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description');
      $table->enum('type', ['pest', 'disease']);
      $table->enum('severity', ['low', 'medium', 'high', 'critical'])->nullable();
      $table->float('detection_threshold')->default(0.5);
      $table->float('alarm_threshold')->default(0.8);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('classifications');
  }
};
