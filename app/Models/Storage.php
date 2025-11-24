<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'driver', 'base_url', 'config', 'is_default'];

    protected $casts = [
        'config' => 'array',
        'is_default' => 'boolean',
    ];

    /**
     * get default Storage
     */
    public static function getDefault()
    {
        return self::where('is_default', true)->first();
    }

    public static function getImageFile($path, $storage_id = null)
    {
        $storage = Storage::where('id', $storage_id)->first();

        if (!$storage) {
            return asset('storage/' . $path); // default is local storage
        }

        if ($storage->name === 'local') {
            return asset('storage/' . $path);
        }

        // Nếu có base_url (ví dụ S3, Cloudflare R2)
        if ($storage->base_url) {
            return rtrim($storage->base_url, '/') . '/' . ltrim($path, '/');
        }

        return asset($path);
    }
}
