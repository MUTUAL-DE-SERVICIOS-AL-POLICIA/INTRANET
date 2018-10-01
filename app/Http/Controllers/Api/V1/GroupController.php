<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $groups = Group::get();

    foreach ($groups as $group) {
      $services = $group->services;
      foreach ($services as $service) {
        $service->icon;
      }
    }

    return $groups;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    return Group::create($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Group::find($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $group = Group::findOrFail($id);
    $group->fill($request->all());
    $group->save();
    return $group;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $group = Group::findOrFail($id);
    $group->delete();
    return $group;
  }
}
