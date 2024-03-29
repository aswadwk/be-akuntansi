<?php

use App\Models\AccountType;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('position_normal', ['D', 'C'])->default('D');
            $table->decimal('balance', 20, 2)->default(0.00);
            $table->decimal('opening_balance', 20, 2)->default(0.00);
            $table->decimal('closing_balance', 20, 2)->default(0.00);
            $table->enum('position_report', ['balance sheet', 'profit and loss'])->default('balance sheet');

            $table->uuid('account_type_id');
            $table->foreign('account_type_id')
                ->references('id')
                ->on('account_types')
                ->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('accounts');
    }
};
