<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Mandor\Dashboard as MandorDashboard;
use App\Livewire\Worker\Dashboard as WorkerDashboard;

use App\Livewire\Owner\Clients\Index as ClientsIndex;
use App\Livewire\Owner\Clients\Show as ClientsShow;
use App\Livewire\Owner\Clients\Create as ClientsCreate;
use App\Livewire\Owner\Clients\Edit as ClientsEdit;
use App\Livewire\Owner\Clients\Delete as ClientsDelete;

use App\Livewire\Owner\Projects\Index as ProjectsIndex;
use App\Livewire\Owner\Projects\Show as ProjectsShow;
use App\Livewire\Owner\Projects\Create as ProjectCreate;
use App\Livewire\Owner\Projects\Delete as ProjectsDelete;
use App\Livewire\Owner\Projects\Edit as ProjectEdit;

use App\Livewire\Owner\Quotations\Create as QuotationsCreate;
use App\Livewire\Owner\Quotations\Show as QuotationsShow;
use App\Livewire\Owner\Quotations\Edit as QuotationsEdit;
use App\Livewire\Owner\Quotations\Delete as QuotationsDelete;
use App\Livewire\Owner\Quotations\Index as QuotationsIndex;

use App\Livewire\Owner\Monitoring\Index as MonitoringIndex;
use App\Livewire\Owner\Monitoring\Show as MonitoringShow;
use App\Livewire\Owner\Monitoring\Documentation as MonitoringDocumentation;

/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function(){
    return redirect()->route('login');
});

Route::middleware([
    'auth',
    'role:owner',
])->group(function () {

    Route::get('/dashboard',OwnerDashboard::class)->name('owner.dashboard');
    Route::get('/clients', ClientsIndex::class)->name('owner.clients.index');
    Route::get('/clients/create', ClientsCreate::class)->name('owner.clients.create');
    Route::get('/clients/{client}/edit', ClientsEdit::class)->name('owner.clients.edit');
    Route::get('/clients/{client}',ClientsShow::class)->name('owner.clients.show');
    Route::get('/clients/{client}/delete', ClientsDelete::class)->name('owner.clients.delete');

    Route::prefix('projects')->name('owner.projects.')->group(function(){
        Route::get('', ProjectsIndex::class)->name('index');
        Route::get('/create', ProjectCreate::class)->name('create');
        Route::get('/{project}', ProjectsShow::class)->name('show');
        Route::get('/{project}/edit', ProjectEdit::class)->name('edit');
        Route::get('/{project}/delete', ProjectsDelete::class)->name('delete');
    });

    Route::prefix('quotations')->name('owner.quotations.')->group(function(){
        Route::get('', QuotationsIndex::class)->name('index');
        Route::get('/create', QuotationsCreate::class)->name('create');
        Route::get('/{quotation}', QuotationsShow::class)->name('show');
        Route::get('/{quotation}/edit', QuotationsEdit::class)->name('edit');
        Route::get('/{quotation}/delete', QuotationsDelete::class)->name('delete');
    });
    
    Route::prefix('monitoring')->name('owner.monitoring.')->group(function(){
        Route::get('', MonitoringIndex::class)->name('index');
        Route::get('/monitoring/{project}', MonitoringShow::class)->name('show');
        Route::get('/{project}/documentation', MonitoringDocumentation::class)->name('documentation');
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