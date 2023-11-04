<?php

namespace App\Exports;

use App\Models\DosenWali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DosenWaliExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return DosenWali::all();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["nip", "nama", "no_telp", "email_sso"];
    }
}
