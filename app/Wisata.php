<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    
    protected $table = 'wisatas';
    
    protected $fillable = [
        'placeName', 'vicinity', 'latitude', 'longitude',
    ];
    

}
