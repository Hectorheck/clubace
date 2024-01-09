<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Traits\MultiClases;

class CanchasExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use MultiClases;
    public function collection()
    {   
        $clubid = auth()->user()->getClubes();
        $users = $this->usersGral($clubid);
        return $users;
    }
    public function headings(): array
    {
        return ["id", "nombre", "prueba"];
    }
}
