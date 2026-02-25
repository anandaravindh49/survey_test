<?php

use App\Livewire\Users\Main as UsersMain;
use App\Livewire\Users\Show as UsersShow;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\BusinessAreas\Main as BusinessAreasMain;
use App\Livewire\BusinessAreas\Show as BusinessAreasShow;
use App\Livewire\BusinessAreas\Create as BusinessAreasCreate;
use App\Livewire\BusinessAreas\Edit as BusinessAreasEdit;
use App\Livewire\Districts\Main as DistrictsMain;
use App\Livewire\Districts\Show as DistrictsShow;
use App\Livewire\Districts\Create as DistrictsCreate;
use App\Livewire\Districts\Edit as DistrictsEdit;
use App\Livewire\Blocks\Main as BlocksMain;
use App\Livewire\Blocks\Show as BlocksShow;
use App\Livewire\Blocks\Create as BlocksCreate;
use App\Livewire\Blocks\Edit as BlocksEdit;
use App\Livewire\Machines\Main as MachinesMain;
use App\Livewire\Machines\Show as MachinesShow;
use App\Livewire\Machines\Create as MachinesCreate;
use App\Livewire\Machines\Edit as MachinesEdit;
use App\Livewire\GramPanchayats\Main as GramPanchayatsMain;
use App\Livewire\GramPanchayats\Show as GramPanchayatsShow;
use App\Livewire\GramPanchayats\Create as GramPanchayatsCreate;
use App\Livewire\GramPanchayats\Edit as GramPanchayatsEdit;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Users Routes
    Route::get('users', UsersMain::class)->name('users.index');
    Route::get('users/create', UsersCreate::class)->name('users.create');
    Route::get('users/{user}', UsersShow::class)->name('users.show');
    Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit');

    // Business Areas Routes
    Route::get('business-areas', BusinessAreasMain::class)->name('business-areas.index');
    Route::get('business-areas/create', BusinessAreasCreate::class)->name('business-areas.create');
    Route::get('business-areas/{businessArea}', BusinessAreasShow::class)->name('business-areas.show');
    Route::get('business-areas/{businessArea}/edit', BusinessAreasEdit::class)->name('business-areas.edit');

    // Districts Routes
    Route::get('districts', DistrictsMain::class)->name('districts.index');
    Route::get('districts/create', DistrictsCreate::class)->name('districts.create');
    Route::get('districts/{district}', DistrictsShow::class)->name('districts.show');
    Route::get('districts/{district}/edit', DistrictsEdit::class)->name('districts.edit');

    // Blocks Routes
    Route::get('blocks', BlocksMain::class)->name('blocks.index');
    Route::get('blocks/create', BlocksCreate::class)->name('blocks.create');
    Route::get('blocks/{block}', BlocksShow::class)->name('blocks.show');
    Route::get('blocks/{block}/edit', BlocksEdit::class)->name('blocks.edit');

    // Machines Routes
    Route::get('machines', MachinesMain::class)->name('machines.index');
    Route::get('machines/create', MachinesCreate::class)->name('machines.create');
    Route::get('machines/{machine}', MachinesShow::class)->name('machines.show');
    Route::get('machines/{machine}/edit', MachinesEdit::class)->name('machines.edit');

    // Gram Panchayats Routes
    Route::get('gram-panchayats', GramPanchayatsMain::class)->name('gram-panchayats.index');
    Route::get('gram-panchayats/create', GramPanchayatsCreate::class)->name('gram-panchayats.create');
    Route::get('gram-panchayats/{gramPanchayat}', GramPanchayatsShow::class)->name('gram-panchayats.show');
    Route::get('gram-panchayats/{gramPanchayat}/edit', GramPanchayatsEdit::class)->name('gram-panchayats.edit');
});

require __DIR__.'/settings.php';
