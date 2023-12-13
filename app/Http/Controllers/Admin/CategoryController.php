<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function index(){

        return view('admin.category.index');

    }
    public function create(){

        return view('admin.category.create');
    }
    public function store(CategoryFormRequest $request)
    {
    $validatedData = $request->validated();

    $category = new Category;
    $category->name = $validatedData['name'];
    $category->slug = Str::slug($validatedData['slug']);
    $category->description = $validatedData['description'];
    
    $uploadPath = 'uploads/category/';
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $ext;

        $file->move(public_path('uploads/category/'), $filename);
        $category->image = $uploadPath.$filename;
    }

    $category->meta_title = $validatedData['meta_title'];
    $category->meta_keyword = $validatedData['meta_keyword'];
    $category->meta_description = $validatedData['meta_description'];
    $category->status = $request->status == true ? '1' : '0';
    $category->save();

    return redirect('admin/category')->with('message', "Category Added Successfully!");
    }

    public function edit(Category $category){

        return view('admin.category.edit', compact('category'));

    }
    public function update(CategoryFormRequest $request, $category){

        $validatedData = $request->validated();
        
        $category = Category::findOrFail($category);

        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['slug']);
        $category->description = $validatedData['description'];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $uploadPath = 'uploads/category/';

            $path = 'uploads/category/'.$category->image;
            if(File::exists($path)){

                File::delete($path);

            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $ext;
    
            $file->move(public_path('uploads/category/'), $filename);
            $category->image = $uploadPath.$filename;
        }

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];

        $category->status = $request->status == true ? '1' : '0';
        $category->update();

        return redirect('admin/category')->with('message', "Category Updated Successfully!");
    }
    }

