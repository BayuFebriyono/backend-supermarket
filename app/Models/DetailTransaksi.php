<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public static function boot(){
        parent::boot();
        static::creating(function ($model){
            return $model->id = Uuid::uuid4()->toString();
        });
    }
}
