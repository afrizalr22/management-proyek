<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Mandor\Dashboard as MandorDashboard;
use App\Livewire\Worker\Dashboard as WorkerDashboard;
use App\Livewire\Owner\Clients\Index as ClientsIndex;
use App\Livewire\Owner\Clients\Show as ClientsShow;
use App\Livewire\Owner\Clients\Form as Form;
use App\Livewire\Owner\Clients\Delete;


/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner',
])->group(function () {

    Route::get('/owner/dashboard',OwnerDashboard::class)->name('owner.dashboard');
    Route::get('/owner/clients', ClientsIndex::class)->name('owner.clients.index');
    Route::get('/owner/clients/create', Form::class)->name('owner.clients.create');
    Route::get('/owner/clients/{client}/edit', Form::class)->name('owner.clients.edit');
    Route::get('/owner/clients/{client}',ClientsShow::class)->name('owner.clients.show');
    Route::get('/clients/{client}/delete', Delete::class)->name('owner.clients.delete');

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