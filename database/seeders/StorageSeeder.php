<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('storages')->insert([
            ['name' => 'local', 'driver' => 'local', 'base_url' => null, 'config' => json_encode([]), 'is_default' => true],
            ['name' => 's3', 'driver' => 's3', 'base_url' => 'https://s3.amazonaws.com', 'config' => json_encode(['bucket' => 'your-bucket-name']), 'is_default' => false],
            ['name' => 'cloudflare_r2', 'driver' => 's3', 'base_url' => env('CLOUD_FLARE_R2_BASE_URL'), 'config' => json_encode(['bucket' => env('CLOUD_FLARE_R2_BUCKET'), 'secret_key' => env('CLOUD_FLARE_R2_SECRET_KEY'), 'access_key' => env('CLOUD_FLARE_R2_ACCESS_KEY')]), 'is_default' => false],
        ]);
    }
}
