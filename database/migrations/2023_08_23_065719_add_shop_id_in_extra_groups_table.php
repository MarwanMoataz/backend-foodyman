<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShopIdInExtraGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
	{
        Schema::table('extra_groups', function (Blueprint $table) {
            $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
	{
        Schema::table('extra_groups', function (Blueprint $table) {
            $table->dropForeign('extra_groups_shop_id_foreign');
			$table->dropColumn('shop_id');
        });
    }
}
