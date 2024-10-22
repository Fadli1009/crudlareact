<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = House::all();
        try {
            return response()->json(['status' => 'Sukses', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Gagal', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'descriptions' => ['required', 'string', 'max:255'], // typo fixed: descriptions -> description
            'price' => ['required', 'integer'],
            'location' => ['required', 'string'],
            'status' => ['required', 'integer'],
            'bedrooms' => ['required', 'integer'],
            'bathroom' => ['required', 'integer'],
            'area' => ['required', 'integer'],
            'image' => ['required', 'mimes:jpg,jpeg,jfif,png'], // typo fixed: mime -> mimes
        ]);

        try {
            $imagePath = $request->file('image')->store('houses', 'public');
            $id_user = Auth::user();
            $data['image'] = $imagePath;
            House::create($data);
            return response()->json(['status' => 'Sukses', 'data' => $data], 201);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Gagal', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        // dd($request->all()); 
        try {
            // Validasi data
            $data = $request->validate([
                'user_id' => ['nullable', 'integer'], // Nullable jika user_id tidak wajib diubah
                'title' => ['required', 'string', 'max:255'],
                'descriptions' => ['required', 'string', 'max:255'], // pastikan ini konsisten dengan nama field di DB
                'price' => ['required', 'integer'],
                'location' => ['required', 'string'],
                'status' => ['required', 'integer'],
                'bedrooms' => ['required', 'integer'],
                'bathroom' => ['required', 'integer'],
                'area' => ['required', 'integer'],
                'image' => ['nullable', 'mimes:jpg,jpeg,jfif,png'], // Nullable jika gambar tidak wajib diubah
            ]);

            // Jika ada file gambar yang diupload
            if ($request->hasFile('image')) {
                $imageName = $house->image;
                // Hapus gambar lama jika ada
                if (Storage::exists('public/houses/' . $imageName)) {
                    Storage::delete('public/houses/' . $imageName);
                }
                // Simpan gambar baru
                $imagePath = $request->file('image')->store('houses', 'public');
                $data['image'] = $imagePath;
            }

            // Update data rumah
            $house->update($data);

            // Return response sukses
            return response()->json([
                'status' => 'sukses',
                'message' => 'Data rumah berhasil diubah',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            // Menangani error
            Log::error($th->getMessage()); // Mencatat error ke dalam log
            return response()->json([
                'status' => 'Failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $house->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
