<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Lendings;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function livraria()
    {
        $books = Book::get();
        $authors = Author::get();

        /*$books = DB::select('SELECT * FROM books b
                                LEFT JOIN books_lendings bl ON(b.id = bl.book_id)
                                LEFT JOIN lendings l ON(bl.lendings_id = l.id)');*/

        return view('welcome', compact('books', 'authors'));
    }

    public function alugar($id)
    {
        $dateAtual = date("Y-m-d H:m:s");
        $dateDevolucao = date("Y-m-d  H:m:s", strtotime("+ 7 days", strtotime($dateAtual)));
        $id_usuario = Auth::id();


        DB::insert('INSERT INTO lendings (user_id, date_start, date_end) VALUES(:id_user, :dateAtual, :dateDevolucao)',[
            'id_user' => $id_usuario,
            'dateAtual' => $dateAtual,
            'dateDevolucao' => $dateDevolucao
        ]);

        $ultinsert = DB::select('SELECT id FROM lendings ORDER BY id DESC LIMIT 1');

        DB::insert('INSERT INTO books_lendings (lendings_id, book_id) VALUES(:lending_id, :book_id)',[
            'lending_id' => $ultinsert[0]->id,
            'book_id' => $id
        ]);


        return redirect()->route('livraria');
    }

    public function devolver($id)
    {
        $dateAtual = date("Y-m-d H:m:s");
        DB::update('UPDATE lendings SET date_finish = :dateAtual',[':dateAtual' => $dateAtual]);

        return redirect()->route('livraria');
    }
}
