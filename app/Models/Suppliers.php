<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
   protected $table = 'suppliers';

   protected $fillable = ['abbr', 'name', 'email', 'phone', 'address', 'logo'];



}