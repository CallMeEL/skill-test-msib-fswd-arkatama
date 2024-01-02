<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Memisahkan data berdasarkan spasi
        $data = explode(' ', strtoupper($request->input('data')));

        // Inisialisasi variabel
        $name = '';
        $age = 0;
        $city = '';

        foreach ($data as $item) {
            // Memisahkan data usia dari format TAHUN, THN, atau TH
            if (is_numeric($item)) {
                $age = (int)$item;
            } elseif (strpos($item, 'TAH') !== false || strpos($item, 'THN') !== false || strpos($item, 'TH') !== false) {
                $age = (int)$item;
            }  else {
                // Mengonversi Nama dan Kota ke UPPERCASE
                if ($name === '') {
                    $name = $item;
                } else {
                    $city .= $item . ' ';
                }
            }
        }

        // Menghapus spasi di awal dan akhir string
        $city = trim($city);

        // Menyimpan data ke database
        $user = new User;
        $user->name = $name;
        $user->age = $age;
        $user->city = $city;
        $user->save();

        return response()->json(['message' => 'Data saved successfully']);
    }
}
