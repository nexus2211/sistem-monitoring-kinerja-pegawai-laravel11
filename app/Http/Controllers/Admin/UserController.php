<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){

        $search = $request->input('cari_pegawai');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');

        $dataUser = pegawai::with('user','jabatan','bagian')->paginate(10);
        $uniqueTypes = pegawai::with('user')->get()->pluck('user.type')->unique();
        // $uniqueTypes = $dataUser->pluck('user.type')->unique();
        $jabatan = jabatan::get();
        $bagian = bagian::get();



        
        return view('auth.manageAuth.user', compact('dataUser','jabatan','bagian','uniqueTypes'));
    }
}
