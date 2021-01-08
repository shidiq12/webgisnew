<?php

namespace App\Exports;

use App\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuratMasuksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SuratMasuk::all();
    }
}
