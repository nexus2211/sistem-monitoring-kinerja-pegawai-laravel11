<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\gaji;
use Intervention\Image\Colors\Rgb\Channels\Red;

class GajiController extends Controller
{
    public function index(){
        $pegawai = pegawai::with('jabatan','bagian','gaji')->get();

        return view('admin.gaji.gaji', compact('pegawai'));
    }

    public function create(Request $request){
        $bagian = bagian::get();
        $jabatan = jabatan::get();

        $jabatanFilter = $request->jabatanInput;
        $bagianFilter = $request->bagianInput;
        $bulan = $request->bulanInput;

        $pegawai = collect();
        if ($jabatanFilter || $bagianFilter) { 
            $pegawai = Pegawai::with('jabatan', 'bagian')
                ->when($jabatanFilter, function ($query) use ($jabatanFilter) {
                    return $query->where('jabatan_id', $jabatanFilter);
                })
                ->when($bagianFilter, function ($query) use ($bagianFilter) {
                    return $query->where('bagian_id', $bagianFilter);
                })
                ->get();
        }

        

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


    public function getGajiPokok($id){
        $pegawai = Pegawai::find($id);
        return response()->json([
            // 'gaji_pokok' => $pegawai ? $pegawai->gaji_pokok : 0
            'gaji_pokok' => $pegawai->gaji_pokok ?? 0
        ]);
    }

    public function store(Request $request){

        // dd($request->all());
        $bulanInput = $request->bulanValue;
        $pegawaiInput = $request->namaInput;
        $gajiPokokInput = $request->gajiPokokInput;
        $pphInput = $request->pphInput;
        $kehadiranInput = $request->kehadiranInput;
        $makanInput = $request->makanInput;
        $transportInput = $request->transportInput;
        $lemburInput = $request->lemburInput;
        $tunlainInput = $request->tunlainInput;
        $asuransiInput = $request->asuransiInput;
        $bpjsInput = $request->bpjsInput;
        $absenInput = $request->absenInput;
        $potlainInput = $request->potlainInput;

        $pegawai = Pegawai::with('gaji','tunjangan','potongan')->find($pegawaiInput);

        $request->validate([
            'namaInput'  => 'required',
            'bulanValue' => 'required',
            
        ],[
            'namaInput.required'=>'Pilih Pegawai Terlebih Dahulu',
            'bulanValue.required'=>'Pilih Bulan Terlebih Dahulu',

        ]);

        // Ambil data gaji pokok, tunjangan, dan potongan
        $totalTunjangan = $kehadiranInput + $makanInput + $transportInput + $lemburInput + $tunlainInput;
        $totalPotongan = $asuransiInput + $bpjsInput + $absenInput + $potlainInput;

        // Hitung total gaji
        $totalGaji = $gajiPokokInput - $pphInput  + $totalTunjangan - $totalPotongan;

        //tambah data gaji
        $gaji = [
            'pegawai_id' => $pegawaiInput,
            'periode' => $bulanInput,
            'pph' => $pphInput,
            'total_gaji' => $totalGaji,
        ];

        $gajiStore = gaji::create($gaji);

        // Tambah tunjangan baru ke pegawai
        $pegawai->tunjangan()->create([
            'kehadiran' => $kehadiranInput,
            'makan' => $makanInput,
            'transportasi' => $transportInput,
            'lembur' => $lemburInput,
            'lainnya' => $tunlainInput,
            'total_tunjangan' => $totalTunjangan,
            
        ]);

        // Tambah potongan baru ke pegawai
        $pegawai->potongan()->create([
            'asuransi' => $asuransiInput,
            'bpjs' => $bpjsInput,
            'absen' => $absenInput,
            'lainnya' => $potlainInput,
            'total_potongan' => $totalPotongan,
            
        ]);
        
        return redirect()->route('gaji.index');
        
    }
}
