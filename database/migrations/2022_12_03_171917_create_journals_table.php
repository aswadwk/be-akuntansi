<?php

use App\Models\Account;
use App\Models\Devision;
use App\Models\Partner;
use App\Models\Transaction;
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
        Schema::create('journals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code');
            $table->timestamp('date');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['D', 'C'])->default('D');
            $table->text('description')->nullable();

            $table->uuid('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->uuid('devision_id')->nullable();
            $table->foreign('devision_id')
                ->references('id')
                ->on('devisions')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->uuid('partner_id')->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->uuid('transaction_id');
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->uuid('user_id');
            $table->foreign('user_id')
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
        Schema::dropIfExists('journals');
    }
};
