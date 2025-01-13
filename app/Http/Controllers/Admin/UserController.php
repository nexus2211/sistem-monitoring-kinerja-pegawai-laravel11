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
    public function index(){

        $dataUser = pegawai::with('User','jabatan','bagian')->get();
        $uniqueTypes = $dataUser->pluck('user.type')->unique();
        $jabatan = jabatan::get();
        $bagian = bagian::get();
        // dd($dataUser);
        return view('auth.manageAuth.user', compact('dataUser','jabatan','bagian','uniqueTypes'));
    }
}
