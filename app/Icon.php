<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
  public $timestamps = true;
  public $guarded = ['id'];
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'content', 'format'];
}
