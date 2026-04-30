<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasterDataController;

Route::get('/master-data/business-areas', [MasterDataController::class, 'getBusinessAreas']);
Route::get('/master-data/blocks', [MasterDataController::class, 'getBlocks']);
Route::get('/master-data/districts', [MasterDataController::class, 'getDistricts']);
Route::get('/master-data/gram-panchayats', [MasterDataController::class, 'getGramPanchayats']);
Route::get('/master-data/machines', [MasterDataController::class, 'getMachines']);
Route::post('/master-data/{module}', [MasterDataController::class, 'store']);

