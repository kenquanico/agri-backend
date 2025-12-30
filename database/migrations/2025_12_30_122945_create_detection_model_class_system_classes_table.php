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
    Schema::create('detection_model_class_system_classes', function (Blueprint $table) {
      $table->foreignId('detection_model_class_id')->constrained('detection_model_classes');
      $table->foreignId('system_class_id')->constrained('classifications');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('detection_model_class_system_classes');
  }
};
