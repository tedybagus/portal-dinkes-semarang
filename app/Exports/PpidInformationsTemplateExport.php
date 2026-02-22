<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
class PpidInformationsTemplateExport implements 
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize
{
    /**
     * Return empty collection for template
     */
    public function collection()
    {
        return collect([
            [
                'Informasi Berkala',
                'Laporan Kinerja Tahun 2024',
                'Laporan kinerja tahunan Dinas Kesehatan',
                '800/123/DINKES/2024',
                'Laporan',
                'Sekretariat',
                'softcopy',
                2024,
                '15/01/2024',
                '31/12/2024',
                'https://example.com',
                'laporan, kinerja',
                'Ya',
                'Contoh catatan'
            ]
        ]);
    }

    /**
     * Template headings
     */
    public function headings(): array
    {
        return [
            'Kategori*',
            'Judul*',
            'Deskripsi',
            'Nomor Informasi',
            'Jenis',
            'Penanggung Jawab',
            'Format (softcopy/hardcopy/keduanya)',
            'Tahun',
            'Tanggal Terbit (dd/mm/yyyy)',
            'Masa Berlaku (dd/mm/yyyy)',
            'Link',
            'Kata Kunci',
            'Publik (Ya/Tidak)',
            'Catatan'
        ];
    }

    /**
     * Template styles
     */
    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10B981']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ]);

        // Example row style
        $sheet->getStyle('A2:N2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F4F6']
            ],
            'font' => [
                'italic' => true,
                'color' => ['rgb' => '6B7280']
            ]
        ]);

        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }
}


