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
    Schema::create('fields', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->float('area');
      $table->string('measurement_unit');
      $table->foreignId('made_by')->constrained('users')->onDelete('cascade');
      $table->integer('crops_planted')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('fields');
  }
};
