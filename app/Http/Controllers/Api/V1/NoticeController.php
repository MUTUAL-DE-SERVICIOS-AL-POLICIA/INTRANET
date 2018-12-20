<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Notice;
use App\NoticeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notice = Notice::with('notice_type')->get();
        return $notice;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $correlative = 1;
        $year        = date('Y');
        $notice      = Notice::where('notice_type_id', $request->notice_type_id)->orderBy('correlative', 'desc')->first();
        if ($notice) {
            $correlative = $notice->correlative + 1;
            if ($notice->year != $year) {
                $notice = 1;
            }
        }

        $notice_type = NoticeType::find($request->notice_type_id);

        $notice                 = new Notice;
        $notice->notice_type_id = $request->notice_type_id;
        $notice->origin         = $request->origin;
        $notice->title          = $request->title;
        $notice->content        = $request->content;
        $notice->correlative    = $correlative;
        $notice->year           = $year;
        $file = $request->file;
        if ($file != 'null') {            
            if (Storage::disk('uploads')->put('/'.$notice_type->shortened.$notice->correlative.$notice->year,  File::get($file))) {
                $notice->url_document = 'uploads/'.$notice_type->shortened.$notice->correlative.$notice->year;
            }
        }
        $notice->save();
        return $request->file;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notice  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Notice::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->fill($request->all());
        $notice->save();
        return $notice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();
        return $notice;
    }

    /**
     * Print the specified resource from storage.
     *
     * @param  \App\Notice  $id
     * @return pdf
     */
    function print($id) {
        $pageWidth   = '216';
        $pageHeight  = '279';
        $pageMargins = [25, 10, 20, 15];
        $pageName    = 'Comunicado.pdf';
        $headerHtml  = view()->make('partials.head')->render();
        $footerHtml  = view()->make('partials.foot')->render();
        $data = [
            'notice' => Notice::findOrFail($id),
        ];
        return \PDF::loadView('notice.print', $data)
            ->setOption('header-html', $headerHtml)
            ->setOption('footer-html', $footerHtml)
            ->setOption('page-width', $pageWidth)
            ->setOption('page-height', $pageHeight)
            ->setOption('margin-top', $pageMargins[0])
            ->setOption('margin-right', $pageMargins[1])
            ->setOption('margin-bottom', $pageMargins[2])
            ->setOption('margin-left', $pageMargins[3])
            ->setOption('encoding', 'utf-8')
            ->stream($pageName);
    }
}
