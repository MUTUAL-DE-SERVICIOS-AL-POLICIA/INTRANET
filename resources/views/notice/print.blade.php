<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Comunicados</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.css") }}" media="all" />
</head>
<body style="border: 0;border-radius: 0;">    
    <div class="block">
        <div class="font-semibold leading-tight text-center"> 
            <p class="uppercase text-xl" style="margin-bottom: -15px;"> {{ $notice->notice_type->name }} </p>
            <p class="text-md"> MUSERPOL/DGE/{{ $notice->correlative.'/'.$notice->year }} </p>
        </div>
        {!! $notice->content !!}
    </div>    
</body>
</html>