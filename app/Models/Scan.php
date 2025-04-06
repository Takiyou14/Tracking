<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ScanObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ScanObserver::class])]
class Scan extends Model
{
    protected $fillable = [
        'package_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
