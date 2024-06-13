<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class ViewProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/produk";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }

        return view('produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'durasi' => 'required|int|max:11',
            'kategori' => 'required|string|max:255'
        ]);

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/produk";
        $response = $client->request('POST', $url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($validatedData)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('produk')->withErrors($error)->withInput();
        } else {
            return redirect()->to('produk')->with('success', 'Berhasil memasukkan data');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/produk/$id";
        try {
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            if ($contentArray['status'] != true) {
                $error = $contentArray['message']; // Check for correct key in the API response
                return redirect()->to('produk')->withErrors($error);
            } else {
                $data = $contentArray['data'];
                return view('produk.edit', compact('data')); // Return edit view with data
            }
        } catch (\Exception $e) {
            return redirect()->to('produk')->withErrors('An unexpected error occurred');
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
        $judul = $request->judul;
        $deskripsi = $request->deskripsi;
        $durasi = $request->durasi;
        $kategori = $request->kategori;

        // Handle image upload if a new image is provided


        $parameter = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'durasi' => $durasi,
            'kategori' => $kategori
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/produk/$id";
        try {
            $response = $client->request('PUT', $url, [
                'headers' => ['content-type' => 'application/json'],
                'body' => json_encode($parameter)
            ]);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            if ($contentArray['status'] != true) {
                $error = $contentArray['data'];
                return redirect()->to('produk')->withErrors($error)->withInput();
            } else {
                return redirect()->to('produk')->with('success', 'Berhasil memperbarui data');
            }
        } catch (\Exception $e) {
            return redirect()->to('produk')->withErrors('An unexpected error occurred: ' . $e->getMessage())->withInput();
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/produk/$id";
        try {
            $response = $client->request('DELETE', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            if ($contentArray['status'] != true) {
                $error = $contentArray['message']; // Fix typo from 'message' to 'message' if API provides 'message'
                return redirect()->to('produk')->withErrors($error)->withInput();
            } else {
                return redirect()->to('produk')->with('success', 'Berhasil menghapus data');
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $contentArray = json_decode($responseBodyAsString, true);
            $error = isset($contentArray['message']) ? $contentArray['message'] : 'Unknown error'; // Fix typo from 'message' to 'message' if API provides 'message'
            return redirect()->to('produk')->withErrors($error);
        } catch (\Exception $e) {
            return redirect()->to('produk')->withErrors('An unexpected error occurred');
        }
    }
}
