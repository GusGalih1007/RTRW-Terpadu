<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory, HasUuids;
    use Prunable;
    // use SoftDeletes;

    protected $table = 'users';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'userId';

    protected $fillable = [
        'nik',
        'username',
        'phone',
        'email',
        'password',
        'roleId',
        'kodeProvinsi',
        'kodeKabupaten',
        'kodeKecamatan',
        'kodeKelurahan',
        'alamatDetail',
        'pekerjaan',
        'anggotaKeluarga',
        'latitude',
        'longitude'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'roleId' => 'string',
        'phone' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        $this->belongsTo(Role::class, 'roleId', 'roleId');
    }

    public function prunable()
    {
        return static::whereNull('email_verified_at')->where('created_at', '<', now()->subDay());
    }
}
