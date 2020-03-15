<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookImages extends Model{

	protected $fillable = ['book_id', 'image'];

    public function product()    {
       return $this->belongsTo('App\Models\Book');
    }
}