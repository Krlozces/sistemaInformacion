<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CERTIFICADO - {{ $elementos->dni }}</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    
        .container {
            /* max-width: 120%; */
            margin: 0 auto;
            font-size: 14px;
        }
    
        .section {
            margin-bottom: 10px;
        }
    
        h1 {
            text-align: center;
            font-weight: bold;
        }
    
        h2 {
            text-align: center;
            font-weight: bold;
        }
    
        h3 {
            text-align: center;
        }
    
        h4 {
            text-align: center;
        }
    
        .section1 {
            text-align: center;
        }
    
        .section2 {
            text-align: center;
            font-weight: bold;
        }
    
        .imgen {
            position: absolute;
            top: 20px;
            width: 15%;
            z-index: 1;
        }
    
        .firmas {
            margin-top: 20px;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
    
        .flex-container{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
    
        .firmas {
            position: relative;
            widows: 100%;
        }

        .firma1{
            position: absolute;
            left:  50px;
            margin-right: 20px;
        }

        .firma2{
            position: absolute;
            right: 50px;
            margin-left: 20px; 
        }

        .espaciado{
            margin: 12px 20px;
        }

        .espaciado-contenedor{
            margin: 10px 0;
        }

        table{
            width: 90%;
            margin: 10px 20px;
        }

        td{
            padding: 10px 0;
        }

        tr{
            width: 100%;
        }
        
    </style>
</head>
<body>
    <div class="container" style="position: relative; margin-top: 10px;">
        <img class="imgen" src="{{ public_path('images/logo.png') }}" alt="escudo" style="width: 100px; position: absolute; left: 50px; top:10px">
        <p style="font-weight: bold; display: block; text-align: center; font-size: 20px;">MINISTERIO DEL INTERIOR</p>
        <p style="font-weight: bold; text-align: center; font-size:20px;">POLICIA NACIONAL DEL PERÚ</p>
        <p style="text-align: center;">DIRECCIÓN DE SANIDAD POLICIAL</p>
        <p style="text-align: center;">UNIDAD DESCONCENTRADA DE DOSAJE ETÍLICO</p>
        <p style="font-weight: bold; text-align: center;">SEDE CHICLAYO</p>
        <div class="section">
            <p class="section1">Calle Federico Villareal N° 245 Urb. Los Parques - Chiclayo - Chiclayo</p>
        </div>
        <div class="section">
            {{-- @dd($elementos['unidad']['grado']) --}}
            <p class="section2" style="margin-bottom: 10px;">CERTIFICADO DE DOSAJE ETÍLICO N°0029 - {{ $elementos->recepcion_doc_referencia }}</p>
            <table style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0;">Registro de Dosaje N°</td>
                    <td>:</td>
                    <td colspan="2">{{ $elementos->recepcion_doc_referencia }}</td>
                </tr>
                <tr>
                    <td>Apellidos y Nombres del usuario</td>
                    <td>:</td>
                    <td colspan="4">{{ $elementos->apellido_paterno }} {{ $elementos->apellido_materno }}, {{ $elementos->nombre }}</td>
                </tr>
                <tr>
                    <td>Edad</td>
                    <td>:</td>
                    <td>{{ $elementos->edad }}</td>
                    <td>Sexo</td>
                    <td>:</td>
                    <td>{{ $elementos->sexo === 'M' ? 'MASCULINO' : 'FEMENINO' }}</td>
                </tr>
                <tr>
                    <td>Documento de Identidad del Usuario</td>
                    <td>:</td>
                    <td>{{ $elementos->dni }}</td>
                </tr>
                <tr>
                    <td>Licencia de Conducir del usuario N°</td>
                    <td>:</td>
                    <td>{{ $elementos->licencia }}</td>
                    <td>Clase</td>
                    <td>:</td>
                    <td>{{ $elementos->clase }}</td>
                </tr>
                <tr>
                    <td>Vehículo</td>
                    <td>:</td>
                    <td>{{ $elementos->vehiculo }}</td>
                    <td>Placa N°</td>
                    <td>:</td>
                    <td colspan="2">{{ $elementos->placa }}</td>
                </tr>
                <tr>
                    <td>Procedencia</td>
                    <td>:</td>
                    <td>{{ $elementos->procedencia }}</td>
                </tr>
                <tr>
                    <td>Doc. de referencia Hora y fecha de recepción</td>
                    <td>:</td>
                    <td>OFICIO N°</td>
                    <td>{{ $elementos->recepcion_doc_referencia }}</td>
                    <td colspan="2">{{ date('H:i', strtotime($elementos->hora)) }} &nbsp; HRS
                        &nbsp;{{ date('d/m/Y', strtotime($elementos->fecha)) }}</td>
                </tr>
                <tr>
                    <td>Motivo</td>
                    <td>:</td>
                    <td colspan="4">{{ $elementos->motivo }}</td>
                </tr>
                <tr>
                    <td>Personal de la Unidad Solicitante</td>
                    <td>:</td>
                    <td colspan="4">{{ $elementos->persona }}</td>
                </tr>
                <tr>
                    <td>Hora y Fecha de Infracción</td>
                    <td>:</td>
                    <td colspan="3">
                        {{ date('H:i', strtotime($elementos->fecha_hora_infraccion)) }} &nbsp; HRS &nbsp;
                        {{ date('d  m  Y', strtotime($elementos->fecha_hora_infraccion)) }}
                    </td>
                </tr>
                <tr>
                    <td>Hora y Fecha de extracción</td>
                    <td>:</td>
                    <td colspan="3">
                        {{ date('H:i', strtotime($elementos->fecha_hora_extraccion)) }} &nbsp; HRS &nbsp;
                        {{ date('d m Y', strtotime($elementos->fecha_hora_extraccion)) }}    
                    </td>
                    <td>
                        @if ($elementos->description == 'SIN MUESTRA')
                            {{ $elementos->resultado_cualitativo }}
                        @else
                            <span></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Personal que atiende o extrae la muestra</td>
                    <td>:</td>
                    <td colspan="4">{{ $extraccion }}</td>
                </tr>
                <tr>
                    <td>Tipo y descripción de la muestra</td>
                    <td>:</td>
                    <td>{{ $elementos->description }}</td>
                </tr>
                <tr>
                    <td>Método utilizado</td>
                    <td>:</td>
                    <td colspan="4">
                        @if ($elementos->description == 'SIN MUESTRA')
                            <div style="margin:0 auto; height:1px; width:100px; border-top:1px solid black;"></div>                            
                        @else
                            {{ $elementos->descripcion }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Apellidos y Nombres del procesador</td>
                    <td>:</td>
                    <td colspan="2">
                        @if ($elementos->description == 'SIN MUESTRA')
                        <div style="margin:0 auto; height:4px; width:100px; border-top:1px solid black;"></div>                            
                        @else
                            {{ $procesamiento }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Grado</td>
                    <td>:</td>
                    <td>
                        @if ($elementos->description == 'SIN MUESTRA')
                        <div style="margin:0 auto; height:4px; width:100px; border-top:1px solid black;"></div>                           
                        @else
                            {{ $personalProcesamiento->grado }}
                        @endif
                    </td>
                    <td>DNI N°</td>
                    <td>:</td>
                    <td>
                        @if ($elementos->description == 'SIN MUESTRA')
                        <div style="margin:0 auto; height:4px; width:120px; border-top:1px solid black;"></div>                            
                        @else
                            {{ $personalProcesamiento->persona->dni }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Observaciones</td>
                    <td>:</td>
                    <td colspan="2">{{ $elementos->observaciones }}</td>
                </tr>
            </table>    
    
            <div class="espaciado-contenedor">
                <table>
                    <tr>
                        <td class="espaciado">RESULTADO</td>
                        <td>:</td>
                        <td colspan="2">
                            @if($elementos->description == 'SIN MUESTRA' && $elementos->resultado_cualitativo == 'NEGACIÓN')
                                <p style="text-align: center;">
                                    USUARIO CON SIGNOS Y SINTOMAS DE EBRIEDAD SE NIEGA ROTUNDAMENTE AL EXAMEN DE DOSAJE ETILICO
                                </p>
                                <div style="width: 100%; height: 20px; border:1px solid black; padding: 10px; margin-left: 10px;">
                                    <p style="text-align: center;">
                                        INCURSO EN EL ART. 269 (M.2) DS. N° 016-2009-MTC DEL 21 ABR 2009 MODIFICADO POR EL ART. 1° DEL DS N°029-2009-MTC DEL 19JUL2009
                                    </p>
                                </div>
                                <div style="margin:0 auto; height:4px; width:80px; border-top:1px solid black; margin-top:2px;"></div>
                            @elseif ($elementos->description != 'SIN MUESTRA')
                                <p style="text-align: center; font-size:20px;">{{ $elementos->resultado_cuantitativo }}g/L.</p>
                                <div style="width: 100%; height: 20px; border:1px solid black; padding: 10px; margin-left: 10px;">
                                    <p style="text-align: center;">{{ $resultadoCuantitativoLetras }}</p>
                                </div>
                                <p style="text-align: center;">{{ $contieneAlcohol }}</p>
                            @else
                                <p style="text-align: center; font-size:20px;">{{ $elementos->description }}</p>
                                <div style="width: 100%; height: 20px; border:1px solid black; padding: 10px; margin-left: 10px;">
                                    <p style="text-align: center;">{{ $elementos->resultado_cualitativo }}</p>
                                </div>
                                <div style="margin:0 auto; height:4px; width:80px; border-top:1px solid black; margin-top:2px;"></div>
                            @endif
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td class="espaciado">CONCLUSIONES</td>
                        <td>:</td>
                        <td style="text-align: end;">
                            CHICLAYO, {{ strtoupper(\Carbon\Carbon::now()->formatLocalized('%d DE %B DEL %Y')) }}
                        </td>
                    </tr>
                </table>
            </div>
    
            <div style="display: flex; justify-content: space-between; align-items:center; margin-top: 50px;">
                <div class="firma1">
                    <div style="border-bottom: 2px solid #000; margin-top: 5px;"></div>
                    <p>(Firma y Post-Firma del procesador)</p>
                </div>
                <div class="firma2">
                    <div style="border-bottom: 2px solid #000; margin-top: 5px;"></div>
                    <p>(Firma y Post-Firma del Jefe de Sede UNIDDE)</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>





