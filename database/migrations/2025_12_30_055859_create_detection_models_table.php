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
    Schema::create('detection_models', function (Blueprint $table) {
      $table->id();
      $table->string('name');           // model name
      $table->string('description')->nullable(); // optional description
      $table->string('file_path');      // path to the .pt file
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('detection_models');
  }
};
