<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\BusinessArea;
use App\Models\District;
use App\Models\Block;
use App\Models\GramPanchayat;
use App\Models\Machine;

class MasterDataController extends Controller
{
    protected $map = [
        'business-areas' => BusinessArea::class,
        'business_areas' => BusinessArea::class,
        'businessarea' => BusinessArea::class,
        'districts' => District::class,
        'blocks' => Block::class,
        'gram-panchayats' => GramPanchayat::class,
        'gram_panchayats' => GramPanchayat::class,
        'machines' => Machine::class,
    ];

    public function store(Request $request, $module): JsonResponse
    {
        $key = strtolower($module);
        if (!isset($this->map[$key])) {
            return response()->json(['error' => 'Invalid module'], 422);
        }

        $modelClass = $this->map[$key];
        $data = $request->all();

        // Normalize common fields to satisfy DB constraints (e.g. enum values)
        if (isset($data['status']) && is_string($data['status'])) {
            $data['status'] = strtoupper($data['status']);
        }

        try {
            $record = $modelClass::create($data);
            return response()->json($record, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Insert failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getBusinessAreas(): JsonResponse
    {
        try {
            $all = BusinessArea::all();
            return response()->json($all, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getBlocks(): JsonResponse
    {
        try {
            $all = Block::all();
            return response()->json($all, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getDistricts(): JsonResponse
    {
        try {
            $all = District::all();
            return response()->json($all, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getGramPanchayats(): JsonResponse
    {
        try {
            $all = GramPanchayat::all();
            return response()->json($all, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getMachines(): JsonResponse
    {
        try {
            $all = Machine::all();
            return response()->json($all, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed', 'message' => $e->getMessage()], 500);
        }
    }
}
