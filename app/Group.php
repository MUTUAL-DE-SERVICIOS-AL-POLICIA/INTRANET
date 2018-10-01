<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  public $timestamps = true;
  public $guarded = ['id'];
  protected $dates = ['deleted_at'];
  protected $fillable = ['shortened', 'name', 'color'];
}
