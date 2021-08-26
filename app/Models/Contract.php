<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    // protected $table = 'contracts';
    protected $guarded = [];

    // set primary key to Contract
    public $primaryKey = 'contract_id';

    public function domain()
    {
        return $this->belongsTo('\App\Models\Domain');
    }
}
