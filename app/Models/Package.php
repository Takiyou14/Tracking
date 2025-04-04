<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Package extends Model
{
    use HasUuids;

    protected $fillable = [
        'description',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
