<?php

namespace App\Exports;

use App\Models\Report;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Concerns\FromCollection;
// Mengatur nama-nama column header di excelnya
use Maatwebsite\Excel\Concerns\WithMapping;
// Mengatur data yang memunculkan tiap column di excelnya
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // Mengambil data dari database diambil dari FromCollection
    public function collection()
    {
        // Didalam sini bisa menyertakan perintah Eloquent lain seperti where, all, dll
        return Report::orderBy('created_at', 'DESC')->get();
    }

    // Menagtur nama nama column headers
    public function headings(): array
    {
        return [
            'ID',
            'NIK Pelapor',
            'Nama Pelapor',
            'No Telp Pelapor',
            'Tanggal Pelaporan',
            'Pengaduan',
            'Status Response',
            'Pesan Response',
        ];
    }

    // Mengatur data yang ditampilkan per column di excelnya
    // Fungsinya seperti foreach. $item merupakan bagian as pada foreach
    public function map($item): array
    {
        return [
            $item->id,
            $item->nik,
            $item->nama,
            $item->no_telp,
            \Carbon\Carbon::parse($item->created_at)->format('j F, Y'),
            $item->pengaduan,
            $item->response ? $item->response['status'] : '_',
            $item->response ? $item->response['pesan'] : '_',
        ];
    }
}
