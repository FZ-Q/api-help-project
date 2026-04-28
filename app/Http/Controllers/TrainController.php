<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Http\Requests\StoreTrainRequest;
use App\Http\Requests\UpdateTrainRequest;
use Illuminate\Http\JsonResponse;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Train::with('routes')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainRequest $request): JsonResponse
    {
        Train::create($request->validated());

        return response()->json(['message' => 'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Train $train): JsonResponse
    {
        return response()->json($train->load('routes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainRequest $request, Train $train): JsonResponse
    {
        $train->update($request->validated());

        return response()->json([
            'message' => 'Train updated successfully',
            'data' => $train
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Train $train): JsonResponse
    {
        $train->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
