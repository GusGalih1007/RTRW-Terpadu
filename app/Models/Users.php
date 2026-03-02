<?php

namespace App\Models;

use App\Enums\UserStatusOption;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
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
        'status',
        'roleVerifiedAt',
        'roleVerifiedBy',
        'appointedAt',
        'appointedBy',
        'kodeProvinsi',
        'kodeKabupaten',
        'kodeKecamatan',
        'kodeKelurahan',
        'alamatDetail',
        'rtRwId',
        'pekerjaan',
        'anggotaKeluarga',
        'latitude',
        'longitude',
        'email_verified_at',
        'qrImage',
        'createdBy'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'userId' => 'string',
        'roleId' => 'string',
        'status' => UserStatusOption::class,
        'roleverifiedAt' => 'datetime',
        'roleVerifiedBy' => 'string',
        'appointedAt' => 'datetime',
        'appointedBy' => 'string',
        'rtRwId' => 'string',
        'phone' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'encrypted',
        'createdBy' => 'string'
    ];

    // Relation belong to
    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'roleId');
    }

    public function rtrw()
    {
        return $this->belongsTo(RtRw::class, 'rtRwId', 'rtRwId');
    }

    public function createdby()
    {
        return $this->belongsTo(Users::class, 'createdBy', 'userId');
    }

    // Relation has many
    public function program()
    {
        return $this->hasMany(Program::class, 'createdBy', 'userId');
    }

    // Prunable
    public static function prunable()
    {
        return static::whereNull('email_verified_at')->where('created_at', '<', now()->subDay());
    }
}
