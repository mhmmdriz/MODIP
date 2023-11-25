<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
    text-align: center
  }
</style>


<h2>Rekap Skripsi Mahasiswa per Angkatan</h2>

<table class="table">

  <tr>
    <td rowspan="2">Status</td>
    <td colspan="7">Angkatan</td>
  </tr>

  <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
    <td>{{ $i }}</td>
    @endfor
  </tr>

  <tr>
    <td>Aktif</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Aktif"]))
        <td>{{ $rekap_status[$i]["Aktif"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

  <tr>
    <td>Lulus</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Lulus"]))
        <td>{{ $rekap_status[$i]["Lulus"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

  <tr>
    <td>Cuti</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Cuti"]))
        <td>{{ $rekap_status[$i]["Cuti"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

  <tr>
    <td>Mangkir</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Mangkir"]))
        <td>{{ $rekap_status[$i]["Mangkir"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

  <tr>
    <td>Drop Out</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Drop Out"]))
        <td>{{ $rekap_status[$i]["Drop Out"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

  <tr>
    <td>Undur Diri</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Undur Diri"]))
        <td>{{ $rekap_status[$i]["Undur Diri"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>
  
  <tr>
    <td>Meninggal Dunia</td>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_status[$i]["Meninggal Dunia"]))
        <td>{{ $rekap_status[$i]["Meninggal Dunia"] }}</td>
      @else
        <td>0</td>
      @endif
    @endfor
  </tr>

</table>

<script>
  window.print();
</script>