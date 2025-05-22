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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');// Foreign key
            $table->decimal('price', 10, 2);
            $table->decimal('tax', 5, 2);
            $table->string('assigned_name')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Allows soft deleting

            // Foreign key constraint
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade'); // Deletes products when category is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};