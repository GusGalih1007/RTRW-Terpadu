<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RtRw extends Model
{
    use HasUuids;

    protected $table = 'rt_rws';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'rtRwId';

    protected $fillable = [
        'nomor',
        'kodeProvinsi',
        'kodeKabupaten',
        'kodeKecamatan',
        'kodeKelurahan',
        'alamatDetail'
    ];

    public function user()
    {
        return $this->hasMany(Users::class, 'rtRwId', 'rtRwId');
    }
}
