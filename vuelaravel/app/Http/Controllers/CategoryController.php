<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Category;

class CategoryController extends Controller
{
  // space that we can use the repository from
    protected $model;

    public function __construct(Category $category)
    {
       // set the model
       $this->model = new Repository($category);
    }
    
    public function get()
    {
        return $categories = $this->model->all();
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