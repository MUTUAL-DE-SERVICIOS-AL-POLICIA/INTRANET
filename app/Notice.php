<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    public $timestamps  = true;
    public $guarded     = ['id'];
    protected $fillable = ['title', 'origin','content', 'active', 'correlative', 'year'];

    public function notice_type()
    {
        return $this->belongsTo(NoticeType::class);
    }
}
