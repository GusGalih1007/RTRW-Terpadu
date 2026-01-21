<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasUuids;
    // use SoftDeletes;

    protected $table = 'roles';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'roleId';

    protected $fillable = [
        'roleName',
        'description'
    ];

    public function user()
    {
        $this->hasMany(Users::class, 'roleId', 'roleId');
    }
}
