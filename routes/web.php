<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\RegisterController;

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


Route::get('/registrarte', [ViewsController::class, 'registrarte'])->name('registrarte');
Route::get('/registrar-extraccion', [ViewsController::class, 'extraccion'])->name('registrar-extraccion');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('signin');

Route::post('/register-extraccion', [RegisterController::class, 'registerExtraccion'])->name( 'register-extraccion' );

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/register-personal', [RegisterController::class, 'registerPersonal'])->name('register-personal');

Route::post('/register-procesamiento', [RegisterController::class, 'registerProcesamiento'])->name('register-procesamiento');

Route::post('/cambiar-imagen/{id}', [RegisterController::class, 'changeImage'])->name('cambiar-imagen');

//Rutas protegidas por autenticación de usuario
Route::group(['middleware' => ['auth']], function(){
    Route::get('/index', [ViewsController::class, 'home'])->name('home');

    Route::group(['middleware' =>  ['role:admin']], function() {
        Route::get('/principal', [ViewsController::class, 'principal'])->name('principal');
    });
    
    Route::group(['middleware' => ['role:extractor|admin']], function() {
        Route::get('/extraccion', [ViewsController::class, 'extraccion'])->name('extraccion');
    });

    Route::group(['middleware' => ['role:procesador|admin']], function() {
        Route::get('/procesamiento/{dni}', [ViewsController::class, 'procesamiento'])->name('procesamiento');
        Route::get('/tbl-certificados', [ViewsController::class, 'tblCertificados'])->name('tbl-certificados');
        Route::get('/generarPdf/{dni}', [ViewsController::class, 'generarPdf'])->name('generarPdf');
    });
    
    //Editar Perfil
    Route::get('/editarPerfil/{id}', [ViewsController::class, 'editarPerfil'])->name('editarPerfil');
    Route::put('/updateUser/{id}', [ViewsController::class, 'actualizarUsuario'])->name('updateUser');
});