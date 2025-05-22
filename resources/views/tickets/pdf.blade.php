<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket #{{ $ticket->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .ticket-info { margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ticket #{{ $ticket->id }}</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="ticket-info">
        <table class="table">
            <tr>
                <th>Título</th>
                <td>{{ $ticket->titulo }}</td>
            </tr>
            <tr>
                <th>Descripción</th>
                <td>{{ $ticket->descripcion }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $ticket->estadoTicket->nombre_estado ?? 'No definido' }}</td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td>{{ $ticket->tipoTicket->nombre ?? 'No definido' }}</td>
            </tr>
            <tr>
                <th>Persona</th>
                <td>{{ $ticket->persona->nombre ?? 'No definido' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>