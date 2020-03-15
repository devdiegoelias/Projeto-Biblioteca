<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookImages;
use App\Models\Lendings;
use App\Models\BooksLendings;
use DB;
use Validator;


class bookController extends Controller
{

    private $path = 'images/book';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::get();
        $authors = Author::get();
        $selecionar_author = [];

        return view('book.index', compact('books', 'authors', 'selecionar_author'));
    }

    public function add()
    {
    	$authors = Author::get();
    	return view('book.add', compact('authors'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|max:255',
            'description' => 'required'
        ]);


        if(!$validator->fails()){
            $images = $request->file('images');

            $fileName = md5(time().rand(0,1000));
            $images->move($this->path, $fileName);

            $book = Book::create([
                'title' => $request->input('title'), 
                'description' => $request->input('description'),
                'image' => $fileName
            ]);

        }
        return redirect()->route('book.index');
    }

    public function edit($id)
    {
        $books = Book::find($id);

        if(!empty($books)){
            $authors = Author::get();
            $selecionar_author = array();

            foreach ($books->authors as $book) {
                $selecionar_author[] = $book->pivot->book_id;
            }
            return view('book.edit', compact('books', 'authors', 'selecionar_author'));
        }

        return redirect()->route('book.index');
    }

    public function update(Request $request, $id)
    {
        $image = $request->file('images');
        
        $fileName = md5(time().rand(0,1000));
        $image->move($this->path, $fileName);

        $update =[
                'title' => $request->input('title'), 
                'description' => $request->input('description'),
                'image' => $fileName
        ];


        $result = Book::find($id)->update($update);
        
        return redirect()->route('book.index');
    }

    public function delete($id)
    {
        $book = Book::find($id);

        $book->authors()->detach();
        $result = $book->delete();
        

        return redirect()->route('book.index');
    }

    public function search(Request $request){
        $select_cat = $request->input('book');

        $search = TRUE;

        $query = DB::table('books')->select('books.id', 'books.title','books.description')
                    ->join('books_authors','books.id', '=', 'books_authors.book_id')
                    ->join('authors', 'books_authors.book_id', '=', 'authors.id')
                    ->groupBy('books.id','books.title', 'books.description');

        if(!empty($name) && !empty($selecionar_author)){
            $query->where('books.title', 'like', '%'.$name.'%');
            $query->whereIn('authors.id', $selecionar_author);
        } else if(!empty($name)){
            $query->where('books.title', 'like', '%'.$name.'%');
        } else if(!empty($selecionar_author)){
            $query->whereIn('authors.id',$selecionar_author);
        }

        $authors = book::get();
        $books = $query->get();

        if(empty($selecionar_author)){
            $selecionar_author = [];
        }

        return view('book.index', compact('books','authors','selecionar_author','search'));

    }

}