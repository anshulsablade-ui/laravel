<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $primaryKey = 'city_id';

    protected $fillable = [
        'country_id',
        'city_name'
    ];

    public function country()
{
    return $this->belongsTo(Countries::class);
}
}
