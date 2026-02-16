<?php

use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Users\Show as UsersShow;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\BusinessAreas\Index as BusinessAreasIndex;
use App\Livewire\BusinessAreas\Show as BusinessAreasShow;
use App\Livewire\BusinessAreas\Create as BusinessAreasCreate;
use App\Livewire\BusinessAreas\Edit as BusinessAreasEdit;
use App\Livewire\Districts\Index as DistrictsIndex;
use App\Livewire\Districts\Show as DistrictsShow;
use App\Livewire\Districts\Create as DistrictsCreate;
use App\Livewire\Districts\Edit as DistrictsEdit;
use App\Livewire\Blocks\Index as BlocksIndex;
use App\Livewire\Blocks\Show as BlocksShow;
use App\Livewire\Blocks\Create as BlocksCreate;
use App\Livewire\Blocks\Edit as BlocksEdit;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Users Routes
    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('users/create', UsersCreate::class)->name('users.create');
    Route::get('users/{user}', UsersShow::class)->name('users.show');
    Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit');

    // Business Areas Routes
    Route::get('business-areas', BusinessAreasIndex::class)->name('business-areas.index');
    Route::get('business-areas/create', BusinessAreasCreate::class)->name('business-areas.create');
    Route::get('business-areas/{businessArea}', BusinessAreasShow::class)->name('business-areas.show');
    Route::get('business-areas/{businessArea}/edit', BusinessAreasEdit::class)->name('business-areas.edit');

    // Districts Routes
    Route::get('districts', DistrictsIndex::class)->name('districts.index');
    Route::get('districts/create', DistrictsCreate::class)->name('districts.create');
    Route::get('districts/{district}', DistrictsShow::class)->name('districts.show');
    Route::get('districts/{district}/edit', DistrictsEdit::class)->name('districts.edit');

    // Blocks Routes
    Route::get('blocks', BlocksIndex::class)->name('blocks.index');
    Route::get('blocks/create', BlocksCreate::class)->name('blocks.create');
    Route::get('blocks/{block}', BlocksShow::class)->name('blocks.show');
    Route::get('blocks/{block}/edit', BlocksEdit::class)->name('blocks.edit');
});

require __DIR__.'/settings.php';
