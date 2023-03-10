<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <script src="https://kit.fontawesome.com/d57afa2247.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="navbar">
    <a class="active" href="{{route('data.petugas')}}">Laporan Keluhan</a>
  <a href="/"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  <!-- <button type="submit" class="btn-login">Login</button> -->
    <!-- <div class="search" action="" method="GET">
        <input type="text" name="search" placeholder="Cari Nama Data..." style="margin-right: 10%;">
        <button type="submit">Search</button>
    </div> -->
</div>  
    <h1 class="title-table" style="margin-left: -70%;">Laporan Keluhan (Petugas) </h1>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <!-- <button class="active2" href="/logout">Logout</button>  -->
    <!-- style="margin-right: 1%; background-color: #44435F; color: #D3D4D7; -->
    <!-- <div style="margin: 0 10px"> | </div> -->
    <!-- <button href="/" style="margin-right: 10px; background-color: #44435F; color: #D3D4D7;">Home</button> -->
</div>
<div style="display: flex; justify-content: flex-end; align-items: center;">
    {{-- Menggunakan method GET karna route untuk masuk ke halaman data ini menggunakan ::get --}}
    <form action="" method="GET">
        @csrf
        <input type="text" name="search" placeholder="Cari Nama Data..." style="margin-right: 10px; background-color: white;">
        <button type="submit" class="btn-login" style="margin-top: 0px; margin-right: 35px; background-color: #44435F; color: #D3D4D7;">Search</button>
    </form>
    {{-- Refresh kembali lagi ke route data karena ketika di klik Refresh akan membersihkan riwayat pecarian sebelumnya
        dan mengembalikan ke galam data awal--}}
    <!-- <button href="{{route('data')}}" style="margin-right: 45px; margin-top: -10px; background-color: #44435F; color: #D3D4D7;">Refresh</button> -->
</div>
<div style="padding: 0 30px">
<table style="color:">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Pengaduan</th>
            <th>Gambar</th>
            <th>Status Response</th>
            <th>Pesan Response</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            
            @foreach ($reports as $data)
            <tr>
            <td>{{$no++ }}</td>
            <td>{{$data->nik}}</td>
            <td>{{$data->nama}}</td>
            <td>{{$data->no_telp}}</td>
            <td>{{$data->pengaduan}}</td>
            <td>
                <img src="{{asset('assets/image/' . $data->foto)}}"  width="120" alt="">
            </td>
            <td>
                {{-- Cek apakah data report ini sudah memiliki relasi daengan data dr with('response') --}}
                @if ($data->response)
                {{-- Kalau ada hasil relasinya, tampilkan bagian pesan --}}
                    {{ $data->response['status']}}
                @else
                {{-- Kalau tidak ada tampilkan tanda ini --}}
                    -
                @endif
            </td>
            <td>
                {{-- Cek apakah data report ini sudah memiliki relasi daengan data dr with('response') --}}
                @if ($data->response)
                {{-- Kalau ada hasil relasinya, tampilkan bagian pesan --}}
                    {{ $data->response['pesan']}}
                @else
                {{-- Kalau tidak ada ditampilkan tanda ini --}}
                    -
                @endif
            </td>
            <td>
                <form href="{{route('response.edit', $data->id)}}">
                    @csrf
                    <a href="{{route('response.edit', $data->id)}}" class="back-btn" style="margin-left: -25px; margin-right: 8%; margin-top: 0px; padding: 15px;">Send Response</a>
                </form>                

                <div>
                    <form action="{{route('export-pdf', $data->id)}}" method="get">
                        @csrf 
                        <a href="/export/pdf/{{$data->id}}" style="margin-left: -25px; margin-right: 15%; margin-top: 10px; padding: 15px;" class="back-btn"><i class="fa-solid fa-file-arrow-down"></i>Print PDF</a>
                    </form>
                </div>
            <!-- <td style="display: flex; justify-content: center;">
                <form href="{{route('response.edit', $data->id)}}" class="back-btn" style="margin-top: 10px; margin: 10px;">Send Response</form>

                <div action="{{route('export-pdf', $data->id)}}" method="get">
                        @csrf 
                        <button href="/export/pdf/{{$data->id}}" style="margin: 10px;"><i class="fa-solid fa-file-arrow-down"></i>Print PDF</button>
                </div> -->
            </td>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>