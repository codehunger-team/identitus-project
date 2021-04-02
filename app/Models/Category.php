<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // fillable
    protected $fillable = ['catname'];

    // set relationship to domains
    public function domain() {
    	return $this->hasMany(Domain::class, 'category');
    }

}
