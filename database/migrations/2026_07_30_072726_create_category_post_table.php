<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['category_id', 'post_id']);
        });

        $posts = DB::table('posts')->whereNotNull('category_id')->get();
        foreach ($posts as $post) {
            DB::table('category_post')->insert([
                'category_id' => $post->category_id,
                'post_id' => $post->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });

        $pivotData = DB::table('category_post')->orderBy('id')->get();
        foreach ($pivotData as $pivot) {
            $post = DB::table('posts')->where('id', $pivot->post_id)->first();
            if ($post && is_null($post->category_id)) {
                DB::table('posts')->where('id', $pivot->post_id)->update(['category_id' => $pivot->category_id]);
            }
        }

        Schema::dropIfExists('category_post');
    }
};
