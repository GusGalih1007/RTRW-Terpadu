<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OtpType;

class OtpCode extends Model
{
    use HasUuids;

    protected $table = 'otp_codes';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'otpId';
    
    protected $fillable = [
        'userId',
        'codeType',
        'codeHash',
        'attempts',
        'expiresAt',
        'usedAt'
    ];

    protected $casts = [
        'userId' => 'string',
        'codeType' => OtpType::class,
        'expiresAt' => 'datetime',
        'usedAt' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'codeHash' => 'hashed',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'userId', 'userId');
    }

    public function isExpired()
    {
        return now()->greaterThan($this->expiresAt);
    }

    public function isUsed()
    {
        return ! is_null($this->usedAt);
    }
}
