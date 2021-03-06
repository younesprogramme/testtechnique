<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Product;

class ProductController extends Controller
{
  // space that we can use the repository from
    protected $model;
    protected $fillable = ['name'];

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
        return $Products = $this->model->delete($id);
    }

    public function store(Request $request)
    {
        $Products = $this->model->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $request->image
            ]);
            
         return   'Product added successfully';
            
    }

    public function show(Request $request)
    {
        $id=$request->id;
       return   $Products = $this->model->show($id);
    }

    public function update(Request $request)
    {
        $filldata = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $request->image
            ];
         $Products = $this->model->update($filldata,$request->id);
    }

    public function destroy($id)
    {
       return $this->model->delete($id);
    }
    public function uploadFile(Request $request)
{
    $request->file('image')->store('ProductImages', 'public');
          
    // return response()->json(['success'=>'You have successfully upload file.']);
    $data= $request->file('image')->store('ProductImages', 'public');
    return $data;
}
}