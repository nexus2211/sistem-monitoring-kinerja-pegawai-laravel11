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

    public function create(Request $request){
        $bagian = bagian::get();
        $jabatan = jabatan::get();

        $jabatanFilter = $request->jabatanInput;
        $bagianFilter = $request->bagianInput;
        $bulan = $request->bulanInput;


        $pegawai = pegawai::with('jabatan','bagian')
        ->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); 
        })
        ->get();

        // Mendapatkan bulan untuk select
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

        return view('admin.gaji.gajiDetail', compact('jabatan','bagian','pegawai','months','bulan'));
    }

    public function pegawaiGaji(Request $request){
        
    }

    public function getGajiPokok($id){
        $pegawai = Pegawai::find($id);
        return response()->json([
            // 'gaji_pokok' => $pegawai ? $pegawai->gaji_pokok : 0
            'gaji_pokok' => $pegawai->gaji_pokok ?? 0
        ]);
    }
}
