<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTimer extends Model
{
    use HasFactory;

    protected $table = 'timer';
    protected $primaryKey = 'timerid';
    // protected $keyType = '';
    public $timestamps = false;

    protected $guarded = [];

    public static function getAllTimer(){
        return self::paginate(1);
    }


}
