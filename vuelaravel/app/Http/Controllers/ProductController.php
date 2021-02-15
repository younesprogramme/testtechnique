<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Product;

class ProductController extends Controller
{
  // space that we can use the repository from
    protected $model;

    public function __construct(Product $product)
    {
       // set the model
       $this->model = new Repository($product);
    }
   
    public function get()
    {
        return $products = $this->model->all();       
    }

    public function filter(Request $request)
    {
        $products=$request->category;
        return $this->model->filter($products);
    }

    public function sort(Request $request)
    {
        $orderby = $request->orderby;
        $sortby = $request->sortby;
        return $product = Product::orderBy($sortby,$orderby)->get();

    }
    public function delete(Request $request)
    {
        $id = $request->id;
        // Produit::whereIn('id', $request->id)->delete(); // $request->id MUST be an array
        // return response()->json('Product deleted');
        //return Product::where('id', $id)->first()->delete();
        return $Products = $this->model->delete($id);
    }

    public function store(Request $request)
    {
        return $this->model->create($request->all());
    }

    public function show($id)
    {
       return $this->model->show($id);
    }

}