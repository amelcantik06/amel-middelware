<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_reference', 100)->nullable()->after('customer_name');
            $table->unsignedBigInteger('subtotal')->default(0)->after('total');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('subtotal');
            $table->unsignedBigInteger('discount_amount')->default(0)->after('discount_percent');
            $table->unsignedBigInteger('tax_amount')->default(0)->after('discount_amount');
            $table->unsignedBigInteger('additional_fee')->default(0)->after('tax_amount');
            $table->string('payment_method', 30)->default('cash')->after('change_due');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_reference',
                'subtotal',
                'discount_percent',
                'discount_amount',
                'tax_amount',
                'additional_fee',
                'payment_method',
            ]);
        });
    }
};
