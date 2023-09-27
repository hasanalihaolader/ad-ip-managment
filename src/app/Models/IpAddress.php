<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    public const ID = 'id';
    public const IP = 'ip';
    public const LABEL = 'label';

    protected $table = 'ip_address';
    protected $fillable = [
        self::IP,
        self::LABEL,
    ];
}
