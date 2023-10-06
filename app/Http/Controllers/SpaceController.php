<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CentrePoint;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menampilkan data dari tabel space
        return view('space.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Memanggil model CentrePoint untuk mendapatkan data yang akan dikirimkan ke form create
        // space
        $centrepoint = CentrePoint::get()->first();
        return view('space.create', [
            'centrepoint' => $centrepoint,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'name' => 'required',
            'location' => 'required'
        ]);

        // melakukan pengecekan ketika ada file gambar yang akan di input
        $spaces = new Space();

        // Memasukkan nilai untuk masing-masing field pada tabel space berdasarkan inputan dari
        // form create 
        $spaces->name = $request->input('name');
        $spaces->location = $request->input('location');

        //return dd($spaces);

        // proses simpan data
        $spaces->save();

        // redirect ke halaman index space
        if ($spaces) {
            return redirect()->route('space.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('spaceI.index')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Space $space)
    {
        // mencari data space yang dipilih berdasarkan id
        // kemudian menampilkan data tersebut ke form edit space
        $space = Space::findOrFail($space->id);
        return view('space.edit', [
            'space' => $space
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Space $space)
    {
        // Menjalankan validasi
        $this->validate($request, [
            'name' => 'required',
            'location' => 'required'
        ]);

        // Jika data yang akan diganti ada pada tabel space
        $space = Space::findOrFail($space->id);

        // Lakukan Proses update data ke tabel space
        $space->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);
       
        // redirect ke halaman index space
        if ($space) {
            return redirect()->route('space.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('space.index')->with('error', 'Data gagal diupdate');
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
        // hapus keseluruhan data pada tabel space
        $space = Space::findOrFail($id);
        $space->delete();
        return redirect()->route('space.index');
    }
}
