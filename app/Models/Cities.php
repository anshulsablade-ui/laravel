<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';

    protected $primaryKey = 'city_id';

    protected $fillable = [
        'city_name',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id', 'country_id');
    }
}
