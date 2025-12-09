<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('premium_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->unsignedInteger('max_uses')->default(1);
            $table->unsignedInteger('used_count')->default(0);

            $table->enum('status', ['active', 'inactive', 'expired', 'exhausted'])
                ->default('active');

            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('premium_codes');
    }
};
