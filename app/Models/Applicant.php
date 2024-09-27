<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Applicant extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted(){
        static::creating(function ($model){
            $model->id = Str::uuid();
        });
    }

    protected $fillable = [
        'name',
        'status',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
