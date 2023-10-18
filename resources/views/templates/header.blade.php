<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIP</title>
    <!-- baseurl diambil dari file Constants di folder Core -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<body data-bs-theme="dark">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="/"><b>MODIP</b></a>
    @auth
      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{-- terdapat method auth() pada laravel, untuk mengambil semua data milik user yang sudah login --}}
          @if (auth()->user()->level == "Mahasiswa")
            Welcome back,  {{ auth()->user()->mahasiswa->nama }}
          @elseif(auth()->user()->level == "Dosen")
            Welcome back,  {{ auth()->user()->dosen_wali->nama }}
          @elseif(auth()->user()->level == "Departemen")
            Welcome back,  {{ auth()->user()->departemen->nama }}
          @else
            Welcome back,  {{ auth()->user()->operator->nama }}
          @endif
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-text-window-reverse"></i> My Dashboard</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            {{-- dijadikan form karena ingin mengirim csrf juga --}}
            <form action="/logout" method="POST">
              @csrf
              <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
          </li>
        </ul>
      </div>
    @endauth

    {{-- <form action="/logout" method="POST">
      @csrf
      <button type="submit" class="nav-link px-3">
        Logout <span data-feather="log-out"></span>
      </button>
    </form> --}}
  </div>
</nav>
<div class="container mt-4">

