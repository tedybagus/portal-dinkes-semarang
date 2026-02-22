<?php

namespace App\Imports;

use App\Models\Klinik;
use App\Models\Fasyankes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FasyankesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
        // Cari klinik berdasarkan kode
        $klinik = Klinik::where('kode', $row['klinik_kode'] ?? null)->first();

        // Jika kode klinik tidak ditemukan → skip
        if (!$klinik) {
            return null;
        }

        return new Fasyankes([
            'klinik_id' => $klinik->id,
            'nama'      => $row['nama'],
            'kode'      => $row['kode'],
            'alamat'    => $row['alamat'],
            'latitude'  => $row['latitude'],
            'longitude' => $row['longitude'],
        ]);
    
        
    }
    public function rules(): array
    {
        return [
            'klinik_id' => 'required|exists:kliniks,id',
            'nama'      => 'required|string',
            'kode'      => 'nullable|string',
            'alamat'    => 'required|string',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ];
    }
}
