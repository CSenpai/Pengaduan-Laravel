<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>
<body>
    <table>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>No Telp</th>
            <th>Tanggal</th>
            <th>Pengaduan</th>
            <th>Gambar</th>
            <th>Status Response</th>
            <th>Pesan Response</th>
        </tr>

        @php 
            $no = 1;
        @endphp

        @foreach ($reports as $data)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$data['nik']}}</td>
            <td>{{$data['nama']}}</td>
            <td>{{$data['no_telp']}}</td>
            <td>{{\Carbon\Carbon::parse($data['created_at'])->format('j F, Y')}}</td>
            <td>{{$data['pengaduan']}}</td>
            <td><img src="assets/image/{{$data['foto']}}" width="80"></td>
            <td>
                {{-- Cek apakah data report ini sudah memiliki dengan data dr with ('reponse') --}}
                @if ($data['response'])
                {{-- Kalau ada hasil relasinya, tampilkan bagian status --}}
                    {{$data['response']['status']}}
                @else
                {{-- Kalau tidak ada menampilkan tanda ini --}}
                    - 
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>