<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\ReportExport;
use App\Exports\ReportsExport;


class ReportController extends Controller
{

    public function exportPDF()
    {
         // ambil data yg akan ditampilkan pada pdf, bisa juga dengan where atau eloquent lainnya dan jangan gunakan pagination
         // Konvert data menggunakan array dengan toArray()
         $data = Report::all()->toArray(); 
         // kirim data yg diambil kepada view yg akan ditampilkan, kirim dengan inisial 
         view()->share('reports',$data); 
         // panggil view blade yg akan dicetak pdf serta data yg akan digunakan
         $pdf = PDF::loadView('print', $data); 
         // download PDF file dengan nama tertentu
         return $pdf->download('data_pengaduan_keseluruhan.pdf'); 
    }

    public function printPDF($id)
    {
        $data = Report::where('id', '=', $id)->get()->toArray(); 
         // kirim data yg diambil kepada view yg akan ditampilkan, kirim dengan inisial 
         view()->share('reports',$data); 
         // panggil view blade yg akan dicetak pdf serta data yg akan digunakan
         $pdf = PDF::loadView('print', $data); 
         // download PDF file dengan nama tertentu
         return $pdf->download('data_pengaduan.pdf');    
    }

    public function exportExcel()
    {
        // Nama file yang akan didownload
        $file_name = 'data_keseluruhan_Pengaduan.xlsx';
        // Memanggil file ReportExport dan mendownload dengan nama seperti $file_name
        return Excel::download(new ReportsExport, $file_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ASC : Ascending -> Terkecil-Terbesar (1-100) / (A-Z)
       // DESC :  Descending -> Terbesar-Terkecil (100-1) / (Z-A)  
        $reports = Report::orderBy('created_at', 'DESC')->simplePaginate(2);
        return view('index', compact('reports'));
    }

    public function data(Request $request)
    {
        // Ambil data yang akan diinput ke input yang name nya $search
        $search = $request->search;
        // Data yang akan diambil merupakan
        // Where akan mencari data berdasarkan column nama
        // Data dicari ke db yang column nya berisis 'fem' nya
        $reports = Report::where ('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('data', compact('reports'));
    }

    public function dataPetugas(Request $request)
    {
        $search = $request->search;
        $reports = Report::with('response')->where('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('data_petugas', compact('reports'));
    }

    public function Auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        // Ambil datan dan simpan di Variable
        $user = $request->only('email', 'password');
        // Simpe data ke auth dengan Auth::Attempt. Cek proses penyimpanan ke auth berhasil atai tidak lewat if else
        if (Auth::attempt($user)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('data');
            }elseif(Auth::user()->role == 'petugas') {
                return redirect()->route('data.petugas');
            }
        } else {
            return redirect()->back()->with('gagal', 'Gagal login, coba lagi!');
        }
    }

    public function logout() 
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required',    
            'nama' => 'required',
            'no_telp' => 'required',
            'pengaduan' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        $path = public_path('assets/image/');
        $image = $request->file('foto');
        $imgName = rand() . '.' . $image->extension();
        $image->move($path, $imgName);

        Report::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'pengaduan' => $request->pengaduan,
            'foto' => $imgName
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan pengaduan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report, $id)
    {
        $data = Report::where('id', $id)->firstOrFail();
        // $data isinya -> nik sampe foto dari pengaduan
        // Hapus data foto dari pengaduan
        // Nama fotonya diambil dari $data yang diatas lali ambil dari column 'foto'
        $image = public_path('assets/image/'.$data['foto']);
        // Untuk mencari posisi fotonya hanya perlu menghapus fotonya menggunakan 'unlink'
        unlink('assets/image/' . $data['foto']);
        // Hapus dari database
        $data->delete();
        // Setelahnya dikembalikan lagi ke halaman awal
        return redirect()->back();
    }
}
