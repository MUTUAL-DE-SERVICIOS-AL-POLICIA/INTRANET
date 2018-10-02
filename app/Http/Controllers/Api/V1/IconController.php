<?php

namespace App\Http\Controllers\Api\V1;

use App\Icon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Input as Input;

class IconController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $icons = Icon::get();
    return $icons;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {  
    $icon = Icon::create($request->all());
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $file->move('uploads', $file->getClientOriginalName());
    }
    return $icon;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Icon  $icon
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Icon::find($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Icon  $icon
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $icon = Icon::findOrFail($id);
    $icon->fill($request->all());
    $icon->save();
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $file->move('uploads', $file->getClientOriginalName());
    }
    return $icon;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Icon  $icon
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $icon = Icon::findOrFail($id);
    $icon->delete();
    return $icon;
  }
}
