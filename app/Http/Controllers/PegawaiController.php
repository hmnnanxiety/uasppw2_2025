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
        return view('pegawai.index', compact('data'));
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
            'email' => 'required|email',
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'is_active' => 'required|boolean'
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
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'is_active' => 'required|boolean'
        ]);

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

    // Soft Delete Methods
    public function trash()
    {
        $data = Pegawai::onlyTrashed()->with('pekerjaan')->paginate(10);
        return view('pegawai.trash', compact('data'));
    }

    public function restore($id)
    {
        Pegawai::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('pegawai.trash')
            ->with('success', 'Pegawai berhasil dipulihkan');
    }

    public function forceDelete($id)
    {
        Pegawai::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('pegawai.trash')
            ->with('success', 'Pegawai berhasil dihapus permanen');
    }
}