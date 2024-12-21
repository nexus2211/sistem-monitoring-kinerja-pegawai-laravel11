<?php

namespace App\Http\Controllers;

use App\Models\bagian;
use App\Models\pegawai;
use App\Models\jabatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{

    //INDEX

    public function PegawaiIndex(){

        $max_data = 5;

        $pegawai = Pegawai::with(['jabatan','bagian'])->latest()->get();
       // dd($pegawai);

        return view('pegawai.pegawai', compact('pegawai'));
    }

    public function PegawaitampilTambah(){
        $jabatan = Jabatan::all();
        $bagian = Bagian::all();

        return view('pegawai.tambah', compact('jabatan','bagian'));
    }

    public function JabatanIndex(){

        $max_data = 5;

        $jabatan = Jabatan::get();
       //dd($jabatan);

        return view('pegawai.jabatan.jabatan', compact('jabatan'));
    }

    public function BagianIndex(){

        $max_data = 5;

        $bagian = Bagian::get();
       //dd($jabatan);

        return view('pegawai.bagian.bagian', compact('bagian'));
    }

    // INSERT DATA

    public function PegawaiStore(Request $request){

        $request->validate([
            'nip'  => 'required|min:3|max:20',
            'nama_pegawai' => 'required|min:3|max:20',
            'foto' => 'image|mimes:jpg,jpeg,png'
            
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        // Tanggal Lahir
        $inputTgl = $request->input('tgl_lahir');
        // $tglFormat = Carbon::createFromFormat('m/d/Y', $inputTgl)->format('Y-m-d');
        $tglFormat =  Carbon::parse($request->tgl_lahir)->format('Y-m-d');

        // Image
        if ($request->hasFile('foto')){
            $image = $request->file('foto');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_NAME_LOCATION'));
            $image->move($destination_path, $image_name);
        }


        $data = [
            'nip' => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'tgl_lahir' => $tglFormat,
            'jabatan_id' => $request->jabatan,
            'bagian_id' => $request->bagian,
            'foto' => isset($image_name)?$image_name:null,
            // 'foto' => $request->foto,
        ];

        // dd($data);

        pegawai::create($data);

        return redirect()->route('pegawai');
    }

    public function JabatanStore(Request $request)
    {
        $request->validate([
            'jabatan'  => 'required|min:3|max:20',
            'deskripsi' => 'required|min:3|max:20',
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        $data = [
            'jabatan' => $request->input('jabatan'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Jabatan::create($data);

        return redirect()->route('jabatan');
    }

    public function BagianStore(Request $request)
    {
        $request->validate([
            'bagian'  => 'required|min:3|max:20',
            'deskripsi' => 'required|min:3|max:20',
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        $data = [
            'bagian' => $request->input('bagian'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Bagian::create($data);

        return redirect()->route('bagian');
    }

    // EDIT DATA

    public function PegawaiEdit($id) {
        $pegawai = Pegawai::find($id);

        $jabatan = Jabatan::all();
        $bagian = Bagian::all();

        return view('pegawai.edit', compact('pegawai','jabatan','bagian'));
    }

    public function PegawaiUpdate(Request $request, string $id){
        $pegawai = Pegawai::find($id);

        $request->validate([
            'nip'  => 'required|min:3|max:20',
            'nama_pegawai' => 'required|min:3|max:40',
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        $inputTgl = $request->input('tgl_lahir');
        $tglFormat =  Carbon::parse($request->tgl_lahir)->format('Y-m-d');

        // Image
        if ($request->hasFile('foto')){

            if (isset($pegawai->foto) && file_exists(public_path(getenv('CUSTOM_NAME_LOCATION'))."/".$pegawai->foto)) {
                unlink(public_path(getenv('CUSTOM_NAME_LOCATION'))."/".$pegawai->foto);
            }

            $image = $request->file('foto');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_NAME_LOCATION'));
            $image->move($destination_path, $image_name);
        }

        $data = [
            'nip' => $request->input('nip'),
            'nama_pegawai' => $request->input('nama_pegawai'),
            'alamat' => $request->input('alamat'),
            'gender' => $request->input('gender'),
            'tgl_lahir' => $tglFormat,
            'jabatan_id' => $request->input('jabatan'),
            'bagian_id' => $request->input('bagian'),
            'foto' => isset($image_name)?$image_name:$pegawai->foto,
        ];

       // dd($data);

        pegawai::where('id', $id)->update($data);
        return redirect()->route('pegawai');
    }

    public function JabatanEdit($id) {
        $jabatan = Jabatan::find($id);
       
        return view('pegawai.jabatan.edit', compact('jabatan'));
    }

    public function JabatanUpdate(Request $request, string $id){
        $jabatan = Jabatan::find($id);
        $request->validate([
            'jabatan'  => 'required|min:3|max:20',
            'deskripsi' => 'required|min:3|max:20',
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        $data = [
            'jabatan' => $request->input('jabatan'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Jabatan::where('id', $id)->update($data);
       
        return redirect()->route('jabatan');
    }

    public function BagianEdit($id) {
        $bagian = Bagian::find($id);
       
        return view('pegawai.bagian.edit', compact('bagian'));
    }

    public function BagianUpdate(Request $request, string $id){
        $bagian = Bagian::find($id);
        $request->validate([
            'bagian'  => 'required|min:3|max:20',
            'deskripsi' => 'required|min:3|max:20',
        ],[
            'task.required'=>'Task wajib diisi',
            'task.min'=>'Input minimal memiliki 3 karakter',
            'task.max'=>'Input maximal memiliki 25 karakter',
        ]);

        $data = [
            'bagian' => $request->input('bagian'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Bagian::where('id', $id)->update($data);
       
        return redirect()->route('bagian');
    }

    //DELETE DATA

    public function PegawaiDelete (Request $request, string $id){
        $pegawai = Pegawai::find($id);
        pegawai::where('id', $id)->delete();
        return redirect()->route('pegawai');
    }

    public function JabatanDelete (Request $request, string $id){
        $jabatan = Jabatan::find($id);
        Jabatan::where('id', $id)->delete();
        return redirect()->route('jabatan');
    }

    public function BagianDelete (Request $request, string $id){
        $bagian = Bagian::find($id);
        Bagian::where('id', $id)->delete();
        return redirect()->route('bagian');
    }
}
