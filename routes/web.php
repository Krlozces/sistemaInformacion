<?php

use App\Http\Controllers\DeleteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CertifiedController;
use App\Http\Controllers\ExportPersonalController;
use App\Http\Controllers\ProduccionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/confirmar-password', [ViewsController::class, 'confirmarPassword'])->name('confirmar-password');
Route::get('/ingresar-datos', [ViewsController::class, 'ingresoDatos'])->name('ingresar-datos');

// Comisarias
Route::get('/obtener-comisarias', [ViewsController::class, 'obtenerComisarias'])->name('obtener-comisarias');


Route::get('/registrarte', [ViewsController::class, 'registrarte'])->name('registrarte');
Route::get('/registrar-extraccion', [ViewsController::class, 'extraccion'])->name('registrar-extraccion');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('signin');

Route::post('/register-extraccion', [RegisterController::class, 'registerExtraccion'])->name( 'register-extraccion' );

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/register-personal', [RegisterController::class, 'registerPersonal'])->name('register-personal');

Route::post('/register-procesamiento', [RegisterController::class, 'registerProcesamiento'])->name('register-procesamiento');

Route::post('/cambiar-imagen/{id}', [RegisterController::class, 'changeImage'])->name('cambiar-imagen');

// Change password
Route::post('/cambiar-password/{id}', [EditController::class, 'cambiarPassword'])->name('cambiar-password');

// Editar usuarios
Route::post('/editar-usuario/{dni}', [EditController::class, 'editUser'])->name('editar-usuario');

// Eliminar usuarios
Route::post('/eliminar-usuario/{dni}', [DeleteController::class, 'deleteUser'])->name('eliminar-usuario');

// Gráficos
Route::post('/edad', [ViewsController::class, 'segunEdad'])->name('segun-edad');
Route::post('/motivos', [ViewsController::class, 'segunMotivos'])->name('segun-motivos');
Route::post('/resultados', [ViewsController::class, 'segunResultados'])->name('segun-resultados');

//Rutas protegidas por autenticación de usuario
Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/index', [ViewsController::class, 'home'])->name('home');

    Route::group(['middleware' =>  ['role:admin']], function() {
        Route::get('/principal', [ViewsController::class, 'principal'])->name('principal');
        Route::get('/users', [ViewsController::class, 'listUsers'])->name('listar-usuarios');
        Route::get('/exportar/personal', [ExportPersonalController::class, 'exportPersonal'])->name('exportar-personal');
    });
    
    Route::group(['middleware' => ['role:extractor|admin']], function() {
        Route::get('/extraccion', [ViewsController::class, 'extraccion'])->name('extraccion');
    });

    Route::group(['middleware' => ['role:procesador|admin']], function() {
        Route::get('/procesamiento/{dni}', [ViewsController::class, 'procesamiento'])->name('procesamiento');
        Route::get('/tbl-certificados', [ViewsController::class, 'tblCertificados'])->name('tbl-certificados');
        Route::get('/generarPdf/{dni}', [ViewsController::class, 'generarPdf'])->name('generarPdf');
        Route::get('/exportar', [ExportController::class, 'export'])->name('exportar');
        Route::get('/exportar-cert/{dni}', [CertifiedController::class, 'exportCertified'])->name('exportar-certificado');
        Route::get('/exportar/resumen', [ProduccionController::class, 'exportProduccion'])->name('exportar-consolidado');
    });
    
    //Editar Perfil
    Route::get('/editarPerfil/{id}', [ViewsController::class, 'editarPerfil'])->name('editarPerfil');
    Route::put('/updateUser/{id}', [ViewsController::class, 'actualizarUsuario'])->name('updateUser');
});