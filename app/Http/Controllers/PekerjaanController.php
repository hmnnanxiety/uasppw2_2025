<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    public function index(Request $request) 
    {
        $keyword = $request->get('keyword');
        $data = Pekerjaan::withCount('pegawai')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->paginate(10);
        
        return view('pekerjaan.index', compact('data'));
    }

    public function add() 
    {
        return view('pekerjaan.add');
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Pekerjaan();
        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            return redirect()->route('pekerjaan.index')
                ->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('pekerjaan.index')
                ->with('error', 'Data tidak tersimpan');
        }
    }

    public function edit(Request $request) 
    {
        $data = Pekerjaan::findOrFail($request->id);
        return view('pekerjaan.edit', compact('data'));
    }

    public function update(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Pekerjaan::findOrFail($request->id);
        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            return redirect()->route('pekerjaan.index')
                ->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('pekerjaan.index')
                ->with('error', 'Data tidak tersimpan');
        }
    }

    public function destroy(Request $request) 
    {
        $data = Pekerjaan::findOrFail($request->id);
        
        if ($data->delete()) {
            return redirect()->route('pekerjaan.index')
                ->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('pekerjaan.index')
                ->with('error', 'Data gagal dihapus');
        }
    }
}