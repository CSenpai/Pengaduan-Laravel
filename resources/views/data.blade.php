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
    <a class="active" href="{{route('data')}}">Laporan Keluhan</a>
  <a href="/"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  <!-- <button type="submit" class="btn-login">Login</button> -->
    <!-- <div class="search" action="" method="GET">
        <input type="text" name="search" placeholder="Cari Nama Data..." style="margin-right: 10%;">
        <button type="submit">Search</button>
    </div> -->
</div>  
    <h1 class="title-table" style="margin-left: -80%;">Laporan Keluhan</h1>
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
    <a href="{{route('export-pdf')}}" class="btn-login" style="margin-left: -25px; margin-right: 15px; margin-top: -10px;">Cetak PDF</a>
    <a href="{{route('export.excel')}}" class="btn-login" style="margin-left: 0px; margin-right: 35px; margin-top: -10px;">Cetak Excel</a>
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

            <!-- {{-- Menggangti format 08 menjadi 628 --}}
        {{-- substr_replace = mengubah karakter string
             punya 3 argumen. Argumen-1 = daat uang ingin dimasukan ke string
             argumen ke-2 = mulai dari index yang mana diubahnya
             argumen ke-3 = samapi index mana yang diubah--}} -->
        @php
            $telp = substr_replace($data->no_telp, "62", 0, 1)
        @endphp

            <td><a href="https://wa.me/{{$telp}}" target="_blank">{{$telp}}</a></td>
            <td>{{$data->pengaduan}}</td>
            <td>
                <img src="{{asset('assets/image/' . $data->foto)}}"  width="120" alt="">
            </td>
            <td>
                <form action="{{ route('destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('GET')
                    <button type="submit" class="btn btn-danger" style="margin-right: 27%; margin-top: -0%; padding: 15px; background-color: #44435F; color: #D3D4D7;">Delete</button>
                </form>                

                <div>
                    <form action="{{route('export-pdf', $data->id)}}" method="get">
                        @csrf 
                        <button href="/export/pdf/{{$data->id}}" style="margin-left: -25px; margin-right: 17%; margin-top: 10px; padding: 15px;"><i class="fa-solid fa-file-arrow-down"></i>Print PDF</button>
                    </form>
                </div>
            </td>
            </tr>
            @endforeach
            <tr>
        </tbody>
    </table>
</div>
</body>
</html>