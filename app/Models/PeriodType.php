<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodType extends Model
{
    //table name
    protected $table = 'period_types';

    // set primary key to catID
    public $primaryKey = 'id';

}
