<!DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" href="{{ public_path("/css/report-print.css") }}" media="all" />
	</head>
    <body style="border: 0;border-radius: 0;">
    	{{-- <div class="table">
	        <div class="column1">
	            <img src="{{ public_path("/img/logo.png") }}" width="200px">
	        </div>
	        <div class="column2">
	        	<div class="caja">
	        		MUTUAL DE SERVICIOS AL POLICIA "MUSERPOL"
	        	</div>
	        </div>
	        <div style="clear: both;"></div>
	    </div> --}}
	    <div class="page-break p-10">
	        <table class="w-100 ">
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
	        </table>
	    </div>
    </body>
</html>