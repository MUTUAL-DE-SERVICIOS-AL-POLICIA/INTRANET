<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\NoticeType;
use Illuminate\Http\Request;

class NoticeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notice_type = NoticeType::get();
        return $notice_type;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NoticeType  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return NoticeType::find($id);
    }
}
