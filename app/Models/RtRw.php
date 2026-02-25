<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class RtRw extends Model
{
    use HasUuids;

    protected $table = 'rt_rws';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'rtRwId';

    protected $fillable = [
        'rt',
        'rw',
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

    public function program()
    {
        return $this->hasMany(Program::class, 'rtRwId', 'rtRwId');
    }

}
