<?php

namespace Juzaweb\Backend\Exports;

use Juzaweb\Applications\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataTableExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Application::select('email', 'lang', 'created_at')->get();
    }

    public function map($row): array
    {
        return [
            $row->email,
            $row->lang,
            $row->created_at->format('Y-m-d H:i:s'),
        ];
    }
    public function headings(): array
    {
        return ['Email', 'Language', 'Subscription Date'];
    }
}
