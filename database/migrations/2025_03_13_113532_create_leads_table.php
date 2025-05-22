<?php

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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->longText('address')->nullable(); // Address should be longText if needed
            $table->string('purpose')->nullable();
            $table->json('product_ids')->nullable();
            $table->enum('status', ['New', 'Demo', 'Quotation', 'Pending', 'Done', 'Cancel'])->default('New');
            $table->string('source')->nullable();
            $table->string('assigned_by')->nullable();
            $table->longText('remarks')->nullable();
            $table->boolean('mail_status')->default(0);
            $table->date('demo_date')->nullable();
            $table->time('demo_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
