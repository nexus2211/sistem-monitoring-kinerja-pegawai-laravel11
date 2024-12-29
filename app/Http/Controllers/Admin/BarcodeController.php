<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pegawai;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('cari_pegawai');
        // $pegawai = pegawai::paginate(4);

        $pegawai = pegawai::when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")->orWhere('nip','like',"%{$search}%");
        })->paginate(4);

        // dd($nip);

        $qr_code = [];
        // foreach($nipArray as $nip){
        //    $qr_code[] =  QrCode::size(200)->generate($nip);
        // }



        return view('barcode.barcode', compact('qr_code','pegawai'));
    }
}
