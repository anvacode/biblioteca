<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Descripción',
            'Estado',
            'Tipo',
            'Solicitante',
            'Fecha Creación',
            'Última Actualización'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->titulo,
            $ticket->descripcion,
            $ticket->estadoTicket->nombre_estado ?? 'N/A',
            $ticket->tipoTicket->nombre_tipo ?? 'N/A',
            $ticket->persona->nombre ?? 'N/A',
            $ticket->created_at->format('d/m/Y H:i'),
            $ticket->updated_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la primera fila (encabezados)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3490DC']]
            ],
            
            // Estilo para las celdas de fecha
            'G:H' => [
                'numberFormat' => ['formatCode' => 'dd/mm/yyyy hh:mm']
            ]
        ];
    }
}