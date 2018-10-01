<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  public $timestamps = true;
  public $guarded = ['id'];
  protected $fillable = ['icon_id','group_id','shortened', 'name', 'link', 'description'];
}
