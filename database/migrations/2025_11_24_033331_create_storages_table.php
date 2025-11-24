<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('driver');
            $table->string('base_url')->nullable();
            $table->json('config');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        if(Schema::hasTable('ads_creatives')) {
            Schema::table('ads_creatives', function (Blueprint $table) {
                $table->dropForeign(['storage_id']);
            });
        }

        Schema::dropIfExists('storages');
    }
    
};
