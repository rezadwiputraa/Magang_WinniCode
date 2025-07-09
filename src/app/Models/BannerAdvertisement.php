<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerAdvertisement extends Model
{
    protected $fillable = [
        'title',
        'thumbnail',
        'url',
        'status',
    ];
}
