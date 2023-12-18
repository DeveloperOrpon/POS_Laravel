<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = config('paginate.default');
        $page = request()->input('page', 1);
        if (request()->has('per_page') && (int) request()->per_page > 0) {
            $perPage = (int) request()->per_page;
        }
        $units = Unit::all();
        $units = $units->forPage($page, $perPage);

        return UnitResource::collection($units);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        try {
            $term = Unit::create($request->all());
            return new UnitResource($term);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {

                return response()->json([
                    'error' => "Unit is Already Exists",
                    'time' => date('Y-m-d H:i:s')
                ], 500);
            } else {

                return response()->json([
                    'error' => $e->getMessage(),
                    'time' => date('Y-m-d H:i:s')
                ], 500);
            }
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $unit = Unit::find($id);
            if ($unit) {
                return new UnitResource($unit);
            } else {

                return response()->json([
                    'error' => "Unit not found",
                    'time' => date('Y-m-d H:i:s')
                ], 404);
            }
        } catch (QueryException $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'time' => date('Y-m-d H:i:s')
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, string $id)
    {
        try {
            $unit = Unit::find($id);
            if ($unit) {
                $unit->update($request->all());

                return new UnitResource($unit);
            } else {

                return response()->json([
                    'error' => "Unit not found",
                    'time' => date('Y-m-d H:i:s')
                ], 404);
            }
        } catch (QueryException $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'time' => date('Y-m-d H:i:s')
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $unit = Unit::find($id);
            if ($unit) {
                $unit->delete();

                return response()->json([
                    'message' => "Unit deleted successfully",
                    'time' => date('Y-m-d H:i:s')
                ], 200);
            } else {

                return response()->json([
                    'error' => "Unit not found",
                    'time' => date('Y-m-d H:i:s')
                ], 404);
            }
        } catch (QueryException $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'time' => date('Y-m-d H:i:s')
            ], 500);
        }
    }
}
