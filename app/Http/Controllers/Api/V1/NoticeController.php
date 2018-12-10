<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Notice;
use Illuminate\Http\Request;

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
        $notice                 = new Notice;
        $notice->notice_type_id = $request->notice_type_id;
        $notice->origin         = $request->origin;
        $notice->title          = $request->title;
        $notice->content        = $request->title;
        $notice->correlative    = $correlative;
        $notice->year           = $year;
        $notice->save();
        return $notice;
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
        $pageMargins = [20, 10, 20, 15];
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

    public function upload_image()
    {
        // $ds = DIRECTORY_SEPARATOR; //1

        // $storeFolder = 'uploads'; //2

        // if (!empty($_FILES)) {

        //     $tempFile = $_FILES['file']['tmp_name']; //3

        //     $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds; //4

        //     $targetFile = $targetPath . $_FILES['file']['name']; //5

        //     move_uploaded_file($tempFile, $targetFile); //6

        // }

        return "hoola";
    }
}
