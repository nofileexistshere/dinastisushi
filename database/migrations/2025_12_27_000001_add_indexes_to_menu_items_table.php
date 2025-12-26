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
        Schema::table('menu_items', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index('category', 'idx_menu_items_category');
            $table->index(['average_rating', 'rating_count'], 'idx_menu_items_ratings');
            $table->index('created_at', 'idx_menu_items_created_at');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index(['user_id', 'created_at'], 'idx_orders_user_created');
            $table->index(['menu_item_id', 'created_at'], 'idx_orders_menu_created');
            $table->index('total_price', 'idx_orders_total_price');
        });

        Schema::table('ratings', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index(['user_id', 'menu_item_id'], 'idx_ratings_user_menu');
            $table->index(['menu_item_id', 'rating'], 'idx_ratings_menu_rating');
            $table->index('created_at', 'idx_ratings_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex('idx_menu_items_category');
            $table->dropIndex('idx_menu_items_ratings');
            $table->dropIndex('idx_menu_items_created_at');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user_created');
            $table->dropIndex('idx_orders_menu_created');
            $table->dropIndex('idx_orders_total_price');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex('idx_ratings_user_menu');
            $table->dropIndex('idx_ratings_menu_rating');
            $table->dropIndex('idx_ratings_created_at');
        });
    }
};
