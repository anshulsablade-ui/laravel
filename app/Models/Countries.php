<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Countries extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'country_id';

    protected $fillable = [
        'country_name'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(Cities::class, 'country_id', 'country_id');
    }
}
