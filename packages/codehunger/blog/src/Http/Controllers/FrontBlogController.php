<?php

namespace Codehunger\Blog\Http\Controllers;

use Codehunger\Blog\Entities\Blog;
use Codehunger\Blog\Entities\BlogCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Codehunger\Blog\Entities\SubCategory;
use Codehunger\Blog\Traits\ReactionTrait;
use Codehunger\Blog\Traits\ViewsCounterTrait;
use Codehunger\Blog\Traits\ArticlesTrait;
use Illuminate\Support\Str;
use Exception;

class FrontBlogController extends Controller
{

    use ReactionTrait, ViewsCounterTrait, ArticlesTrait;

    /*
    |--------------------------------------------------------------------------
    | FrontBlogController
    |--------------------------------------------------------------------------
    |
    | This controller handels the frontend Knowledgebase requests
    |
    |
     */

    /**
     * Display a listing of the resource.
     * @method GET /blog/
     * @return Renderable
     */

    public function index()
    {
        $blogs = Blog::with('blogCategory')->get();
        $popularBlogs = $this->getPopularBlogs();
        $recentBlogs = Blog::select('name', 'slug')->take(7)->get();
        return view('blog::frontpage.index', compact('blogs', 'popularBlogs', 'recentBlogs'));
    }

    /**
     * This function is used to show the Knowledgebase article
     * @method GET /blog/{slug}
     * @return Renderable
     */

    public function articleShow($category, $subCategory, $slug)
    {
        try {
            $fullSlug = $category . '/' . $subCategory . '/' . $slug;
            $blog = Blog::with('blogCategory')->where('slug', $fullSlug)->withCount('views')->firstOrFail();
            $recentBlogs = Blog::with('blogCategory')->take(5)->get();
            return view('blog::frontpage.article', compact('blog', 'recentBlogs'));
        } catch (Exception $e) {
            abort(404);
        }
    }


    /**
     * This function is used to search for the Knowledgebase
     * @param Request
     * @method GET /knowledgebase/search/
     * @return JSON
     */

    public function search(Request $request)
    {
        try {
            $request->validate([
                'q' => 'required|max:100',
            ]);
            $results = Blog::where('name', 'LIKE', '%' . $request->q . '%')->get();
            if (count($results) != 0) {
                $response = '<ul class="sidebar-search-dropdown-menu homesearchresults ps p-2">';
                foreach ($results as $result) {
                    $response .= '<a href="' . route('frontknowledgebase.slug.maker', $result['slug']) . '" class="q-search-results text-muted d-flex" style="color:black;"><li class="p-1 rounded w-100">' . htmlspecialchars($result['name']) . '<span class="badge bg-success-transparent text-success float-end fs-11">' . $result['subcategory']['name'] . '</span></li></a>';
                }
                return $response . '</ul>';
            } else {
                return '<ul class="sidebar-search-dropdown-menu homesearchresults ps p-2"><li class="p-1 rounded text-muted">No Results</li></ul>';
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * This function is used to store the reactions
     * @method POST /knowledgebase/reaction/
     * @retun JSON
     */

    public function reaction(Request $request)
    {
        try {
            $request->validate([
                'reaction' => 'required:in:like,dislike',
                'id' => 'required|exists:knowledgebases,id',
            ]);
            $this->registerReaction($request);
            $data = $this->getReactions($request->id);
            return response()->json(['success' => true, 'message' => 'OK', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Return the category Display Page
     * @method GET /category/{category}
     * @param String $category
     * @return Renderable
     */

    public function categoryShow($category)
    {
        try {
            $slugToWord = Str::title(str_replace('-', ' ', $category));
            $category = BlogCategory::where('name', 'like', '%' . $slugToWord . '%')->first();
            $blogs = $category->blog()->paginate(5);
            $recentBlogs = Blog::with('blogCategory')->take(5)->get();
            return view('blog::frontpage.category-show', compact('category', 'blogs', 'recentBlogs'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Return the sub-category Display Page
     * @method GET /sub-category/{subcategory}
     * @param String $category
     * @return Renderable
     */

    public function subCategoryShow($subcategory)
    {
        try {
            $slugToWord = Str::title(str_replace('-', ' ', $subcategory));
            $subCategory = SubCategory::where('name', 'like', '%' . $slugToWord . '%')->first();
            $articles = $subCategory->knowledgebase()->withCount('views')->paginate(5);
            [$categories, $recentKnowledgebases, $popularKnowledgebases] = $this->getSubCategorySidebarItems();
            return view('knowledgebase::frontpage.subcategory-show', compact('subCategory', 'articles', 'categories', 'recentKnowledgebases', 'popularKnowledgebases'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
