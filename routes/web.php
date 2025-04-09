<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TipoTicketController,
    ReservaController,
    EstadoTicketController,
    TicketController,
    HistorialTicketController,
    HomeController
};
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\AutorController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    /*
    |--------------------------------------------------------------------------
    | Ticket Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('tickets')->group(function () {
        Route::resource('/', TicketController::class)
            ->except(['edit', 'update', 'destroy'])
            ->names('tickets');
            
        Route::patch('/{ticket}/status', [TicketController::class, 'updateStatus'])
            ->name('tickets.update-status');
            
        Route::post('/{ticket}/comment', [TicketController::class, 'addComment'])
            ->name('tickets.add-comment');
            
        Route::get('/api/list', [TicketController::class, 'apiTickets'])
            ->name('api.tickets');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Ticket Status Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('estados-tickets')->group(function () {
        Route::resource('/', EstadoTicketController::class)
            ->except(['create', 'show', 'edit'])
            ->names('estados-tickets');
            
        Route::get('/api/list', [EstadoTicketController::class, 'apiEstados'])
            ->name('api.estados-tickets');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Reservation Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('reservas')->group(function () {
        Route::resource('/', ReservaController::class)
            ->except(['edit', 'update'])
            ->names('reservas');
            
        Route::patch('/{reserva}/status', [ReservaController::class, 'updateStatus'])
            ->name('reservas.update-status');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Ticket History Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('historial-tickets')->group(function () {
        Route::get('/', [HistorialTicketController::class, 'index'])
            ->name('historial-tickets.index');
            
        Route::post('/{ticket}', [HistorialTicketController::class, 'store'])
            ->name('historial-tickets.store');
            
        Route::delete('/{registro}', [HistorialTicketController::class, 'destroy'])
            ->name('historial-tickets.destroy');
            
        // API Endpoints
        Route::get('/ticket/{ticket}', [HistorialTicketController::class, 'getTicketHistory'])
            ->name('api.ticket-history');
            
        // Export
        Route::get('/export/{ticket}/pdf', [HistorialTicketController::class, 'exportPdf'])
            ->name('historial-tickets.export');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Ticket Type Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('tipotickets', TipoTicketController::class);
        Route::get('cambioestadotipoticket', [TipoTicketController::class, 'cambioestadotipoticket'])->name('cambioestadotipoticket');
    /*
    |--------------------------------------------------------------------------
    | Resource Routes (Commented - Ready for Implementation)
    |--------------------------------------------------------------------------
    */
    // Route::resource('categorias', CategoriaController::class);
    // Route::resource('materiales', MaterialController::class);
    // Route::resource('estantes', EstanteController::class);
    // Route::resource('autores', AutorController::class);
    //Route::resource ('tickets', TipoTicketController::class);
    //Route::get('cambioestadotipoticket', [TipoTicketController::class, 'cambioestadotipoticket'])->name('cambioestadotipoticket');
});