<?php

namespace App\Http\Controllers;

use App\Models\CentrePoint;
use App\Models\Space;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        /**
         *  Pada method index kita mengambil single data dari tabel centrepoint
         *  Selanjutnya kita mengambil seluruh data dari tabel space untuk menampilkan marker yang akan
         *  kita gtampilkan pada view map.blade 
         */
        $centrePoint = CentrePoint::get()->first();
        $spaces = Space::get();
        return view('map',[
            'spaces' => $spaces,
            'centrePoint' => $centrePoint
        ]);
    }
}
