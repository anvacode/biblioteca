<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado Completo de Tickets</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2c3e50; margin-bottom: 5px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        .info-table th { background-color: #f8f9fa; text-align: left; padding: 8px; }
        .info-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .footer { text-align: right; margin-top: 50px; font-size: 10px; color: #7f8c8d; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 11px; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Listado Completo de Tickets</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="info-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">Título</th>
                <th width="15%">Estado</th>
                <th width="15%">Tipo</th>
                <th width="20%">Persona</th>
                <th width="20%">Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $ticket->titulo }}</td>
                <td>
                    <span class="badge 
                        {{ optional($ticket->estadoTicket)->nombre_estado == 'Pendiente' ? 'badge-warning' : 
                           (optional($ticket->estadoTicket)->nombre_estado == 'En progreso' ? 'badge-info' : 
                           (optional($ticket->estadoTicket)->nombre_estado == 'Resuelto' ? 'badge-success' : 'badge-secondary')) }}">
                        {{ optional($ticket->estadoTicket)->nombre_estado ?? 'No definido' }}
                    </span>
                </td>
                <td>{{ optional($ticket->tipoTicket)->nombre ?? 'No definido' }}</td>
                <td>{{ optional($ticket->persona)->nombre ?? 'No definido' }}</td>
                <td>{!! nl2br(e(Str::limit($ticket->descripcion, 100))) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total de tickets: {{ $tickets->count() }}
    </div>
</body>
</html>