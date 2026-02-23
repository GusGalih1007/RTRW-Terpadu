<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasUuids;

    protected $table = 'programs';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'programId';

    protected $fillable = [
        'rtRwId',
        'name',
        'description',
        'startDate',
        'endDate',
        'budget',
        'isFundedByIuran',
        'creatdBy',
    ];

    protected $casts = [
        'rtRwId' => 'string',
        'startDate' => 'date',
        'endDate' => 'date',
        'isFundedByIuran' => 'boolean',
        'createdBy' => 'string',
    ];

    //Relation
    public function rtrw()
    {
        return $this->belongsTo(RtRw::class, 'rtRwId', 'rtRwId');
    }

    public function createdBy()
    {
        return $this->belongsTo(Users::class, 'createdBy', 'userId');
    }
}
