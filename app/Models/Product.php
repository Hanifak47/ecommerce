<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Product extends Model
{
    //
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [ // phpcs:ignore Zend.NamingConventions.ValidVariableName.PrivateNoUnderscore
        'title',
        'description',
        'price',
        'image',
        'image_mime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }


}
