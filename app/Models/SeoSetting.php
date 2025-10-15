<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type', 'page_id', 'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'custom_head_tags'
    ];

    public static function getForPage($pageType, $pageId = null)
    {
        return self::where('page_type', $pageType)
            ->where('page_id', $pageId)
            ->first();
    }
}