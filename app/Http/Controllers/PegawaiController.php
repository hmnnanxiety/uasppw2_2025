<?php


namespace App\Http\Controllers;


use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;


class PegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::with('pekerjaan')->paginate(10);
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.index', compact('data', 'pekerjaan'));
    }


    public function add()
    {
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.add', compact('pekerjaan'));
    }


    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'pekerjaan_id' => 'required'
        ]);


        Pegawai::create($request->all());


        return redirect()->route('pegawai.index')
        ->with('success', 'Pegawai berhasil ditambahkan');
    }


    public function edit($id)
    {
        $data = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all();


        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }


    public function update(Request $request, $id)
    {
        $data = Pegawai::findOrFail($id);
        $data->update($request->all());


        return redirect()->route('pegawai.index')
        ->with('success', 'Pegawai berhasil diupdate');
    }


    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();


        return redirect()->route('pegawai.index')
        ->with('success', 'Pegawai berhasil dihapus');
    }
}