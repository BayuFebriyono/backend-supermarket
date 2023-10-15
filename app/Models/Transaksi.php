<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Transaksi extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = ['id'];
    protected $primaryKet = 'id';

    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

}
