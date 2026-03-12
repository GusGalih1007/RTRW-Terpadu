<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class IuranSetting extends Model
{
    use HasUuids;

    protected $table = 'iuran_settings';

    protected $fillable = [
        'rtRwId',
        'amount',
        'startDate',
        'endDate',
        'isActive',
        'createdBy',
    ];

    protected $casts = [
        'rtRwId' => 'string',
        // 'amount' => 'float',
        'startDate' => 'date',
        'endDate' => 'date',
        'isActive' => 'boolean',
        'createdBy' => 'string',
    ];

    public function rtrw()
    {
        return $this->belongsTo(RtRw::class, 'rtRwId', 'rtRwId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy', 'userId');
    }
}
