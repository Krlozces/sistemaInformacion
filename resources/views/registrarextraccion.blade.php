<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar Extraccion</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex justify-center mb-4">
        <h3 class="font-bold text-2xl my-auto">Formulario Registro de Usuario</h3> <span class="my-auto mx-2">Registro de la Información</span>
    </div>
    <hr />
    <h1 class="uppercase text-center font-bold text-xl">informe extractor dosaje etilico</h1>
    <div>
        <form action="{{ route('register-extraccion') }}" method="post">
            @csrf
            {{-- Informació del la emisión del informe --}}
            <fieldset class="px-20 border mx-12">
                <legend class="uppercase font-bold text-xl">INFORMACION GENERAL</legend>
                <div class="flex justify-between">
                    <div class="mb-4">
                        <label htmlFor="" class="font-bold mb-2">Número de Oficio de referencia: </label>
                        <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="" id="" />
                    </div>
                    <div class="mb-4">
                        <label htmlFor="" class="font-bold mb-2">Procedencia: </label>
                        <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="" id="" />
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="mb-4">
                        <label htmlFor="fecha" class="font-bold mb-2">Fecha: </label>
                        <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="fecha" id="fecha" />
                    </div>
                    <div class="mb-4">
                        <label htmlFor="" class="font-bold mb-2">Hora: </label>
                        <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time" name="" id="" />
                    </div>
                </div>
            </fieldset>        

            {{-- Información del intervenido --}}
            <fieldset class="flex flex-col border mx-12 py-6 px-20">
                        <legend class="uppercase font-bold text-xl">Información del Intervenido</legend>
                        <div class="mb-4 flex justify-evenly">
                            <div>
                                <label htmlFor="dni" class="font-bold mb-2">DNI: </label>
                                <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="dni" id="dni" maxLength={8}/>
                            </div>
                        
                            <div>
                                <label htmlFor="nacionalidad" class="font-bold mb-2">Nacionalidad: </label>
                                <select id="nacionalidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">Nacionalidad</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex justify-between">
                            <div class="flex flex-col w-1/2">
                                <div class="mb-4">
                                    <label htmlFor="nombre" class="font-bold mb-2 block">Nombre: </label>
                                    <input class="w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nombre" id="nombre" />
                                </div>
                            
                                <div class="mb-4">
                                    <label htmlFor="ape-pat" class="font-bold mb-2 block">Apellido paterno: </label>
                                    <input class="w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="ape-pat" id="ape-pat" />
                                </div>
                                
                                <div class="mb-4">
                                    <label htmlFor="ape-mat" class="font-bold mb-2 block">Apellido materno: </label>
                                    <input class="w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="ape-mat" id="ape-mat" />
                                </div>
                            </div>
            
                            <div class="flex flex-col">
                                <div class="mb-4">
                                    <label htmlFor="fecha-nac" class="font-bold mb-2 block">Fecha de nacimiento: </label>
                                    <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="fecha-nac" id="fecha-nac" />
                                </div>
            
                                <div class="mb-4">
                                    <label htmlFor="edad" class="font-bold mb-2 block">Edad: </label>
                                    <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="edad" id="edad" maxLength={2}/>
                                </div>
                                <div>
                                    <span class="block font-bold mb-2">Género: </span>
                                    <label htmlFor="masculino" class="mr-6">
                                        <input type="radio" name="sexo" id="masculino" value={'M'}  /> Masculino
                                    </label>
                                    <label htmlFor="femenino">
                                        <input type="radio" name="sexo" id="femenino" value={'F'}  /> Femenino
                                    </label>
                                </div>
                            </div>
                        </div>
            
                        <div class="flex flex-wrap justify-evenly">
                            <div class="mb-4">
                                <label htmlFor="licencia" class="font-bold mb-2 block">Licencia: </label>
                                <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="licencia" id="licencia" />
                            </div>
                            
                            <div class="mb-4">
                                <label htmlFor="clase" class="font-bold mb-2 block">Clase: </label>
                                <select id="clase" name="clase" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled >Clase</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label htmlFor="categoria" class="font-bold mb-2 block">Categoria: </label>
                                <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="categoria" id="categoria" />
                            </div>
                            
                            <div class="mb-4">
                                <label htmlFor="vehiculo" class="font-bold mb-2 block">Vehiculo: </label>
                                <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="vehiculo" id="vehiculo" />
                            </div>
                            
                            <div class="mb-4">
                                <label htmlFor="numero-placa" class="font-bold mb-2 block">N° de placa: </label>
                                <input class="appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="numero-placa" id="numero-placa" />
                            </div>
                            
                        </div>
                    </fieldset>        
            
            {{-- Información del accidente --}}
            <fieldset class="px-20 border mx-12">
                <legend class="uppercase font-bold text-xl">Personal Policial Encargado</legend>
                        <div class="flex justify-evenly">
                            <div>
                                <label htmlFor="dni" class="font-bold mb-2 block">DNI: </label>
                                <input class="shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="dni" id="dni" />
                            </div>
                            <div>
                                <label htmlFor="grado-policial" class="font-bold mb-2 block">Grado: </label>
                                <select id="grado-policial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled >Grado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex flex-col mb-4 items-center">
                            <div class="my-4 w-1/2">
                                <label htmlFor="nombre" class="font-bold mb-2 block">Nombre: </label>
                                <input class="shadow w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nombre" id="nombre" />
                            </div>
                            
                            <div class="mb-4 w-1/2">
                                <label htmlFor="ape-pat" class="font-bold mb-2 block">Apellido Paterno: </label>
                                <input class="shadow w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="apellido-paterno" id="ape-pat" />
                            </div>
                            
                            <div class="mb-4 w-1/2">
                                <label htmlFor="ape-mat" class="font-bold mb-2 block">Apellido Materno: </label>  
                                <input class="shadow w-full appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="apellido-materno" id="ape-mat" />
                            </div>
                        </div>
            
                        <div class="mb-4">
                            <label htmlFor="motivo" class="font-bold mb-2 block">Motivo: </label>
                            <input type="text" name="motivo" id="motivo" class="w-full shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        </div>
            
                        <div class="flex justify-evenly mb-4">
                            <div class="hora-infraccion">
                                <label htmlFor="hora-infraccion" class="font-bold mb-2">HORA DE INFRACCION: </label>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time" name="hora-infraccion" id="hora-infraccion" />
                            </div>
                            
                            <div class="fecha-infraccion">
                                <label htmlFor="fecha-infraccion" class="font-bold mb-2">FECHA DE INFRACCION: </label>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="fecha-infraccion" id="fecha-infraccion" />
                            </div>
                        </div>
                    </fieldset>        

            {{-- Información del extractor --}}
                    <fieldset class="px-20 border mx-12">
                        <legend class="uppercase font-bold text-xl">Extractor</legend>
                        <div class="flex justify-between my-4">
                            <div>
                                <label htmlFor="nombre-extractor" class="font-bold mb-2 block">Nombre del Extractor: </label>
                                <select id="nombre-extractor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">Nombre</option>
                                </select>
                            </div>
                            
                            <div>
                                <label htmlFor="grado-extractor" class="font-bold mb-2 block">Grado del extractor: </label>
                                <select id="grado-extractor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled >Grado</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-between">
                            <div class="mb-4">
                                <label htmlFor="tipo-muestra" class="font-bold mb-2 block">Tipo de muestra: </label>
                                <select id="tipo-muestra" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled >Tipo</option>
                                </select>
                            </div>
            
                            <div class="mb-4">
                                <label htmlFor="resultado-cualitativo" class="font-bold mb-2 block">Resultado cualitativo: </label>
                                <select id="resultado-cualitativo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 w-60 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled >Resultado</option>
                                </select>
                            </div>
                            </div>
                            
                            <div class="mb-4">
                                <label htmlFor="" class="mb-2 font-bold block">Descripción de la muestra: </label>
                                <input class="shadow appearance-none border w-full rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="" id="" />
                            </div>
                            
                            
                        </div>
                        <div class="flex justify-between">
                            <div class="mb-4">
                                <label htmlFor="" class="font-bold mb-2">HORA DE EXTRACCIÓN: </label>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time" name="" id="" />
                            </div>
                            <div class="mb-4">
                                <label htmlFor="" class="font-bold mb-2">FECHA DE EXTRACCIÓN: </label>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time" name="" id="" />
                            </div>
                        </div>
                    </fieldset>        

            {{-- Seccion del personal de procesamiento --}}
            <ProcessorPart />
            <div class="flex my-6 justify-end mx-12">
                <button class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Imprimir</button>
                <button class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="submit">REGISTRAR DOSAJE</button>
                <button class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Salir</button>
            </div>
        </form>
    </div>
</body>
</html>