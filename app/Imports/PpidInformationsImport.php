<?php

namespace App\Imports;

use App\Models\PpidInformation;
use App\Models\PpidCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class PpidInformationsImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation, 
    SkipsOnError,
    WithBatchInserts,
    WithChunkReading
{
    use SkipsErrors;

    protected $categoryMapping = [];
    protected $importedCount = 0;
    protected $skippedCount = 0;

    public function __construct()
    {
        // Cache kategori untuk performa
        $categories = PpidCategory::all();
        foreach ($categories as $category) {
            // Map by name dan slug
            $this->categoryMapping[strtolower($category->name)] = $category->id;
            $this->categoryMapping[$category->slug] = $category->id;
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari kategori berdasarkan nama
        $categoryId = $this->findCategoryId($row['kategori'] ?? '');

        if (!$categoryId) {
            $this->skippedCount++;
            return null;
        }

        $this->importedCount++;

        return new PpidInformation([
            'ppid_category_id' => $categoryId,
            'title' => $row['judul'] ?? $row['title'] ?? '',
            'description' => $row['deskripsi'] ?? $row['description'] ?? null,
            'information_number' => $row['nomor_informasi'] ?? $row['no_informasi'] ?? null,
            'type' => $row['jenis'] ?? $row['type'] ?? null,
            'responsible_unit' => $row['penanggung_jawab'] ?? $row['unit'] ?? null,
            'information_format' => $this->normalizeFormat($row['format'] ?? 'softcopy'),
            'year' => $row['tahun'] ?? $row['year'] ?? date('Y'),
            'published_date' => $this->parseDate($row['tanggal_terbit'] ?? null),
            'validity_period' => $this->parseDate($row['masa_berlaku'] ?? null),
            'external_link' => $row['link'] ?? null,
            'keywords' => $row['keywords'] ?? $row['kata_kunci'] ?? null,
            'notes' => $row['catatan'] ?? $row['notes'] ?? null,
            'is_public' => $this->parseBoolean($row['publik'] ?? true)
        ]);
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'kategori' => 'required',
            'judul' => 'required',
            'tahun' => 'nullable|integer|min:2000|max:2100'
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'kategori.required' => 'Kolom kategori wajib diisi',
            'judul.required' => 'Kolom judul wajib diisi',
        ];
    }

    /**
     * Batch insert untuk performa
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk reading untuk file besar
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Find category ID by name or slug
     */
    private function findCategoryId($categoryName)
    {
        if (empty($categoryName)) {
            return null;
        }

        $key = strtolower(trim($categoryName));
        return $this->categoryMapping[$key] ?? null;
    }

    /**
     * Normalize format value
     */
    private function normalizeFormat($format)
    {
        $format = strtolower(trim($format));
        
        if (in_array($format, ['softcopy', 'hardcopy', 'keduanya'])) {
            return $format;
        }

        // Map variations
        $mapping = [
            'soft copy' => 'softcopy',
            'soft' => 'softcopy',
            'digital' => 'softcopy',
            'hard copy' => 'hardcopy',
            'hard' => 'hardcopy',
            'cetak' => 'hardcopy',
            'both' => 'keduanya',
            'semua' => 'keduanya'
        ];

        return $mapping[$format] ?? 'softcopy';
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Try various formats
            if (is_numeric($date)) {
                // Excel date serial
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'));
            }

            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse boolean value
     */
    private function parseBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = strtolower(trim($value));
        return in_array($value, ['yes', 'ya', 'true', '1', 'aktif', 'public']);
    }

    /**
     * Get import statistics
     */
    public function getStats()
    {
        return [
            'imported' => $this->importedCount,
            'skipped' => $this->skippedCount,
            'total' => $this->importedCount + $this->skippedCount
        ];
    }
}