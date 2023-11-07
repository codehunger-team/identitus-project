<?php

namespace Codehunger\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codehunger\Blog\Entities\SubCategory;
use Codehunger\Blog\Entities\Blog;

class BlogCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Sub Category has many relationship with Category 
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * This function is used to get the Knowledgebase Articles
     */

    public function blog()
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }
}
