<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prodacts extends Model
{
    protected $table = "prodacts";
    protected $fillable = ['prodact_name','description','section_id'];
    protected $hidden = ['section_id'];
    public $timestamps = true;

    public function sections()
    {
        return $this->belongsTo(sections::class, 'section_id', 'id');
    }

}
