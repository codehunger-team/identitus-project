<?php

namespace Codehunger\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codehunger\Blog\Entities\BlogCategory;
use Codehunger\Blog\Entities\Blog;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Category belongs to relationship with Sub Category  
     */
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * This function is used to get the Knowledgebase Articles
     */

    public function blog()
    {
        return $this->hasMany(Blog::class, 'subcategory_id');
    }
}
