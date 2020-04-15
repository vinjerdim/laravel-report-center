<?php

namespace App\Models;

use App\Models\Officer;
use App\Models\Report;
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
        return [
            'admin' => url('/admin/replies/' . $this->getKey()),
            'officer' => url('/officer/replies/' . $this->getKey()),
            'citizen' => url('/citizen/replies/' . $this->getKey())
        ];
    }

    /* ************************ RELATIONS ************************ */
    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
