<?php

namespace App\Exports;

use App\Models\PpidInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PpidInformationsExport implements 
    FromCollection,
    WithHeadings, 
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = PpidInformation::with('category');

        // Apply filters
        if (!empty($this->filters['category_id'])) {
            $query->where('ppid_category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['year'])) {
            $query->where('year', $this->filters['year']);
        }

        if (!empty($this->filters['is_public'])) {
            $query->where('is_public', $this->filters['is_public']);
        }

        return $query->orderBy('year', 'desc')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Judul',
            'Deskripsi',
            'Nomor Informasi',
            'Jenis',
            'Penanggung Jawab',
            'Format',
            'Tahun',
            'Tanggal Terbit',
            'Masa Berlaku',
            'Link',
            'Kata Kunci',
            'Status Publik',
            'Jumlah Dilihat',
            'Jumlah Download',
            'Catatan'
        ];
    }

    /**
     * Map data to columns
     */
    public function map($information): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $information->category->name ?? '',
            $information->title,
            $information->description,
            $information->information_number,
            $information->type,
            $information->responsible_unit,
            ucfirst($information->information_format),
            $information->year,
            $information->published_date ? $information->published_date->format('d/m/Y') : '',
            $information->validity_period ? $information->validity_period->format('d/m/Y') : '',
            $information->external_link,
            $information->keywords,
            $information->is_public ? 'Ya' : 'Tidak',
            $information->view_count,
            $information->download_count,
            $information->notes
        ];
    }

    /**
     * Apply styles
     */
    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3B82F6']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Center align for specific columns
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N:P')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [
            // All cells border
            'A1:Q' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ]
            ]
        ];
    }
}