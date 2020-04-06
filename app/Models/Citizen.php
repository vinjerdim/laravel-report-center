<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citizen extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'phone',
    
    ];
    
    protected $hidden = [
        'password',
    
    ];
    
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/citizens/'.$this->getKey());
    }
}
