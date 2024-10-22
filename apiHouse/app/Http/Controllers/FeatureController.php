<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Feature::orderBy('id', 'DESC')->with('house')->get();
        try {
            return response()->json([
                'status' => 'success',
                'meesage' => 'berhasil menampilkan data',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'feature_name' => ['required', 'string'],
            'id_house' => ['required', 'integer']
        ]);
        DB::beginTransaction();
        try {
            $feature = Feature::create($data);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'berhasil menambahkan data',
                'data' => $feature
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $feature = Feature::findorFail($id)->with('house')->get();
        $data = $request->validate([
            'feature_name' => ['required', 'string'],
            'id_house' => ['required', 'integer']
        ]);
        DB::beginTransaction();
        try {
            DB::commit();
            $feature->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'berhasil mengubah data',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feature = Feature::findorFail($id);
        DB::beginTransaction();
        try {
            DB::commit();
            $feature->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'berhasil menghapus data',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
