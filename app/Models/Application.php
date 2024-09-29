<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Application extends Model
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
        'date',
        'quantity',
        'origin_agency_id',
        'destination_agency_id',
        'status',
        'user_id',
        'modified_user_id'
    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modifiedUser(){
        return $this->belongsTo(User::class, 'modified_user_id');
    }

    public function originAgency(){
        return $this->belongsTo(Agency::class, 'origin_agency_id');
    }

    public function destinationAgency(){
        return $this->belongsTo(Agency::class, 'destination_agency_id');
    }


}
