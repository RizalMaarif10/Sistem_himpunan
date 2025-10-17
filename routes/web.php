<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboard;
use App\Http\Controllers\Bendahara\CashbookController;
use App\Http\Controllers\Bendahara\IncomesController;
use App\Http\Controllers\Bendahara\ExpensesController;
use App\Http\Controllers\Bendahara\CategoriesController;
use App\Http\Controllers\Bendahara\AccountsController;
use App\Http\Controllers\Bendahara\ReportController;
use App\Http\Controllers\Sekretariat\DashboardController as SekretariatDashboard;
use App\Http\Controllers\Sekretariat\LettersController;
use App\Http\Controllers\Sekretariat\MinutesController;
use App\Http\Controllers\Sekretariat\MessagesController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('agenda')->name('agenda.')->group(function () {
    Route::get('/', [AgendaController::class, 'index'])->name('index');
    Route::get('/{event:slug}', [AgendaController::class, 'show'])->name('show');
});


Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{post:slug}', [BeritaController::class, 'show'])->name('show');
});


Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    // pakai {photo} (id) agar tidak perlu slug
    Route::get('/{photo}', [GaleriController::class, 'show'])->name('show');
});


Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');


Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');


// routes/web.php
// routes/web.php
Route::get('/pengurus/login', [LoginController::class, 'show'])->name('login');

// POST tetap pakai guest + throttle
Route::post('/pengurus/login', [LoginController::class, 'store'])
    ->middleware(['guest','throttle:5,1'])
    ->name('login.store');




Route::post('/pengurus/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


// routes/web.php

Route::prefix('admin')->name('admin.')
    ->middleware(['auth', 'role:admin']) // hanya admin
    ->group(function () {
        // Dashboard admin
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        // CRUD Agenda (Event) → admin.events.*
         Route::resource('events', \App\Http\Controllers\Admin\EventController::class)
            ->except(['show'])
            ->parameters(['events' => 'event']);
    });


Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::resource('posts', PostController::class)
         ->except(['show'])
         ->parameters(['posts' => 'post']); // admin.posts.*
});

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::resource('photos', PhotoController::class)
         ->except(['show'])                // admin.photos.*
         ->parameters(['photos' => 'photo']);
});


Route::prefix('bendahara')->name('bendahara.')
    ->middleware(['auth','role:bendahara,admin'])
    ->group(function () {
        Route::get('/', [BendaharaDashboard::class, 'index'])->name('dashboard');

        Route::get('cash', [CashbookController::class, 'index'])->name('cash.index');

        Route::resource('incomes', IncomesController::class)->except(['show']);
        Route::resource('expenses', ExpensesController::class)->except(['show']);
        Route::resource('categories', CategoriesController::class)->except(['show']);
        Route::resource('accounts', AccountsController::class)->except(['show']);

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        // (opsional) ekspor:
        Route::get('reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
    });

    Route::prefix('sekretariat')->name('sekretariat.')
    ->middleware(['auth','role:sekretaris,admin'])
    ->group(function () {
        Route::get('/', [SekretariatDashboard::class, 'index'])->name('dashboard');

        // Surat (index bisa difilter ?type=incoming|outgoing)
        Route::resource('letters', LettersController::class)->except(['show'])
              ->parameters(['letters' => 'letter']);
        Route::get('letters/incoming', [LettersController::class, 'incoming'])->name('letters.incoming');
        Route::get('letters/outgoing', [LettersController::class, 'outgoing'])->name('letters.outgoing');

        // Notulen rapat
        Route::resource('minutes', MinutesController::class)->except(['show'])
              ->parameters(['minutes' => 'minute']);

        // Pesan kontak
        Route::resource('messages', MessagesController::class)->only(['index','show','destroy'])
              ->parameters(['messages' => 'message']);
        Route::patch('messages/{message}/read', [MessagesController::class, 'markRead'])->name('messages.read');
    });
