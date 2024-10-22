<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $data = Favorite::with('user', 'house')->orderBy('id', 'desc')->get();
            DB::commit();
            return response()->json(['data' => $data], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while retrieving data.', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'house_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        try {
            DB::beginTransaction();
            $favorite = Favorite::create(attributes: $data);
            DB::commit();
            return response()->json($favorite, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating a new favorite.', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        $data = $request->validate([
            'property_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        try {
            DB::beginTransaction();
            $favorite->update($data);
            DB::commit();
            return response()->json($favorite, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the favorite.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        try {
            DB::beginTransaction();
            $favorite->delete();
            DB::commit();
            return response()->json(['message' => 'Favorite deleted successfully.'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while deleting the favorite.'], 500);
        }
    }
}
