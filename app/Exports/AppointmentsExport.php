<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\Leads;

class AppointmentsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'ID',
            // 'User Name',
            'Assigned By',
            'Assign Name',
            'Leads Name',
            'Mobile',
            'Email',
            'Address',
            'Industry',
            'Purpose',
            'Status',
            'Source',
            'Products',
            'Remarks',
            'Demo Date',
            'Demo Time',
            // 'Follow Date',
            // 'Follow Time',
            'Created At',
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
}