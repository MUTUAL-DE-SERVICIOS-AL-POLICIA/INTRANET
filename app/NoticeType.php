<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeType extends Model
{
    public $timestamps  = true;
    public $guarded     = ['id'];
    protected $fillable = ['name', 'shortened', 'description'];

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}
