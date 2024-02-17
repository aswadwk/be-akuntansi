<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code');
            $table->string('name');
            $table->enum('position_normal', ['D', 'C'])->default('D');
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_types');
    }
};
