<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Validator;

class ApiController extends Controller{
	public function products(){
		$products = Product::with(['categories','images'])->get();
		return response()->json($products);
	}

	public function categories(){
		$categories = Category::get();
		return response()->json($categories);
	}

	public function saveCategories(Request $request){

		$validator = Validator::make($request->all(),[
			'name' => 'required|min:10';
			'image' => 'required';
		]);

		$name = $request->input("name");
		$url = $request->input("url_image");

		if(!$validator->fails()){
			$Category = Category::create({
				'name' => $name;
				'image' => $url
			});
		if(!empty($Category)){
			return renponse()->json($Category);
			}
		return renponse()->json(["message"=>"Erro ao salvar categoria",
								"erros" => $validator->errors()], 500);
		}
	}
}
?>