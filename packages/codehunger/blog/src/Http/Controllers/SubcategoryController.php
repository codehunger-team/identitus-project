<?php

namespace Codehunger\Blog\Http\Controllers;

use Codehunger\Blog\Entities\BlogCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Codehunger\Blog\Entities\Category;
use Codehunger\Blog\Entities\SubCategory;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Sub Category Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles to perform CRUD operations on Sub Category
    |
     */

    /**
     * Display a listing of the resource.
     * @method GET /admin/subcategory
     * @return Renderable
     */

    public function index()
    {
        $categories = BlogCategory::get();
        $subCategories = SubCategory::get();
        return view('blog::subcategory.index', compact('subCategories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @method POST /admin/subcategory/store
     * @param Request $request
     * @return Renderable
     */

    public function store(Request $request)
    {
        $validator = $this->validateInputs($request);
        SubCategory::create($validator->validated());
        return redirect()->route('admin.subcategory.index')->with('msg', "Blog Sub-Category Successfully Created");
    }

    /**
     * Show the form for editing the specified resource.
     * @method GET /admin/subcategory/edit
     * @param SubCategory $subcategory
     * @return Renderable
     */

    public function edit(SubCategory $subcategory)
    {
        return response()->json($subcategory);
    }

    /**
     * Update the specified resource in storage.
     * @method POST /admin/subcategory/update
     * @param Request $request, SubCategory $subcategory
     * @return Renderable
     */

    public function update(Request $request, SubCategory $subcategory)
    {

        $validator = $this->validateInputs($request);
        $subcategory->update($validator->validated());
        return redirect()->route('admin.subcategory.index')->with('msg', "Blog Sub-Category Successfully Created");
    }

    /**
     * Remove the specified resource from storage.
     * @method POST /admin/subcategory/subcategory-destroy
     * @param SubCategory $subcategory
     * @return Renderable
     */

    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['success' => 'true']);
    }

    /**
     * This function is used to validate the inputs
     */

    public function validateInputs($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required|max:200',
            'blog_category_id' => 'required|integer|exists:blog_categories,id'
        ]);

        if ($validator->fails()) {
            abort(redirect()->back()->with('msg', $validator->errors()->first()));
        }

        return $validator;
    }
}
