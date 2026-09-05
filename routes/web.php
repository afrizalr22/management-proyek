<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Mandor\Dashboard as MandorDashboard;
use App\Livewire\Pekerja\Dashboard as PekerjaDashboard;

// Clients
use App\Livewire\Owner\Clients\Index as ClientsIndex;
use App\Livewire\Owner\Clients\Show as ClientsShow;
use App\Livewire\Owner\Clients\Create as ClientsCreate;
use App\Livewire\Owner\Clients\Edit as ClientsEdit;

// Projects
use App\Livewire\Owner\Projects\Index as ProjectsIndex;
use App\Livewire\Owner\Projects\Show as ProjectsShow;
use App\Livewire\Owner\Projects\Create as ProjectCreate;
use App\Livewire\Owner\Projects\Delete as ProjectsDelete;
use App\Livewire\Owner\Projects\Edit as ProjectEdit;

// Quotations
use App\Livewire\Owner\Quotations\Create as QuotationsCreate;
use App\Livewire\Owner\Quotations\Show as QuotationsShow;
use App\Livewire\Owner\Quotations\Edit as QuotationsEdit;
use App\Livewire\Owner\Quotations\Delete as QuotationsDelete;
use App\Livewire\Owner\Quotations\Index as QuotationsIndex;

// Invoices
use App\Livewire\Owner\Invoices\Index as InvoicesIndex;
use App\Livewire\Owner\Invoices\Create as InvoicesCreate;
use App\Livewire\Owner\Invoices\Edit as InvoicesEdit;
use App\Livewire\Owner\Invoices\Show as InvoicesShow;
use App\Livewire\Owner\Invoices\Delete as InvoicesDelete;

// Monitoring
use App\Livewire\Owner\Monitoring\Index as MonitoringIndex;
use App\Livewire\Owner\Monitoring\Show as MonitoringShow;
use App\Livewire\Owner\Monitoring\Documentation as MonitoringDocumentation;

// Users
use App\Livewire\Owner\Users\Index as UsersIndex;
use App\Livewire\Owner\Users\Create as UsersCreate;
use App\Livewire\Owner\Users\Edit as UsersEdit;
use App\Livewire\Owner\Users\Show as UsersShow;
use App\Livewire\Owner\Users\Delete as UsersDelete;

use App\Livewire\Mandor\Projects\Index as MandorProjectsIndex;
use App\Livewire\Mandor\Projects\Show as MandorProjectsShow;

use App\Livewire\Mandor\WorkProgress\Index as MandorWorkProgressIndex;

use App\Livewire\Mandor\Documentations\Index as MandorDocumentationsIndex;

use App\Livewire\Mandor\DailyReports\Index as MandorDailyReportsIndex;
use App\Livewire\Mandor\DailyReports\Create as MandoDailyReportsCreate;
use App\Livewire\Mandor\DailyReports\Show as MandorDailyReportsShow;
use App\Livewire\Mandor\DailyReports\Edit as MandorDailyReportsEdit;

use App\Livewire\Pekerja\Tasks\Index as PekerjaTaskIndex;

use App\Livewire\Pekerja\Documentation\Index as PekerjaDocumentationIndex;
use App\Livewire\Pekerja\Documentation\Create as PekerjaDocumentationCreate;

use App\Livewire\Pekerja\Report\Index as PekerjaReportIndex;
use App\Livewire\Pekerja\Report\Create as PekerjaReportCreate;
use App\Livewire\Pekerja\Report\Show as PekerjaReportShow;

use App\Livewire\Pekerja\Profile\Index as PekerjaProfileIndex;

use App\Livewire\Owner\Profile as Profile;

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:owner',])->group(function () {

    Route::get('/owner/dashboard',OwnerDashboard::class)->name('owner.dashboard');

    Route::get('/profile',Profile::class)->name('owner.profile');

Route::prefix('clients')
    ->name('owner.clients.')
    ->group(function () {
        Route::get('/', ClientsIndex::class)
            ->name('index');

        Route::get('/create', ClientsCreate::class)
            ->name('create');

        Route::get('/{client}/edit', ClientsEdit::class)
            ->whereNumber('client')
            ->name('edit');

        Route::get('/{client}', ClientsShow::class)
            ->whereNumber('client')
            ->name('show');
    });

    Route::prefix('projects')->name('owner.projects.')->group(function () {
            Route::get('/projects', ProjectsIndex::class)->name('index');
            Route::get('/create', ProjectCreate::class)->name('create');
            Route::get('/{project}/edit', ProjectEdit::class)->name('edit');
            Route::get('/projects/{project}', ProjectsShow::class)->name('show');
            Route::get('/{project}/delete', ProjectsDelete::class)->name('delete');
        });

Route::prefix('quotations')
    ->name('owner.quotations.')
    ->group(function () {
        Route::get('/', QuotationsIndex::class)
            ->name('index');

        Route::get('/create', QuotationsCreate::class)
            ->name('create');

        Route::get('/{quotation}/edit', QuotationsEdit::class)
            ->whereNumber('quotation')
            ->name('edit');

        Route::get('/{quotation}/delete', QuotationsDelete::class)
            ->whereNumber('quotation')
            ->name('delete');

        Route::get('/{quotation}', QuotationsShow::class)
            ->whereNumber('quotation')
            ->name('show');
    });

    Route::prefix('invoices')->name('owner.invoices.')->group(function () {
            Route::get('', InvoicesIndex::class)->name('index');
            Route::get('/create', InvoicesCreate::class)->name('create');
            Route::get('/{invoice}/edit', InvoicesEdit::class)->name('edit');
            Route::get('/invoices/{invoice}', InvoicesShow::class)->name('show');
            Route::get('/{invoice}/delete', InvoicesDelete::class)->name('delete');
        });

    Route::prefix('monitoring')->name('owner.monitoring.')->group(function () {
            Route::get('', MonitoringIndex::class)->name('index');
            Route::get('/projects/{project}', MonitoringShow::class)->name('show');
            Route::get('/{project}/documentation', MonitoringDocumentation::class)->name('documentation');
        });

    Route::prefix('users')->name('owner.users.')->group(function () {
            Route::get('', UsersIndex::class)->name('index');
            Route::get('/create', UsersCreate::class)->name('create');
            Route::get('/{user}/edit', UsersEdit::class)->name('edit');
            Route::get('/user/{user}', UsersShow::class)->name('show');
            Route::get('/{user}/delete', UsersDelete::class)->name('delete');
        });
});


/*
|--------------------------------------------------------------------------
| Mandor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:mandor',])->group(function () {
    Route::get('/mandor/dashboard',MandorDashboard::class)->name('mandor.dashboard');
    Route::get('/projects', MandorProjectsIndex::class)->name('mandor.projects.index');
    Route::get('/projects/{project}',MandorProjectsShow::class)->name('mandor.projects.show');
    Route::get('/projects/{project}/work-progress', MandorWorkProgressIndex::class)->name('mandor.projects.work-progress.index');
    Route::get('/projects/{project}/documentations', MandorDocumentationsIndex::class)->name('mandor.projects.documentations.index');
    Route::get('/daily-reports', MandorDailyReportsIndex::class)->name('mandor.daily-reports.index');
    Route::get('/daily-reports/create', MandoDailyReportsCreate::class)->name('mandor.daily-reports.create');
    Route::get('/daily-reports/{report}', MandorDailyReportsShow::class)->name('mandor.daily-reports.show');
    Route::get('/daily-reports/{report}/edit', MandorDailyReportsEdit::class)->name('mandor.daily-reports.edit');
});


/*
|--------------------------------------------------------------------------
| Worker Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:pekerja',])->group(function () {

    Route::get('/pekerja/dashboard',PekerjaDashboard::class)->name('pekerja.dashboard');
    Route::get('/pekerja/tasks', PekerjaTaskIndex::class)->name('pekerja.task.index');

    Route::get('/pekerja/documentation', PekerjaDocumentationIndex::class)->name('pekerja.documentation.index');
    Route::get('/pekerja/documentation/create', PekerjaDocumentationCreate::class)->name('pekerja.documentation.create');

    Route::get('/pekerja/report/index', PekerjaReportIndex::class)->name('pekerja.report.index');
    Route::get('/pekerja/report/create', PekerjaReportCreate::class)->name('pekerja.report.create');
    Route::get('/pekerja/report/{report}/show', PekerjaReportShow::class)->name('pekerja.report.show');

    Route::get('/pekerja/profile', PekerjaProfileIndex::class)->name('pekerja.profile.index');
    

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('login');

})->middleware('auth')->name('logout');


require __DIR__ . '/auth.php';