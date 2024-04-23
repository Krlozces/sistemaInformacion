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
            margin: 20px 0;
        }

        table{
            width: 90%;
            margin: 0 20px;
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
                    <td>{{ $elementos->apellido_paterno }} {{ $elementos->apellido_materno }}, {{ $elementos->nombre }}</td>
                </tr>
                <tr>
                    <td>Edad</td>
                    <td>:</td>
                    <td>{{ $elementos->edad }}</td>
                    <td>Sexo</td>
                    <td>:</td>
                    <td>{{ $elementos->sexo }}</td>
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
                    <td>{{ $elementos->hora }} {{ $elementos->fecha }}</td>
                </tr>
                <tr>
                    <td>Motivo</td>
                    <td>:</td>
                    <td>{{ $elementos->motivo }}</td>
                </tr>
                <tr>
                    <td>Personal de la Unidad Solicitante</td>
                    <td>:</td>
                    <td colspan="2">{{ $elementos->persona }}</td>
                </tr>
                <tr>
                    <td>Hora y Fecha de Infracción</td>
                    <td>:</td>
                    <td>{{ $elementos->fecha_hora_infraccion }}</td>
                </tr>
                <tr>
                    <td>Hora y Fecha de extracción</td>
                    <td>:</td>
                    <td>{{ $elementos->fecha_hora_extraccion }}</td>
                </tr>
                <tr>
                    <td>Personal que atiende o extrae la muestra</td>
                    <td>:</td>
                    <td>{{ $extraccion }}</td>
                </tr>
                <tr>
                    <td>Tipo y descripción de la muestra</td>
                    <td>:</td>
                    <td>{{ $elementos->description }}</td>
                </tr>
                <tr>
                    <td>Método utilizado</td>
                    <td>:</td>
                    <td>{{ $elementos->descripcion }}</td>
                </tr>
                <tr>
                    <td>Apellidos y Nombres del procesador</td>
                    <td>:</td>
                    <td>{{ $procesamiento }}</td>
                </tr>
                <tr>
                    <td>Grado</td>
                    <td>:</td>
                    <td>{{ $personalProcesamiento->grado }}</td>
                    <td>DNI N°</td>
                    <td>:</td>
                    <td>{{ $personalProcesamiento->persona->dni }}</td>
                </tr>
                <tr>
                    <td>Observaciones</td>
                    <td>:</td>
                    <td colspan="2">{{ $elementos->observaciones }}</td>
                </tr>
            </table>    
    
            <div class="espaciado-contenedor">
                <p class="espaciado">RESULTADO :{{ $elementos->resultado_cuantitativo }}</p>
                <p class="espaciado">CONCLUSIONES:</p>
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





