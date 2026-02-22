<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\FasyankesImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FasyankesImportController extends Controller
{
     public function index()
    {
        return view('admin.fasyankes.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new FasyankesImport, $request->file('file'));

        return redirect()
            ->route('admin.fasyankes.index')
            ->with('success', 'Data Fasyankes berhasil diimport');
    }
}
