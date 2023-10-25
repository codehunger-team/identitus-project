<?php

namespace Codehunger\Blog\Http\Controllers;

use Codehunger\Blog\Entities\Blog;
use Codehunger\Blog\Entities\BlogCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Codehunger\Blog\Entities\Knowledgebase;
use Codehunger\Blog\Entities\Category;
use Codehunger\Blog\Entities\SubCategory;
use Illuminate\Support\Facades\Validator;
use Exception;

class BlogController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Knowledgebase Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles to store data, edit data, update data
    | and show the data from the database on the index page. 
    |
    */


    /**
     * Display a listing of the resource.
     * @method GET /admin/blog
     * @return Renderable
     */

    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();
        return view('blog::blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     * @method POST /admin/blog/blog-create
     * @return Renderable
     */

    public function create()
    {
        $categories = BlogCategory::get();
        return view('blog::blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @method POST /admin/blog/blog-store
     * @param Request $request
     * @return Renderable
     */

    public function store(Request $request)
    {
        try {
            $validator = $this->validateInputs($request);
            Blog::create($validator->safe()->only([
                'name', 'slug', 'status', 'description', 'blog_category_id', 'subcategory_id', 'required',
                'meta_title', 'meta_description', 'meta_keywords'
            ]));
            return redirect()->route('blog.index')->with('success', __('knowledgebase::lang.knowledgebase_created'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @method GET /admin/blog/blog-edit
     * @param Blog $blog
     * @return Renderable
     */

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::get();
        $subcategories = Subcategory::where('blog_category_id', $blog->blog_category_id)->get(["name", "id"]);
        return view('blog::blog.edit', compact('subcategories', 'categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     * @method POST /admin/blog/blog-update
     * @param Request $request
     * @param Blog $blog
     * @return Renderable
     */

    public function update(Request $request, Blog $blog)
    {
        try {
            $validator = $this->validateInputs($request);
            $blog->update($validator->safe()->only([
                'name', 'slug', 'status', 'description', 'blog_category_id', 'subcategory_id', 'required',
            ]));
            return redirect()->route('blog.index')->with('success', 'Blog Details Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @method POST /admin/blog/blog-destroy
     * @param Blog $blog
     * @return Renderable
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('knowledgebase.index')
            ->with('success', 'Blog Name Deleted Successfully');
    }

    /**
     * Show the form for creating a new resource.
     * @method POST /admin/blog/blog-getsubcategory
     * @return Renderable
     */

    public function getsubcategory(Request $request)
    {
        try {
            $request->validate(['category_id' => 'required|integer']);
            $subcategoriesData = Subcategory::where('blog_category_id', $request->category_id)->select('id', 'name')->get();
            $subcategories = [];
            foreach ($subcategoriesData as $subcategory) {
                $subcategories[] = [
                    'id' => $subcategory['id'],
                    'name' => htmlspecialchars($subcategory['name']),
                ];
            }
            $data = [
                'subcategories' => $subcategories,
            ];
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * This function is used to validate the Inputs
     */

    public function validateInputs($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'blog_category_id' => 'required',
            'subcategory_id' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes',
            'meta_description' => 'sometimes',
            'meta_keywords' => 'sometimes',
        ]);

        if ($validator->fails()) {
            abort(redirect()->back()->withInputs($request->all())->withErrors($validator->errors()));
        }

        return $validator;
    }
}
