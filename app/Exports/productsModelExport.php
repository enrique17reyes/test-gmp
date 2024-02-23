<?php

namespace App\Exports;

use App\Models\productsModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class productsModelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return productsModel::all();
    }
}
