<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Colors\Rgb\Channels\Red;

class GajiController extends Controller
{
    public function index(){
        $pegawai = pegawai::with('jabatan','bagian')->get();

        return view('admin.gaji.gaji', compact('pegawai'));
    }

    public function create(){
        $bagian = bagian::get();
        $jabatan = jabatan::get();
        $pegawai = pegawai::get();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $thisMonthLabel = $startOfMonth->format('F, Y');

        $months = [];
        while ($startOfLastYear->lte($startOfMonth)) {
            $months[] = [
                'label' => $startOfLastYear->format('F, Y'),
                'value' => $startOfLastYear->format('Y-m-01'),
                'has_events' => false, // Default tidak ada event
                'is_current' => $startOfLastYear->format('F, Y') === $thisMonthLabel
            ];
            $startOfLastYear->addMonth();
        }

        return view('admin.gaji.gajiDetail', compact('jabatan','bagian','pegawai','months'));
    }

    public function pegawaiGaji(Request $request){
        
    }
}
