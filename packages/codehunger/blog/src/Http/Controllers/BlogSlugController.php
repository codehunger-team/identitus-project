<?php

namespace Codehunger\Blog\Http\Controllers;

use Codehunger\Blog\Entities\Blog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Codehunger\Blog\Entities\SubCategory;
use Illuminate\Support\Str;
use Exception;

class BlogSlugController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | BlogSlugController
    |--------------------------------------------------------------------------
    |
    | This controller is used to handle the Slug create request.
    | It makes sure that the Slug is unique and it returns the unique slug if it is not unique
    |
    */

    /**
     * This function is used to create a slug
     * It received the Category, Sub-Category ID, Knowledgebase Title
     * Then it created the url e.g /category/sub-category/title-name-here
     * @method POST /admin/knowledgebase/check-slug
     * @return JSON
     */

    public function createSlug(Request $request)
    {
        try{
            $request->validate([
                'blog_category_id' => 'required|integer',
                'subcategory_id' => 'required|integer',
                'name' => 'required',
            ]);
            $categoryDetails = SubCategory::with('blogCategory')->where('id', $request->subcategory_id)->firstOrFail();
            $slug = Str::slug($categoryDetails['blogCategory']['name']) . '/' . Str::slug($categoryDetails['name']) . '/' . Str::slug($request->name);
            $uniqueSlug = $this->makeSlugUnique($slug);
            return response()->json([
                'status' => true,
                'slug' => $uniqueSlug,
                'message' => 'Slug Created Successfully'
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }


    /**
     * This function is used to check if the slug is available or not
     * If it's not available, it will return an error
     * @method POST /admin/knowledgebase/check-slug
     * @return JSON
     */

    public function checkAvailability(Request $request)
    {
        try{
            $request->validate([
                'slug' => 'required',
            ]);
            if(!Blog::where('slug', $request->slug)->first()){
                return response()->json([
                    'status' => true,
                    'message' => 'Slug Is Available'
                ]);
            }else{
                $slug = $this->makeSlugUnique($request->slug);
                return response()->json([
                    'status' => false,
                    'message' => 'Slug Is Not Available, We\'ve Updated The Slug',
                    'slug' => $slug,
                ], 422);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * This function is used to check if the slug is unique
     * It its unique, it returns the original slug
     * Else it adds random string in the end of the slug
     * @return String
     */

    public function makeSlugUnique($slug, $n = 0)
    {
        if(Blog::where('slug', $slug . ($n > 0 ? '-' .$n : ''))->first()){
            return $this->makeSlugUnique($slug, $n+1);
        }else{
            return $slug . ($n > 0 ? '-' .$n : '');
        }
    }
}
