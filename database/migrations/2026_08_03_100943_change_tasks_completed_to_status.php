<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('description');
        });

        // ترحيل البيانات القديمة للحفاظ عليها
        DB::table('tasks')->where('completed', true)->update(['status' => 'completed']);
        DB::table('tasks')->where('completed', false)->update(['status' => 'pending']);

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('completed')->default(false)->after('note');
        });

        // استعادة البيانات القديمة
        DB::table('tasks')->where('status', 'completed')->update(['completed' => true]);

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
