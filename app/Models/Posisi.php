<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Posisi extends Model
{
    use HasFactory;

    protected $guarded =['id'];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public static function boot(){
        parent::boot();
        static::creating(function ($model){
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
