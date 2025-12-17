<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index() {
        // Data untuk chart gender
        $genderData = Pegawai::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();
        
        $maleCount = $genderData->where('gender', 'male')->first()->total ?? 0;
        $femaleCount = $genderData->where('gender', 'female')->first()->total ?? 0;
        
        // Data untuk chart top 5 pekerjaan
        $topPekerjaan = Pekerjaan::withCount('pegawai')
            ->orderBy('pegawai_count', 'desc')
            ->limit(5)
            ->get();
        
        $pekerjaanLabels = $topPekerjaan->pluck('nama')->toArray();
        $pekerjaanData = $topPekerjaan->pluck('pegawai_count')->toArray();
        
        return view('index', compact('maleCount', 'femaleCount', 'pekerjaanLabels', 'pekerjaanData'));
    }
}