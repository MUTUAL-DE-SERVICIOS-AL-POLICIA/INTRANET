<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  public $timestamps = true;
  public $guarded = ['id'];
  protected $fillable = ['icon_id', 'group_id', 'shortened', 'name', 'href', 'href_manual', 'href_test', 'description'];

  public function icon()
  {
    return $this->belongsTo(Icon::class);
  }

  public function group()
  {
    return $this->belongsTo(Group::class);
  }
}
