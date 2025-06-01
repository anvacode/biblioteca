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
    Route::resource('tickets', TicketController::class);
    
    // Rutas adicionales para tickets
    Route::prefix('tickets')->group(function () {
        Route::get('/{ticket}/pdf', [TicketController::class, 'generatePDF'])->name('tickets.pdf');
        Route::get('/print/all', [TicketController::class, 'printAll'])->name('tickets.printAll');
        Route::get('/export/excel', [TicketController::class, 'excel'])->name('tickets.excel');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Ticket Status Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('estados-tickets')->group(function () {
        Route::resource('index', EstadoTicketController::class)
            ->names('estados-tickets')
            ->parameters(['index' => 'estados_ticket']);
                
        Route::get('/api/list', [EstadoTicketController::class, 'apiEstados'])
            ->name('api.estados-tickets');

        Route::patch('/{estados_ticket}/status', [EstadoTicketController::class, 'updateStatus'])
            ->name('estados-tickets.updateStatus');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Reservation Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('reservas', ReservaController::class)
        ->names('reservas');
    
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
    Route::patch('tipotickets/{tipoticket}/status', [TipoTicketController::class, 'updateStatus'])
        ->name('tipotickets.update-status');
});