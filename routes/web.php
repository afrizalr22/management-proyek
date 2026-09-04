<?php

use App\Livewire\Mandor\DailyReports\Create as MandorDailyReportsCreate;
use App\Livewire\Mandor\DailyReports\Edit as MandorDailyReportsEdit;
use App\Livewire\Mandor\DailyReports\Index as MandorDailyReportsIndex;
use App\Livewire\Mandor\DailyReports\Show as MandorDailyReportsShow;
use App\Livewire\Mandor\Dashboard as MandorDashboard;
use App\Livewire\Mandor\Documentations\Index as MandorDocumentationsIndex;
use App\Livewire\Mandor\Projects\Index as MandorProjectsIndex;
use App\Livewire\Mandor\Projects\Show as MandorProjectsShow;
use App\Livewire\Mandor\WorkProgress\Index as MandorWorkProgressIndex;

use App\Livewire\Owner\Clients\Create as OwnerClientsCreate;
use App\Livewire\Owner\Clients\Delete as OwnerClientsDelete;
use App\Livewire\Owner\Clients\Edit as OwnerClientsEdit;
use App\Livewire\Owner\Clients\Index as OwnerClientsIndex;
use App\Livewire\Owner\Clients\Show as OwnerClientsShow;
use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Owner\Invoices\Create as OwnerInvoicesCreate;
use App\Livewire\Owner\Invoices\Delete as OwnerInvoicesDelete;
use App\Livewire\Owner\Invoices\Edit as OwnerInvoicesEdit;
use App\Livewire\Owner\Invoices\Index as OwnerInvoicesIndex;
use App\Livewire\Owner\Invoices\Show as OwnerInvoicesShow;
use App\Livewire\Owner\Monitoring\Documentation as OwnerMonitoringDocumentation;
use App\Livewire\Owner\Monitoring\Index as OwnerMonitoringIndex;
use App\Livewire\Owner\Monitoring\Show as OwnerMonitoringShow;
use App\Livewire\Owner\Profile as OwnerProfile;
use App\Livewire\Owner\Projects\Create as OwnerProjectsCreate;
use App\Livewire\Owner\Projects\Delete as OwnerProjectsDelete;
use App\Livewire\Owner\Projects\Edit as OwnerProjectsEdit;
use App\Livewire\Owner\Projects\Index as OwnerProjectsIndex;
use App\Livewire\Owner\Projects\Show as OwnerProjectsShow;
use App\Livewire\Owner\Quotations\Create as OwnerQuotationsCreate;
use App\Livewire\Owner\Quotations\Delete as OwnerQuotationsDelete;
use App\Livewire\Owner\Quotations\Edit as OwnerQuotationsEdit;
use App\Livewire\Owner\Quotations\Index as OwnerQuotationsIndex;
use App\Livewire\Owner\Quotations\Show as OwnerQuotationsShow;
use App\Livewire\Owner\Users\Create as OwnerUsersCreate;
use App\Livewire\Owner\Users\Delete as OwnerUsersDelete;
use App\Livewire\Owner\Users\Edit as OwnerUsersEdit;
use App\Livewire\Owner\Users\Index as OwnerUsersIndex;
use App\Livewire\Owner\Users\Show as OwnerUsersShow;

use App\Livewire\Pekerja\Dashboard as PekerjaDashboard;
use App\Livewire\Pekerja\Documentations\Create as PekerjaDocumentationsCreate;
use App\Livewire\Pekerja\Documentations\Index as PekerjaDocumentationsIndex;
use App\Livewire\Pekerja\Profile\Index as PekerjaProfileIndex;
use App\Livewire\Pekerja\Reports\Create as PekerjaReportsCreate;
use App\Livewire\Pekerja\Reports\Index as PekerjaReportsIndex;
use App\Livewire\Pekerja\Reports\Show as PekerjaReportsShow;
use App\Livewire\Pekerja\Tasks\Index as PekerjaTasksIndex;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;    
/*
|--------------------------------------------------------------------------
| Halaman Awal
|-------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Pengarah Dashboard Berdasarkan Role
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user instanceof User) {
        return redirect()->route('login');
    }

    if ($user->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    }

    if ($user->hasRole('mandor')) {
        return redirect()->route('mandor.dashboard');
    }

    if ($user->hasRole('pekerja')) {
        return redirect()->route('pekerja.dashboard');
    }

    Auth::logout();

    return redirect()
        ->route('login')
        ->withErrors([
            'email' => 'Akun belum memiliki role yang valid.',
        ]);
})
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Pengarah Profile Berdasarkan Role
|--------------------------------------------------------------------------
*/

Route::get('/profile', function () {
    $user = Auth::user();

    if (!$user instanceof User) {
        return redirect()->route('login');
    }

    if ($user->hasRole('owner')) {
        return redirect()->route('owner.profile');
    }

    if ($user->hasRole('pekerja')) {
        return redirect()->route('pekerja.profile.index');
    }

    return redirect()->route('dashboard');
})
    ->middleware('auth')
    ->name('profile');

/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::prefix('owner')
    ->name('owner.')
    ->middleware([
        'auth',
        'role:owner',
    ])
    ->group(function () {
        Route::get('/dashboard', OwnerDashboard::class)
            ->name('dashboard');

        Route::get('/profile', OwnerProfile::class)
            ->name('profile');

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        Route::prefix('clients')
            ->name('clients.')
            ->group(function () {
                Route::get('/', OwnerClientsIndex::class)
                    ->name('index');

                Route::get('/create', OwnerClientsCreate::class)
                    ->name('create');

                Route::get('/{client}/edit', OwnerClientsEdit::class)
                    ->whereNumber('client')
                    ->name('edit');

                Route::get('/{client}/delete', OwnerClientsDelete::class)
                    ->whereNumber('client')
                    ->name('delete');

                Route::get('/{client}', OwnerClientsShow::class)
                    ->whereNumber('client')
                    ->name('show');
            });

        /*
        |--------------------------------------------------------------------------
        | Quotations
        |--------------------------------------------------------------------------
        */

        Route::prefix('quotations')
            ->name('quotations.')
            ->group(function () {
                Route::get('/', OwnerQuotationsIndex::class)
                    ->name('index');

                Route::get('/create', OwnerQuotationsCreate::class)
                    ->name('create');

                Route::get('/{quotation}/edit', OwnerQuotationsEdit::class)
                    ->whereNumber('quotation')
                    ->name('edit');

                Route::get('/{quotation}/delete', OwnerQuotationsDelete::class)
                    ->whereNumber('quotation')
                    ->name('delete');

                Route::get('/{quotation}', OwnerQuotationsShow::class)
                    ->whereNumber('quotation')
                    ->name('show');
            });

        /*
        |--------------------------------------------------------------------------
        | Projects
        |--------------------------------------------------------------------------
        */

        Route::prefix('projects')
            ->name('projects.')
            ->group(function () {
                Route::get('/', OwnerProjectsIndex::class)
                    ->name('index');

                Route::get('/create', OwnerProjectsCreate::class)
                    ->name('create');

                Route::get('/{project}/edit', OwnerProjectsEdit::class)
                    ->whereNumber('project')
                    ->name('edit');

                Route::get('/{project}/delete', OwnerProjectsDelete::class)
                    ->whereNumber('project')
                    ->name('delete');

                Route::get('/{project}', OwnerProjectsShow::class)
                    ->whereNumber('project')
                    ->name('show');
            });

        /*
        |--------------------------------------------------------------------------
        | Invoices
        |--------------------------------------------------------------------------
        */

        Route::prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', OwnerInvoicesIndex::class)
                    ->name('index');

                Route::get('/create', OwnerInvoicesCreate::class)
                    ->name('create');

                Route::get('/{invoice}/edit', OwnerInvoicesEdit::class)
                    ->whereNumber('invoice')
                    ->name('edit');

                Route::get('/{invoice}/delete', OwnerInvoicesDelete::class)
                    ->whereNumber('invoice')
                    ->name('delete');

                Route::get('/{invoice}', OwnerInvoicesShow::class)
                    ->whereNumber('invoice')
                    ->name('show');
            });

        /*
        |--------------------------------------------------------------------------
        | Monitoring
        |--------------------------------------------------------------------------
        */

        Route::prefix('monitoring')
            ->name('monitoring.')
            ->group(function () {
                Route::get('/', OwnerMonitoringIndex::class)
                    ->name('index');

                Route::get(
                    '/projects/{project}/documentation',
                    OwnerMonitoringDocumentation::class
                )
                    ->whereNumber('project')
                    ->name('documentation');

                Route::get(
                    '/projects/{project}',
                    OwnerMonitoringShow::class
                )
                    ->whereNumber('project')
                    ->name('show');
            });

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/', OwnerUsersIndex::class)
                    ->name('index');

                Route::get('/create', OwnerUsersCreate::class)
                    ->name('create');

                Route::get('/{user}/edit', OwnerUsersEdit::class)
                    ->whereNumber('user')
                    ->name('edit');

                Route::get('/{user}/delete', OwnerUsersDelete::class)
                    ->whereNumber('user')
                    ->name('delete');

                Route::get('/{user}', OwnerUsersShow::class)
                    ->whereNumber('user')
                    ->name('show');
            });
    });

/*
|--------------------------------------------------------------------------
| Mandor Routes
|--------------------------------------------------------------------------
*/

Route::prefix('mandor')
    ->name('mandor.')
    ->middleware([
        'auth',
        'role:mandor',
    ])
    ->group(function () {
        Route::get('/dashboard', MandorDashboard::class)
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Projects
        |--------------------------------------------------------------------------
        */

        Route::get('/projects', MandorProjectsIndex::class)
            ->name('projects.index');

        Route::get(
            '/projects/{project}/work-progress',
            MandorWorkProgressIndex::class
        )
            ->whereNumber('project')
            ->name('projects.work-progress.index');

        Route::get(
            '/projects/{project}/documentations',
            MandorDocumentationsIndex::class
        )
            ->whereNumber('project')
            ->name('projects.documentations.index');

        Route::get('/projects/{project}', MandorProjectsShow::class)
            ->whereNumber('project')
            ->name('projects.show');

        /*
        |--------------------------------------------------------------------------
        | Daily Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/daily-reports', MandorDailyReportsIndex::class)
            ->name('daily-reports.index');

        Route::get(
            '/daily-reports/create',
            MandorDailyReportsCreate::class
        )
            ->name('daily-reports.create');

        Route::get(
            '/daily-reports/{report}/edit',
            MandorDailyReportsEdit::class
        )
            ->whereNumber('report')
            ->name('daily-reports.edit');

        Route::get(
            '/daily-reports/{report}',
            MandorDailyReportsShow::class
        )
            ->whereNumber('report')
            ->name('daily-reports.show');
    });

/*
|--------------------------------------------------------------------------
| Pekerja Routes
|--------------------------------------------------------------------------
*/

Route::prefix('pekerja')
    ->name('pekerja.')
    ->middleware([
        'auth',
        'role:pekerja',
    ])
    ->group(function () {
        Route::get('/dashboard', PekerjaDashboard::class)
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Tasks
        |--------------------------------------------------------------------------
        */

        Route::get('/tasks', PekerjaTasksIndex::class)
            ->name('tasks.index');

        /*
        |--------------------------------------------------------------------------
        | Documentations
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/documentations',
            PekerjaDocumentationsIndex::class
        )
            ->name('documentations.index');

        Route::get(
            '/documentations/create',
            PekerjaDocumentationsCreate::class
        )
            ->name('documentations.create');

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', PekerjaReportsIndex::class)
            ->name('reports.index');

        Route::get('/reports/create', PekerjaReportsCreate::class)
            ->name('reports.create');

        Route::get('/reports/{report}', PekerjaReportsShow::class)
            ->whereNumber('report')
            ->name('reports.show');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', PekerjaProfileIndex::class)
            ->name('profile.index');
    });

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';