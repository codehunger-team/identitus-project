<?php

namespace Codehunger\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codehunger\Blog\Entities\SubCategory;

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

    public function department()
    {
        return $this->belongsToMany('Modules\Department\Entities\Department');
    }

    /**
     * Get records associated to tickets
     */

    public function tickets()
    {
        return $this->hasMany('Modules\Ticketfields\Entities\Ticket');
    }

    /**
     * This function is used to get the Knowledgebase Articles
     */

    public function knowledgebase()
    {
        return $this->hasMany('Modules\Knowledgebase\Entities\Knowledgebase', 'category_id');
    }
}
