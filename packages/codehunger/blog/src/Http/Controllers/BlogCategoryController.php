<?php

namespace Codehunger\Blog\Http\Controllers;

use Codehunger\Blog\Entities\BlogCategory;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | BlogCategoryController
    |--------------------------------------------------------------------------
    |
    | This controller is used to do CRUD operations on Blog Category
    |
    |
    */


    /**
     * Display a listing of the resource.
     * @method /admin/blog/category
     * @return Renderable
     */

    public function index()
    {
        $categories = BlogCategory::get();
        return view('blog::category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @method POST /admin/blog/category/store
     * @param Request $request
     * @return Renderable
     */

    public function store(Request $request)
    {
        try {
            $validator = $this->validateInputs($request);
            BlogCategory::create($validator->validated());
            return redirect()->back()->with('msg', "Blog Category Created Successfully");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @method Get/admin/blog/category/category-edit
     * @param BlogCategory $category
     * @return object
     */

    public function edit(BlogCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     * @method Post/admin/blog/category/update
     * @param Request $request, Category $category
     * @return Renderable
     */
    public function update(Request $request, BlogCategory $category)
    {
        try {
            $validator = $this->validateInputs($request);
            $category->update($validator->validated());
            return redirect()->back()->with('msg', 'Blog Category Successfully Updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     * @method Post /admin/category/delete
     * @param int $id
     * @return Renderable
     */
    public function destroy(BlogCategory $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }

    /**
     * This function is used to validate the input request
     * @return Boolean
     */

    public function validateInputs($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:200',
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
        return $validator;
    }
}
