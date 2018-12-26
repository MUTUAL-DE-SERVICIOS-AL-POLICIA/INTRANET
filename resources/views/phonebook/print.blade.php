<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Telefonos internos</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.css") }}" media="all" />
</head>
<body style="border: 0;border-radius: 0;">    
    <div class="block">
        <div class="font-semibold leading-tight text-md text-center">Agenda Telefonica</div>
        <table class="table-info w-100 m-b-10">
            <thead class="bg-grey-darker">
                <tr class="font-medium text-white text-xs uppercase">
                    <td class="px-15 text-center">Dirección</td>
                    <td class="px-15 text-center">Ubicación</td>
                    <td class="px-15 text-center">No. Interno</td>
                </tr>
            </thead>
            <tbody class="table-striped">
                @php($id=0)
                @foreach($position_groups as $key => $position_group)
                @foreach($position_group->locations as $key => $location)
                <tr class="text-xs">
                    @if ($id!=$position_group->id)
                    <td class="text-left uppercase px-5 py-3" rowspan="{{ count($position_group->locations) }}"> {{ $position_group->name }} </td>
                    <td class="text-left uppercase px-5 py-3"> {{ $location->name }} </td>
                    <td class="text-center uppercase px-5 py-3"> {{ $location->phone_number }} </td>
                    @else
                    <td class="text-left uppercase px-5 py-3"> {{ $location->name }} </td>
                    <td class="text-center uppercase px-5 py-3"> {{ $location->phone_number }} </td>
                    @endif 
                </tr>
                @php($id=$position_group->id)
                @endforeach
                @endforeach
            </tbody>
        </table>        
    </div>    
</body>
</html>