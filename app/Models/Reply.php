<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reply_time',
        'content',
        'officer_id',
        'report_id',

    ];


    protected $dates = [
        'reply_time',
        'deleted_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/replies/'.$this->getKey());
    }

    /* ************************ RELATIONS ************************ */
    public function officer()
    {
        return $this->belongsTo('App\Models\Officer');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\Report');
    }

    public function citizen()
    {
        return $this->hasOneThrough('App\Models\Citizen', 'App\Models\Report');
    }
}
