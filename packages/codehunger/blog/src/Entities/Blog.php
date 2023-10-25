<?php

namespace Codehunger\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Codehunger\Blog\Entities\ViewCount;
use Codehunger\Blog\Entities\BlogCategory;
use Codehunger\Blog\Entities\SubCategory;
use Codehunger\Blog\Entities\BlogReaction;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Category belongs to relationship with Knowledgebase  
     */
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Sub Category belongs to relationship with Knowledgebase   
     */
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }


    /**
     * Get reactions from Reactions Table
     */

    public function reactions()
    {
        return $this->hasMany(BlogReaction::class);
    }

    /**
     * This function is used to get the Like Count
     */

    public function getLikes()
    {
        return $this->reactions()->where('reaction', 'like')->count();
    }

    /**
     * This function is used to get the Dislike Count
     */

    public function getDislikes()
    {
        return $this->reactions()->where('reaction', 'dislike')->count();
    }

    /**
     * This function is used to get the views count
     */

    public function views()
    {
        return $this->morphMany(ViewCount::class, 'resourceable');
    }
}
