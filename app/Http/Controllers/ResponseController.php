<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($report_id)
    {
        // Ambil data response yang akan dimunculkan, data yang diambil data response yang report_id nya sama seperti $report_id dari path
        // dinamis {report_id}
        $report = Response::where('report_id', $report_id)->first();
        $reportId = $report_id;
        return view('response', compact('report', 'reportId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  \App\Models\Response $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $report_id)
    {
        $request->validate([
            'status' => 'required',
            'pesan' => 'required',
        ]);

        // updateOrCreate() fungsinya untuk melakukan update data kalau memang di db responsenya sudah ada data yang punye report_id
        // sama dengan $report_id dari path dinamis, kalau tidak ada data itu maka di create.
        // Array pertama, acuan dari katanya
        // Array kedua, data yang dikirim
        // kenapa pakai updateOrCreate? karena respinse ini kan kalo tdnya tidak ada mau ditambahin tapi kalau ada mau tinggal di update saja
        Response::updateOrCreate(
            [
                'report_id' => $report_id,
            ],
            [
                'status' => $request->status,
                'pesan' => $request->pesan,
            ]
            );

            // Setelah berhasil, arahkan ke route yang name nya data.petugas dengan pesan alert.
            return redirect()->route('data.petugas')->with('responseSuccess', 'Berhasil mengubah response');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
