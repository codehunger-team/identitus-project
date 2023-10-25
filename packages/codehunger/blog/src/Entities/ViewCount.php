<?php

namespace Codehunger\Blog\Entities;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViewCount extends Model
{
    use HasFactory;
    
    protected $guarded = [];


    /**
     * This function is used to connect morph relations
     */

    public function views()
    {
        return $this->morphTo();
    }

}
