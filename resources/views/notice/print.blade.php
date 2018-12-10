<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Comunicados</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.css") }}" media="all" />
</head>
<body style="border: 0;border-radius: 0;">
    <div class="page-break p-10">
        {{-- <table class="w-100 ">
            <tr>
                <th class="w-20 text-left no-padding no-margins align-middle">
                    <div class="text-center">
                        <img src="{{ public_path("/img/logo.png") }}" class="w-100">
                    </div>
                </th>
                <th class="w-50 align-top">
                    <span class="font-semibold uppercase leading-tight text-md" >
                        {{  '' }} <br>
                        {{  'MUTUAL DE SERVICIOS AL POLICÍA "MUSERPOL"' }} <br>
                       
                    </span>
                </th>
                <th class="w-20 no-padding no-margins align-top">
                    <div class="text-center">
                        <img src="{{ public_path("/img/escudo_bolivia.png") }}" class="w-60">
                    </div>
                </th>
            </tr>
            <tr><td colspan="3" style="border-bottom: 1px solid #22292f;"></td></tr>
        </table> --}}
    </div>
    <div class="block">
        <div class="font-semibold leading-tight text-center"> 
            <p class="uppercase text-xl" style="margin-bottom: -15px;"> {{ $notice->notice_type->name }} </p>
            <p class="text-md"> MUSERPOL/DGE/{{ $notice->correlative.'/'.$notice->year }} </p>
        </div>
        {!! $notice->content !!}
    </div>    
</body>
</html>