<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Menentukan nama tabel jika berbeda dari konvensi plural
    protected $table = 'products';

    // Menentukan kolom-kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'nama_produk',
        'harga',
        'gambar',
        'deskripsi',
        'kategori',
        'stok'
    ];

    // Kolom yang tidak dapat diisi melalui mass-assignment
    protected $guarded = [];

    // Mengatur tipe data untuk kategori sebagai enum jika diperlukan
    protected $casts = [
        'kategori' => 'string',
        'stok' => 'integer',
        'harga' => 'integer',
    ];
}
