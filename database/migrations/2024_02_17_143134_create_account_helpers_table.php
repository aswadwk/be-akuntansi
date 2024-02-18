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
        Schema::create('account_helpers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code');
            $table->string('name');
            $table->string('account_type', 20); // HUTANG', 'PITANG in enlish -> DEBIT, CREDIT
            $table->enum('type', ['D', 'C'])->default('D'); // saldo awal
            $table->text('description')->nullable();

            $table->uuid('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_helpers');
    }
};
