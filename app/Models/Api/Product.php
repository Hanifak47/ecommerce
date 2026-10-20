<?php
// pastikan namespace benar
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Override;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// pastikan extends dari induk pada model utama
class Product extends \App\Models\Product
{
    public function getRouteKeyname()
    {
        return 'id';
    }

}
