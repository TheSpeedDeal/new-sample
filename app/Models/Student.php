<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';
    protected $primaryKey = 'studid';
    // protected $keyType = '';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public static function getAllStudents(){
        return self::paginate(10);
    }
}
