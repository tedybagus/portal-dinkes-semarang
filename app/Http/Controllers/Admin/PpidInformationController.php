<?php

namespace App\Http\Controllers\Admin;


use App\Models\PpidCategory;
use Illuminate\Http\Request;
use App\Models\PpidInformation;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PpidInformationsExport;
use App\Imports\PpidInformationsImport;
use Illuminate\Support\Facades\Storage;
use App\Exports\PpidInformationsTemplateExport;


class PpidInformationController extends Controller
{
    public function index(Request $request)
    {
        $query = PpidInformation::with('category')->latest();

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('ppid_category_id', $request->category);
        }

        // Filter by year
        if ($request->has('year') && $request->year != 'all') {
            $query->where('year', $request->year);
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        $informations = $query->paginate(20);
        $categories = PpidCategory::active()->ordered()->get();
        $years = PpidInformation::distinct()->orderBy('year', 'desc')->pluck('year');

        $stats = [
            'total' => PpidInformation::count(),
            'public' => PpidInformation::where('is_public', true)->count(),
            'this_year' => PpidInformation::where('year', date('Y'))->count(),
            'total_downloads' => PpidInformation::sum('download_count'),
        ];

        return view('admin.ppid.informations.index', compact('informations', 'categories', 'years', 'stats'));
    }

    public function create()
    {
        $categories = PpidCategory::active()->ordered()->get();
        return view('admin.ppid.informations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ppid_category_id' => 'required|exists:ppid_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'information_number' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'responsible_unit' => 'nullable|string|max:100',
            'information_format' => 'nullable|in:softcopy,hardcopy,keduanya',
            'year' => 'required|integer|min:2000|max:2100',
            'published_date' => 'nullable|date',
            'validity_period' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'external_link' => 'nullable|url',
            'keywords' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_public' => 'boolean',
            'permanent_validity' => 'nullable|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('ppid-documents', 'public');
            $validated['file_size'] = $this->formatBytes($file->getSize());
        }
        // Jika permanent_validity = true, kosongkan validity_period
        if ($request->has('permanent_validity') && $request->permanent_validity) {
            $validated['validity_period'] = null;
        }

        PpidInformation::create($validated);

        return redirect()->route('admin.ppid-informations.index')
            ->with('success', 'Informasi publik berhasil ditambahkan');
    }

    public function edit($id)
    {
        $information = PpidInformation::findOrFail($id);
        $categories = PpidCategory::active()->ordered()->get();
        return view('admin.ppid.informations.edit', compact('information', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $information = PpidInformation::findOrFail($id);

        $validated = $request->validate([
            'ppid_category_id' => 'required|exists:ppid_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'information_number' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'responsible_unit' => 'nullable|string|max:100',
            'information_format' => 'nullable|in:softcopy,hardcopy,keduanya',
            'year' => 'required|integer|min:2000|max:2100',
            'published_date' => 'nullable|date',
            'validity_period' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'external_link' => 'nullable|url',
            'keywords' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_public' => 'boolean',
            'permanent_validity' => 'nullable|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($information->file_path && Storage::disk('public')->exists($information->file_path)) {
                Storage::disk('public')->delete($information->file_path);
            }

            $file = $request->file('file');
            $validated['file_path'] = $file->store('ppid-documents', 'public');
            $validated['file_size'] = $this->formatBytes($file->getSize());
        }

        $information->update($validated);

        return redirect()->route('admin.ppid-informations.index')
            ->with('success', 'Informasi publik berhasil diupdate');
    }

    public function destroy($id)
    {
        $information = PpidInformation::findOrFail($id);

        // Delete file
        if ($information->file_path && Storage::disk('public')->exists($information->file_path)) {
            Storage::disk('public')->delete($information->file_path);
        }

        $information->delete();

        return redirect()->route('admin.ppid-informations.index')
            ->with('success', 'Informasi publik berhasil dihapus');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        $categories = PpidCategory::active()->ordered()->get();
        return view('admin.ppid.informations.import', compact('categories'));
    }

    /**
     * Process import
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120'
        ]);

        try {
            $import = new PpidInformationsImport();
            
            Excel::import($import, $request->file('file'));

            $stats = $import->getStats();

            $message = "Import berhasil! {$stats['imported']} data diimport";
            if ($stats['skipped'] > 0) {
                $message .= ", {$stats['skipped']} data dilewati (kategori tidak valid)";
            }

            return redirect()->route('admin.ppid-informations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import gagal: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $filters = [
            'category_id' => $request->category,
            'year' => $request->year,
            'is_public' => $request->is_public
        ];

        $filename = 'Daftar_Informasi_Publik_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new PpidInformationsExport($filters), $filename);
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        $filename = 'Template_Import_PPID.xlsx';
        
        return Excel::download(new PpidInformationsTemplateExport(), $filename);
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}