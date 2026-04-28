<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTrainRequest;
use App\Http\Requests\UpdateTrainRequest;
use Illuminate\Http\JsonResponse;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Train::query();

        // Filter by Name/Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by Class
        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        // Maintain sorting and paginate
        $trains = $query->orderBy('created_at', 'desc')->paginate(6);

        return response()->json($trains);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainRequest $request): JsonResponse
    {
        $train = Train::create($request->validated());

        return response()->json([
            'message' => 'Train created successfully',
            'data'    => $train
        ], 201); // 201 is the standard HTTP code for "Created"
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
