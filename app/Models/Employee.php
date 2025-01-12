<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Employee extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'emp_name',
        'emp_code',
        'emp_email',
        'emp_phone',
        'address',
        'designation',
        'emp_joining_date',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value) {

        $this->attributes['password'] = Hash::make($value);
    }
}