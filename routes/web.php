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
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    
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
    Route::patch('tipotickets/{id}/status', [TipoTicketController::class, 'updateStatus'])
        ->name('tipotickets.update-status');
});