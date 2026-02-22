<?php

use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\CommentManagementController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FasyankesController;
use App\Http\Controllers\Admin\FasyankesImportController;
use App\Http\Controllers\Admin\HealthProfileController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\InformationFlowController;
use App\Http\Controllers\Admin\InformationRequestController;
use App\Http\Controllers\Admin\KlinikController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PejabatStrukturalController;
use App\Http\Controllers\Admin\PpidCategoryController;
use App\Http\Controllers\Admin\PpidInformationController;
use App\Http\Controllers\Admin\ProdukHukumAdminController;
use App\Http\Controllers\Admin\StandarPelayananController as AdminStandarPelayananController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\TupoksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\AnnouncementPublicController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Author\ArticleController as AuthorArticleController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\ComplaintPublicController;
use App\Http\Controllers\FaqPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationRequestPublicController;
use App\Http\Controllers\PpidPublicController;
use App\Http\Controllers\ProdukHukumPublicController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\PublicFasyankesController;
use App\Http\Controllers\PublicGaleryController;
use App\Http\Controllers\PublicHealthProfileController;
use App\Http\Controllers\PublicProfilController;
use App\Http\Controllers\Reviewer\ArticleController as ReviewerArticleController;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboardController;
use App\Http\Controllers\ReviewPublicController;
use App\Http\Controllers\StandarPelayananController;
use App\Models\Faq;
use Illuminate\Support\Facades\Route;

// Redirect root ke login

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});



// Dashboard Routes - Auto redirect berdasarkan role
Route::middleware(['auth'])->group(function () {
Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if (!$user->role) {
            abort(403, 'Role user belum di-set');
        }

        return match ($user->role->slug) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'author' => redirect()->route('author.dashboard'),
            'reviewer' => redirect()->route('reviewer.dashboard'),
            default => abort(403, 'Role tidak dikenali'),
        };
    })->name('dashboard');
 
});

// Super Admin Routes
Route::middleware(['auth', 'check.role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/admin/categories/create', [CategoryController::class, 'create']);
        Route::resource('articles', AdminArticleController::class);

        Route::post('articles/{article}/publish', [AdminArticleController::class, 'publish'])->name('articles.publish');
        Route::patch('articles/{article}/unpublish', [AdminArticleController::class, 'unpublish'])->name('articles.unpublish');
        Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        
        // Quick actions
        Route::post('/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('toggle');
        Route::post('/{announcement}/toggle-pin', [AnnouncementController::class, 'togglePin'])->name('toggle-pin');
    });
        Route::resource('menus', MenuController::class);
        // media
        // Bulk delete HARUS sebelum resource
        Route::delete('images/bulk-delete', [ImageController::class, 'bulkDelete'])
                ->name('images.bulk-delete');   
        Route::resource('images', ImageController::class);
        // Fasyankes Routes
         // Dashboard
        Route::get('/fasyankes/dashboard', [FasyankesController::class, 'dashboard'])
            ->name('fasyankes.dashboard');
        Route::get('/fasyankes/maps', [FasyankesController::class, 'maps'])->name('fasyankes.maps');
        Route::delete('fasyankes/bulk-delete', [FasyankesController::class, 'bulkDelete'])->name('fasyankes.bulk-delete');
        Route::get('/fasyankes/import', [FasyankesImportController::class, 'index'])
        ->name('fasyankes.import');
        Route::post('/fasyankes/import', [FasyankesImportController::class, 'store'])
        ->name('fasyankes.import.store');
        Route::resource('fasyankes', FasyankesController::class);  
    // CRUD Kategori PPID
    Route::resource('ppid-categories', PpidCategoryController::class);
    // CRUD Informasi Publik
    Route::resource('ppid-informations', PpidInformationController::class);
    // Import
    Route::get('ppid-informations/import/form', [PpidInformationController::class, 'importForm'])
        ->name('ppid-informations.import-form');
    
    Route::post('ppid-informations/import', [PpidInformationController::class, 'import'])
        ->name('ppid-informations.import');
    // Export
    Route::get('ppid-informations/export/excel', [PpidInformationController::class, 'export'])
        ->name('ppid-informations.export');
    // Download Template
    Route::get('ppid-informations/download/template', [PpidInformationController::class, 'downloadTemplate'])
        ->name('ppid-informations.download-template');
        // Klinik Routes
    Route::resource('kliniks', KlinikController::class);

        // profil
    Route::resource('health-profiles', HealthProfileController::class)
            ->except(['show']);
    Route::get(
            'health-profiles/{healthProfile}/download',
            [HealthProfileController::class, 'download']
        )->name('health-profiles.download');

        // Komentar
    Route::get('/comments', [CommentManagementController::class, 'index'])
        ->name('comments.index');
    Route::put('/comments/{id}/approve', [CommentManagementController::class, 'approve'])
        ->name('comments.approve');
    Route::put('/comments/{id}/reject', [CommentManagementController::class, 'reject'])
        ->name('comments.reject');
    Route::delete('/comments/{id}', [CommentManagementController::class, 'destroy'])
        ->name('comments.destroy');
    Route::post('/comments/bulk-approve', [CommentManagementController::class, 'bulkApprove'])
        ->name('comments.bulk-approve');
    Route::post('/comments/bulk-reject', [CommentManagementController::class, 'bulkReject'])
        ->name('comments.bulk-reject');
    // Visi Misi
    Route::resource('visi-misi', VisiMisiController::class);
    Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
    // Struktur Organisasi
    Route::resource('struktur-organisasi', StrukturOrganisasiController::class);
    // Tupoksi
    Route::resource('tupoksi', TupoksiController::class);
    // Pejabat Struktural
     // Bulk delete HARUS sebelum resource
        Route::delete('pejabat/bulk-delete', [PejabatStrukturalController::class, 'bulkDelete'])
                ->name('pejabat.bulk-delete');
    Route::resource('pejabat', PejabatStrukturalController::class);
     // Alur Permohonan
    Route::resource('information-flows', InformationFlowController::class);
    
    // Kelola Permohonan
    Route::get('information-requests', [InformationRequestController::class, 'index'])
        ->name('information-requests.index');
    Route::get('information-requests/{id}', [InformationRequestController::class, 'show'])
        ->name('information-requests.show');
    Route::post('information-requests/{id}/status', [InformationRequestController::class, 'updateStatus'])
        ->name('information-requests.update-status');
    Route::post('information-requests/{id}/upload', [InformationRequestController::class, 'uploadResult'])
        ->name('information-requests.upload-result');
    Route::delete('information-requests/{id}', [InformationRequestController::class, 'destroy'])
        ->name('information-requests.destroy');
    Route::get('information-requests/export', [InformationRequestController::class, 'export'])
        ->name('information-requests.export');

        // Pengaduan
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/dashboard', [ComplaintController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [ComplaintController::class, 'index'])->name('index');
        Route::get('/{id}', [ComplaintController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [ComplaintController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/quick-status', [ComplaintController::class, 'quickStatus'])->name('quick-status');
        Route::delete('/{id}', [ComplaintController::class, 'destroy'])->name('destroy');
        Route::get('/export/excel', [ComplaintController::class, 'export'])->name('export');
    });
        Route::prefix('reviews')->name('reviews.')->group(function () {
        // List all reviews (with filter & search)
        Route::get('/', [AdminReviewController::class, 'index'])
            ->name('index');
        // Approve review
        Route::post('/{id}/approve', [AdminReviewController::class, 'approve'])
            ->name('approve'); 
        // Reject review
        Route::post('/{id}/reject', [AdminReviewController::class, 'reject'])
            ->name('reject');
        // Delete review
        Route::delete('/{id}', [AdminReviewController::class, 'destroy'])
            ->name('destroy');
        // Bulk approve
        Route::post('/bulk-approve', [AdminReviewController::class, 'bulkApprove'])
            ->name('bulk-approve');
        // Bulk delete
        Route::post('/bulk-delete', [AdminReviewController::class, 'bulkDelete'])
            ->name('bulk-delete');
         });
        Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/',                [FaqController::class, 'index'])->name('index');
        Route::get('/create',          [FaqController::class, 'create'])->name('create');
        Route::post('/',               [FaqController::class, 'store'])->name('store');
        Route::get('/{faq}/edit',      [FaqController::class, 'edit'])->name('edit');
        Route::put('/{faq}',           [FaqController::class, 'update'])->name('update');
        Route::delete('/{faq}',        [FaqController::class, 'destroy'])->name('destroy');
        Route::post('/{faq}/toggle',   [FaqController::class, 'toggle'])->name('toggle');
        Route::post('/bulk',           [FaqController::class, 'bulkAction'])->name('bulk');
        Route::post('/order',          [FaqController::class, 'updateOrder'])->name('order');
        });
        // standar pelayanan
    Route::prefix('admin/standar-pelayanan')->name('admin.standar-pelayanan.')
    ->middleware(['auth'])->group(function () {
        Route::get('/',                      [AdminStandarPelayananController::class, 'index'])->name('index');
        Route::get('/create',                [AdminStandarPelayananController::class, 'create'])->name('create');
        Route::post('/',                     [AdminStandarPelayananController::class, 'store'])->name('store');
        Route::get('/{standarPelayanan}/edit',[AdminStandarPelayananController::class, 'edit'])->name('edit');
        Route::put('/{standarPelayanan}',    [AdminStandarPelayananController::class, 'update'])->name('update');
        Route::delete('/{standarPelayanan}', [AdminStandarPelayananController::class, 'destroy'])->name('destroy');
        Route::post('/{standarPelayanan}/toggle', [AdminStandarPelayananController::class, 'toggle'])->name('toggle');
        Route::post('/bulk',                 [AdminStandarPelayananController::class, 'bulkAction'])->name('bulk');
    });
// Produk Hukum
Route::prefix('produk-hukum')->name('produkhukum.')->group(function () {
        // CRUD
        Route::get('/', [ProdukHukumAdminController::class, 'index'])->name('index');
        Route::get('/create', [ProdukHukumAdminController::class, 'create'])->name('create');
        Route::post('/', [ProdukHukumAdminController::class, 'store'])->name('store');
        Route::get('/{produkHukum}/edit', [ProdukHukumAdminController::class, 'edit'])->name('edit');
        Route::put('/{produkHukum}', [ProdukHukumAdminController::class, 'update'])->name('update');
        Route::delete('/{produkHukum}', [ProdukHukumAdminController::class, 'destroy'])->name('destroy');
        
        // Quick Actions
        Route::post('/{produkHukum}/toggle', [ProdukHukumAdminController::class, 'toggle'])->name('toggle');
        
        // Bulk Actions
        Route::post('/bulk-delete', [ProdukHukumAdminController::class, 'bulkDelete'])->name('bulk-delete');
    });

    });

// Author Routes
Route::middleware(['auth', 'check.role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');

        Route::resource('articles', AuthorArticleController::class)->except(['show']);
    });

// Reviewer Routes
Route::middleware(['auth', 'check.role:reviewer'])
    ->prefix('reviewer')
    ->name('reviewer.')
    ->group(function () {
        Route::get('/dashboard', [ReviewerDashboardController::class, 'index'])->name('dashboard');

        Route::get('articles', [ReviewerArticleController::class, 'index'])->name('articles.index');
        Route::get('articles/{article}', [ReviewerArticleController::class, 'show'])->name('articles.show');
        Route::post('articles/{article}/approve', [ReviewerArticleController::class, 'approve'])->name('articles.approve');
        Route::post('articles/{article}/reject', [ReviewerArticleController::class, 'reject'])->name('articles.reject');
    });

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');
   
});

// USER PUBLIC
Route::get('/fasilitas-kesehatan', [PublicFasyankesController::class, 'index'])
    ->name('fasyankes.public');

Route::get('/fasilitas-kesehatan/{id}', [PublicFasyankesController::class, 'show'])
    ->name('fasyankes.show');
// Public Fasyankes Map Routes
Route::get('/peta-fasyankes', [PublicFasyankesController::class,'maps'])
    ->name('fasyankes.map');

// Route untuk halaman publik artikel
Route::get('/berita', [PublicArticleController::class, 'index'])
    ->name('articles.public');

Route::get('/berita/{id}', [PublicArticleController::class, 'show'])
    ->name('articles.show');

// Route untuk update view count (opsional)
Route::post('/berita/{id}/view', [PublicArticleController::class, 'updateViews'])
    ->name('articles.view');
// Route Komentar
Route::post('/articles/{article}/comments', [ArticleCommentController::class, 'store'])
    ->name('articles.comments.store');

// Submit komentar dari publik - DENGAN RATE LIMITING
// User hanya bisa submit 3 komentar per 10 menit
Route::post('/articles/{article}/comments', [ArticleCommentController::class, 'store'])
    ->middleware('throttle:3,10')  // Rate limit di sini
    ->name('articles.comments.store');

// Get approved comments (optional - untuk AJAX)
Route::get('/articles/{article}/comments', [ArticleCommentController::class, 'getApprovedComments'])
    ->name('articles.comments.get');

// Public Routes
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [PublicProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [PublicProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [PublicProfilController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/tupoksi', [PublicProfilController::class, 'tupoksi'])->name('tupoksi');
    Route::get('/pejabat', [PublicProfilController::class, 'pejabat'])->name('pejabat');
});

// public galery
Route::get('/gallery', [PublicGaleryController::class, 'index'])->name('galery.public');

// Public Health Profile Routes
Route::get('/profil-kesehatan', [PublicHealthProfileController::class, 'index'])
    ->name('public.health-profiles');

Route::get('/profil-kesehatan/download/{id}', [PublicHealthProfileController::class, 'download'])
    ->name('health-profiles.download');

// ========================================
// PUBLIC: Information Request
// ========================================

// Halaman Alur Permohonan & FAQ
Route::get('/permohonan-informasi', [InformationRequestPublicController::class, 'flow'])
    ->name('information.flow');

// Form Pengajuan
Route::get('/permohonan-informasi/ajukan', [InformationRequestPublicController::class, 'create'])
    ->name('information.create');
Route::post('/permohonan-informasi/submit', [InformationRequestPublicController::class, 'store'])
    ->name('information.store');

// Tracking
Route::get('/permohonan-informasi/lacak/{registrationNumber?}', [InformationRequestPublicController::class, 'tracking'])
    ->name('information.tracking');
Route::post('/permohonan-informasi/search', [InformationRequestPublicController::class, 'searchTracking'])
    ->name('information.search-tracking');

// Download Hasil
Route::get('/permohonan-informasi/download/{id}', [InformationRequestPublicController::class, 'downloadResult'])
    ->name('information.download-result');

// PPID
Route::prefix('ppid')->name('ppid.')->group(function () {
  Route::get('/', [PpidPublicController::class, 'index'])->name('index');
    Route::get('/kategori/{slug}', [PpidPublicController::class, 'byCategory'])->name('by-category');
    Route::get('/{id}', [PpidPublicController::class, 'show'])->name('show');
    Route::get('/{id}/download', [PpidPublicController::class, 'download'])->name('download');
});
Route::prefix('pengaduan')->name('public.complaints.')->group(function () {
    
    // Halaman Layanan Pengaduan (List semua kategori)
    Route::get('/layanan', [ComplaintPublicController::class, 'services'])
        ->name('services');
    
    // Form Pengaduan
    Route::get('/ajukan/{serviceSlug?}', [ComplaintPublicController::class, 'create'])
        ->name('create');
    
    // Submit Pengaduan
    Route::post('/submit', [ComplaintPublicController::class, 'store'])
        ->name('store');
    // Success Page (setelah submit)
    Route::get('/sukses/{ticketNumber}', [ComplaintPublicController::class, 'success'])
        ->name('success'); 
    // Tracking Page
    Route::get('/lacak/{ticketNumber?}', [ComplaintPublicController::class, 'track'])
        ->name('track');
    // Search Complaint (POST)
    Route::post('/cari', [ComplaintPublicController::class, 'search'])
        ->name('search');
    // Detail Pengaduan
    Route::get('/detail/{ticketNumber}', [ComplaintPublicController::class, 'show'])
        ->name('show');  
    // Download Evidence File
    Route::get('/download-bukti/{ticketNumber}', [ComplaintPublicController::class, 'downloadEvidence'])
        ->name('download-evidence');  
    // Download Response File
    Route::get('/download-tanggapan/{ticketNumber}', [ComplaintPublicController::class, 'downloadResponse'])
        ->name('download-response');
    
    // Submit Feedback & Rating
    Route::post('/feedback/{ticketNumber}', [ComplaintPublicController::class, 'submitFeedback'])
        ->name('submit-feedback');
});

// review
Route::prefix('review')->name('public.reviews.')->group(function () {  
    // Display all approved reviews
    Route::get('/', [ReviewPublicController::class, 'index'])
        ->name('index');
    // Form to submit review
    Route::get('/tulis', [ReviewPublicController::class, 'create'])
        ->name('create');
    // Store review
    Route::post('/submit', [ReviewPublicController::class, 'store'])
        ->name('store');
    // Success page
    Route::get('/sukses', [ReviewPublicController::class, 'success'])
        ->name('success');
});
// ─── PUBLIC ────────────────────────────────────────────────
Route::get('/faq', [FaqPublicController::class, 'index'])->name('faqs.index');
Route::post('/faq/{faq}/helpful', function (Faq $faq) {
    $faq->incrementView();
    return response()->json(['ok' => true]);
})->name('faqs.helpful');

Route::prefix('standar_pelayanan')->name('public.standar_pelayanan.')->group(function () {
    Route::get('/',          [StandarPelayananController::class, 'index'])->name('index');
    Route::get('/{standarPelayanan:slug}', [StandarPelayananController::class, 'show'])->name('show');
});
// pengumuman 
Route::prefix('pengumuman')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementPublicController::class, 'index'])->name('index');
    Route::get('/{id}', [AnnouncementPublicController::class, 'show'])->name('show');
});
// Produk hukum 
Route::prefix('produk-hukum')->name('produkhukum.')->group(function () {
    Route::get('/', [ProdukHukumPublicController::class, 'index'])->name('index');
    Route::get('/{produkHukum}', [ProdukHukumPublicController::class, 'show'])->name('show');
    Route::get('/{produkHukum}/download', [ProdukHukumPublicController::class, 'download'])->name('download');
});




