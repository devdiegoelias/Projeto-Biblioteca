<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lendings extends Model
{
	//protected $fillable = ['name', 'surmame'];

    public function books()    {
       return $this->belongsToMany('App\Models\Book', 'books_lendings');
    }
}
