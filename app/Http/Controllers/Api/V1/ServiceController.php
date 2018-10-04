<?php

namespace App\Http\Controllers\Api\V1;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $services = Service::get();
    return $services;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    return Service::create($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Service::find($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $service = Service::findOrFail($id);
    $service->fill($request->all());
    $service->save();
    return $service;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $service = Service::findOrFail($id);
    $service->delete();
    return $service;
  }
}
