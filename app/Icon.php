<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
  public $timestamps = true;
  public $guarded = ['id'];
  protected $fillable = ['name', 'content', 'format'];
}
