<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Mandor\Dashboard as MandorDashboard;
use App\Livewire\Worker\Dashboard as WorkerDashboard;

// Clients
use App\Livewire\Owner\Clients\Index as ClientsIndex;
use App\Livewire\Owner\Clients\Show as ClientsShow;
use App\Livewire\Owner\Clients\Create as ClientsCreate;
use App\Livewire\Owner\Clients\Edit as ClientsEdit;
use App\Livewire\Owner\Clients\Delete as ClientsDelete;

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

use App\Livewire\Owner\Profile as Profile;

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',OwnerDashboard::class)->name('owner.dashboard');

     Route::get('/profile',Profile::class)->name('owner.profile');

    Route::prefix('clients')->name('owner.clients.')->group(function () {
            Route::get('', ClientsIndex::class)->name('index');
            Route::get('/create', ClientsCreate::class)->name('create');
            Route::get('/{client}/edit', ClientsEdit::class)->name('edit');
            Route::get('/{client}', ClientsShow::class)->name('show');
            Route::get('/{client}/delete', ClientsDelete::class)->name('delete');
        });

    Route::prefix('projects')->name('owner.projects.')->group(function () {
            Route::get('', ProjectsIndex::class)->name('index');
            Route::get('/create', ProjectCreate::class)->name('create');
            Route::get('/{project}/edit', ProjectEdit::class)->name('edit');
            Route::get('/{project}', ProjectsShow::class)->name('show');
            Route::get('/{project}/delete', ProjectsDelete::class)->name('delete');
        });

    Route::prefix('quotations')->name('owner.quotations.')->group(function () {
            Route::get('', QuotationsIndex::class)->name('index');
            Route::get('/create', QuotationsCreate::class)->name('create');
            Route::get('/{quotation}/edit', QuotationsEdit::class)->name('edit');
            Route::get('/{quotation}', QuotationsShow::class)->name('show');
            Route::get('/{quotation}/delete', QuotationsDelete::class)->name('delete');
        });

    Route::prefix('invoices')->name('owner.invoices.')->group(function () {
            Route::get('', InvoicesIndex::class)->name('index');
            Route::get('/create', InvoicesCreate::class)->name('create');
            Route::get('/{invoice}/edit', InvoicesEdit::class)->name('edit');
            Route::get('/{invoice}', InvoicesShow::class)->name('show');
            Route::get('/{invoice}/delete', InvoicesDelete::class)->name('delete');
        });

    Route::prefix('monitoring')->name('owner.monitoring.')->group(function () {
            Route::get('', MonitoringIndex::class)->name('index');
            Route::get('/{project}', MonitoringShow::class)->name('show');
            Route::get('/{project}/documentation', MonitoringDocumentation::class)->name('documentation');
        });

    Route::prefix('users')->name('owner.users.')->group(function () {
            Route::get('', UsersIndex::class)->name('index');
            Route::get('/create', UsersCreate::class)->name('create');
            Route::get('/{user}/edit', UsersEdit::class)->name('edit');
            Route::get('/{user}', UsersShow::class)->name('show');
            Route::get('/{user}/delete', UsersDelete::class)->name('delete');
        });
});


/*
|--------------------------------------------------------------------------
| Mandor Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:mandor',
])->group(function () {

    Route::get(
        '/mandor/dashboard',
        MandorDashboard::class
    )->name('mandor.dashboard');
});


/*
|--------------------------------------------------------------------------
| Worker Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:pekerja',
])->group(function () {

    Route::get(
        '/worker/dashboard',
        WorkerDashboard::class
    )->name('worker.dashboard');
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