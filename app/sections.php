<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $table = "sections";
    protected $fillable = ['section_name','description','Created_By'];
    public $timestamps = true;


        // public function prodacts()
        // {
        //     return $this->belongsTo(prodacts::class, 'section_id', 'id');
        // }

}
