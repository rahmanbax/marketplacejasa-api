<?php

use App\Http\Controllers\ViewProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('produk/create', function() {
    return view('produk.create');
});

Route::get('produk', function() {
    return view('produk.index');
});

Route::get('produk/{id}/edit', function($id) {
    return view('produk.edit', ['id' => $id]);
});