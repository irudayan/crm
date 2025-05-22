<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Leads;
use Illuminate\Support\Carbon;

class ReportsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Leads::with(['products', 'assign', 'assignedBy','user']);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['assigned_by'])) {
            $query->where('assigned_by_id', $this->filters['assigned_by']);
        }

        if (!empty($this->filters['assigned_user'])) {
            $query->where('assigned_name', $this->filters['assigned_user']);
        }

        if (!empty($this->filters['product'])) {
            $query->whereHas('products', function ($q) {
                $q->where('products.id', $this->filters['product']);
            });
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->filters['start_date'])->startOfDay(),
                Carbon::parse($this->filters['end_date'])->endOfDay()
            ]);
        }

        $leads = $query->get();

        return $leads->map(function ($lead) {
            return [
                $lead->id,
                // optional($lead->user)->name,
                optional($lead->assignedBy)->name,
                optional($lead->assign)->name,
                $lead->name,
                $lead->mobile,
                $lead->email,
                $lead->address,
                $lead->industry,
                $lead->purpose,
                $lead->status,
                $lead->source,
                $lead->products->pluck('name')->implode(', '),
                $lead->remarks,
                $lead->demo_date,
                $lead->demo_time,
                $lead->follow_date,
                $lead->follow_time,
                $lead->created_at,
                $lead->updated_at
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            // 'User',
            'Assigned By',
            'Assign Name',
            'Lead Name',
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
            'Follow Date',
            'Follow Time',
            'Created At',
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
}