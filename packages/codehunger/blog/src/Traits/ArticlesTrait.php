<?php

namespace Codehunger\Blog\Traits;

use Codehunger\Blog\Entities\Blog;
use Codehunger\Blog\Entities\BlogCategory;
use Illuminate\Support\Facades\DB;
use Codehunger\Blog\Entities\SubCategory;
use Exception;

trait ArticlesTrait
{
    /*
    |
    |
    |
    | This Trais is used to get the Sidebar
    | It fetches the Sidebar Category, Knowledgebases, Popular Knowledgebase
    |
    |
    |
     */

    /**
     * This function is used to get the sidebar articles accordingly
     * @param $subcategory
     */

    public function getSidebarItems()
    {
        try {
            $categories = BlogCategory::take(5)->get();
            $recentKnowledgebases = Blog::take(5)->get();
            $popularKnowledgebases = $this->getPopularKnowledgebases();
            return [$categories, $recentKnowledgebases, $popularKnowledgebases];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This function is used to get the sidebar for category accordingly
     * @param $subcategory
     */

    public function getCategorySidebarItems()
    {
        try {
            $subcategories = SubCategory::take(5)->get();
            $recentKnowledgebases = Blog::take(5)->get();
            $popularKnowledgebases = $this->getPopularKnowledgebases();
            return [$subcategories, $recentKnowledgebases, $popularKnowledgebases];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This function is used to get the sidebar for sub-category accordingly
     * @param $subcategory
     */

    public function getSubCategorySidebarItems()
    {
        try {
            $categories = BlogCategory::take(5)->get();
            $recentKnowledgebases = Blog::take(5)->get();
            $popularKnowledgebases = $this->getPopularKnowledgebases();
            return [$categories, $recentKnowledgebases, $popularKnowledgebases];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This function is used to get the latest sidebar items
     * @return Knowledgebases
     */

    public function getPopularKnowledgebases()
    {
        try {
            $stats = [];
            $knowledgebases = Blog::select('id')->with('views')->get();
            if (count($knowledgebases) == 0) {
                return [];
            }
            foreach ($knowledgebases as $knowledgebase) {
                $stats[$knowledgebase['id']] = count($knowledgebase['views']);
            }
            arsort($stats);
            $firstFiveKnowledgebases = array_keys(array_slice($stats, 0, 4, true));
            $whereInOrder = implode(',', $firstFiveKnowledgebases);
            return Blog::select('name', 'slug')->whereIn('id', $firstFiveKnowledgebases)->orderByRaw(DB::raw("FIELD(id, $whereInOrder)"))->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
