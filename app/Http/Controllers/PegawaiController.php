<?php

namespace App\Http\Controllers;

use App\pegawai as Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(){
        $pegawai = Pegawai::all();
        return view('pegawai', ['pegawai' => $pegawai]);
    }

    public function store(Request $req) {
        $req->validate([
            'nip'   => 'required',
            'nama'  => 'required',
            'alamat' => 'required'
        ]);

        $pegawai = Pegawai::updateOrCreate([
            'id' => $req->id],[
            'nip' => $req->nip,
            'nama' => $req->nama,
            'alamat' => $req->alamat]);

        return response()->json([
            'code' => 200,
            'message' => 'Created Successfully',
            'data' => $pegawai
        ], 200);
    }

    public function show($id){
        $pegawai = Pegawai::find($id);

        return response()->json($pegawai);
    }

    public function destroy($id){
        $pegawai = Pegawai::find($id)->delete();

        return response()->json([
            'success' => 'Successfully Deleted'
        ]);
    }

    public function print(){
        $pegawai = Pegawai::all();
        return view('print_pegawai', ['pegawai' => $pegawai]);
    }
}
