<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $path = env("APP_URL_RRHH");
        $notice = file_get_contents($path . '/api/v1/location/list');
        return json_decode($notice);
    }    

    /**
     * Print the specified resource from storage.
     *
     * @param  \App\Notice  $id
     * @return pdf
     */
    function print() {
        $path = env("APP_URL_RRHH");
        $pageWidth   = '216';
        $pageHeight  = '279';
        $pageMargins = [25, 10, 20, 15];
        $pageName    = 'Telefonos internos.pdf';
        $headerHtml  = view()->make('partials.head')->render();
        $footerHtml  = view()->make('partials.foot')->render();
        $data = [
            'position_groups' => json_decode(file_get_contents($path . '/api/v1/location'))
        ];
        return \PDF::loadView('phonebook.print', $data)
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
