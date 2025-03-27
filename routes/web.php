<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoTicketController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\AutorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('tipotickets', TipoTicketController::class);
    /*Route::resource('categorias', CategoriaController::class);
    Route::resource('materiales', MaterialController::class);
    Route::resource('estantes', EstanteController::class);
    Route::resource('autores', AutorController::class);*/
});

/**Route::get('/', function (){
    return"Hola mundo";
});/

/* Route::get('/about', function (){
     return 'Acerca de nosotros';
 });*/

/*Route::get('/user/{id}', function ($id){
    return 'ID de usuario:'.$id;
});*/

/*Route::get('/user/{id}/{name}', function ($id , $name){
    return 'ID de usuario:'.$id ." ".$name;
});*/

/*Route::get('/user/{id}', function ($id){
    return 'ID de usuario:' .$id;
})-> where('id', '[0-9]{3}');*/

/*Route::prefix('admin')->group(function () {
    Route::get('/', function () {
    return 'Panel de administración';
    });
    Route::get('/users', function () {
    return 'Lista de usuarios';
    });
    }); */