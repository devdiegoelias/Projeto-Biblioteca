<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
 	protected $fillable = ['name', 'description', 'title', 'image'];

    public function authors(){
        return $this->belongsToMany('App\Models\Book', 'books_authors');
    }

    public function images()    {
       return $this->hasMany('App\Models\BookImages');
    }
}