<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Produk::orderBy('id', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataProduk = new Produk;

        $rules = [
            'judul' => 'required',
            'deskripsi' => 'required',
            'durasi' => 'required',
            'kategori' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        };

        $dataProduk->judul = $request->judul;
        $dataProduk->deskripsi = $request->deskripsi;
        $dataProduk->durasi = $request->durasi;
        $dataProduk->kategori = $request->kategori;

        $post = $dataProduk->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Produk::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataProduk = Produk::find($id);
        if (empty($dataProduk)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $rules = [
            'judul' => 'required',
            'deskripsi' => 'required',
            'durasi' => 'required',
            'kategori' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        };

        $dataProduk->judul = $request->judul;
        $dataProduk->deskripsi = $request->deskripsi;
        $dataProduk->durasi = $request->durasi;
        $dataProduk->kategori = $request->kategori;

        $post = $dataProduk->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memperbarui data'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataProduk = Produk::find($id);
        if (empty($dataProduk)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $post = $dataProduk->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses menghapus data'
        ]);
    }
}
