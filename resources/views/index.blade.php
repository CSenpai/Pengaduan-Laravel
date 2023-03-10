<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
    <header class="navbar">
        <a href="/" class="active2">AKIRA</a>
        
        {{-- Kalau sudah login, button yang akan dimunculkan adalah button untuk masuk ke halaman data --}}
        @if (Auth::check())
            @if (auth::user()->role == 'admin')
                <a href="{{route('data')}}" class="login-btn">Lihat Data</a>
            @elseif (Auth::user()->role == 'petugas')
                <a href="{{route('data.petugas')}}" class="login-btn">Lihat data</a>
            @endif

        {{-- Kalau dia belum login, button yang akan dimunculkan adalah nutton untuk masuk ke halaman login --}}
        @else
        <a href="{{route('login')}}" class="login-btn">Administrator</a>
        @endif
    </header>
     <!-- <header>
        {{-- Kalau sudah login, button yang dimunculkan button untuk masuk ke halaman data--}}
        @if (Auth::check())
        <a href="{{route('data')}}" class="login-btn">Lihat Data</a>

        {{-- Kalau dia belim login, yang dimunculkan adalah button ke halaman login --}}
        @else
        <a href="{{route('login')}}" class="login-btn">Administrator</a>
        @endif
    </header>  -->

    <section class="baris">
        <div class="kolom kolom1">
            <h1 style="text-align:left;">Pengaduan Masyarakat</h1>
            <ol>
                <h3><li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias modi nemo illum beatae omnis fugit!</li></h3>
                <h3><li>Lorem ipsum, dolor sit amet consectetur adipisicing et. Aspernatur, debitis?</li></h3>
                <h3><li>Lorem ipsum dolor sit, amet consectetur adipisicing et. Voluptate egendi et atque dolores veniam maiores quasi error deserunt ducimus delectus?</li></h3>
                <h3><li>Lorem ipsum dolor sit amet.</li></h3>
            </ol>
        </div>
        <div class="kolom kolom2">
            <img src="{{asset('assets/image/spanduk-bg.jpeg')}}" alt="" style="border-radius: 35px;">
        </div>
    </section>

    <section class="flex-container">
        <div class="item">
            <h1>Jumlah Kecamatan <br> 15</h1>
        </div>
        <div class="item">
            <h1>Jumlah Desa <br> 42</h1>
        </div>
        <div class="item">
            <h1>Jumlah Penduduk <br> 12.000</h1>
        </div>
        <div class="item">
            <h1>Data per Tahun <br> 2023</h1>
        </div>
    </section>

    <section class="form-container">
        <div class="card form-card">
            <h2 style="text-align: center; margin-bottom: 20px;">Buat Pengaduan</h2>

            @if ($errors->any())
                <ul style="width:100%; background: red; padding: 10px;">
                    @foreach ($errors->all() as $error)
                        <li> {{$error}} </li>
                    @endforeach
                </ul>
            @endif

            @if (Session::get('success'))
            <ul style="width:100%; background: green; padding: 10px;">
                {{ Session::get('success') }}
            </ul>
            @endif


            <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-card">
                    <label for="">NIK :</label>
                    <input type="number" name="nik" id="">
                </div>
                <div class="input-card">
                    <label for="">Nama Lengkap :</label>
                    <input type="text" name="nama" id="">
                </div>
                <div class="input-card">
                    <label for="">No Telp :</label>
                    <input type="number" name="no_telp" id="">
                </div>
                <div class="input-card">
                    <label for="">Pengaduan :</label>
                    <textarea rows="5" name="pengaduan"></textarea>
                </div>
                <div class="input-card">
                    <label for="">Upload Gambar Terkait :</label>
                    <input type="file" name="foto">
                </div>
                <button>Kirim</button>
            </form>
        </div>
        <div class="card laporan-card"><i>
            <h2 style="text-align: center; margin-top: 20px;">Laporan Pengaduan</h2>
            @foreach ($reports as $report)
            <div class="article">
                <p>{{ \Carbon\Carbon::parse($report['created_at'])->format('j F, Y') }} : {{$report['nama']}}</p>
                <div class="content">
                    <div class="text">
                        {{$report['pengaduan']}}
                    </div>
                    <div>
                        <img src="{{asset('assets/image/' . $report->foto)}}" alt="">
                    </div>
                </div>
            </div>
            @endforeach

            <!-- ((-- Memunculkan button pagination --)) -->
            <div style="display: flex; justify-content: flex-end; margin-top: 10px ">
                {!! $reports->links() !!}
            </div>

        </i></div>
    </section>

    <footer>
        Copyright &copy; 2023;
    </footer>
</body>

</html>