<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\system\DashboardController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\pacienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('Login.login');
    if(Auth::check()){
        // dd(Auth()->user()->rol_id);
        switch (Auth()->user()->rol_id) {
            case 1:
                return redirect("/index");
                break;
            
            case 2:
                return redirect("/dashboard");
                break;
        }
        
    }
    else{
        return redirect("inicio");
    }
});
Route::get('inicio',  function () {
    return view('welcome');
}); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login'); // fomrulario login
Route::post('customLogin', [CustomAuthController::class, 'customLogin'])->name('customLogin'); // valida e inicia sesion
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('register', [CustomAuthController::class, 'customRegistration'])->name('register'); // registra usuario y el laboratorio
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout'); // cierra session

Route::group(['middleware' => 'root'], function () {
    Route::get('/index', [DashboardController::class, 'index']);
    Route::get('/validar-laboratorio/{id}', [DashboardController::class, 'validateLab']);
    Route::post('/activarlaboratorio', [DashboardController::class, 'activarlaboratorio']);
    Route::get('/lab-activos', [DashboardController::class, 'labActivos']);
    Route::get('/lab-pendientes', [DashboardController::class, 'index']);
    Route::get('/lab-rechazados', [DashboardController::class, 'labrechazados']);
    Route::get('/configuraciones', [DashboardController::class, 'index']);
    Route::get('/download-file/{tipo}/{name}', [DashboardController::class, 'download']);
    Route::post('/rechazarMuestra', [DashboardController::class, 'rechazarMuestra']);
    
});
Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [adminController::class, 'muestras']);
    Route::get('/usuarios', [adminController::class, 'index']);
    Route::get('/pacientes', [adminController::class, 'pacientes']);
    Route::get('/analisis', [adminController::class, 'analisis']);
    Route::get('/muestras/{tipo}', [adminController::class, 'muestras']);
    Route::get('/infoPaciente/{id}', [adminController::class, 'validateLab']);
    Route::post('/registrarPaciente', [adminController::class, 'registrarPaciente']);
    Route::post('/buscarPaciente', [adminController::class, 'buscarPaciente']);
    Route::post('/registrarExamen', [adminController::class, 'registrarExamen']);
    Route::post('/registrarMuestra', [adminController::class, 'registrarMuestra']);
    Route::post('/updateMuestra', [adminController::class, 'updateMuestra']);
    Route::post('/publicarMuestra', [adminController::class, 'publicarMuestra']);
    // Route::get('download', [adminController::class,'download']);
    Route::get('/download/{tipo}', [adminController::class, 'download']);

    Route::post('/registrarUsuario', [adminController::class, 'registrarUsuario']);
    Route::post('/eliminarUsuario', [adminController::class, 'eliminarUsuario']);
    Route::post('/eliminarPaciente', [adminController::class, 'eliminarPaciente']);
    
});
Route::group(['middleware' => 'paciente'], function () {
    Route::get('/test3', function () {
        return 'paciente';
    });
});

Route::get('/consultar', function () {
    return view('Login.resultados');
});
Route::post('buscarResultado', [pacienteController::class, 'buscarResultado'])->name('buscarResultado'); 