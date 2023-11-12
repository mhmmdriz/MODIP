<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
    text-align: center
  }

  .col{
    /* display: flex;
    justify-content: center; */
    margin-left: 30px
  }
</style>


<div class="col">
  <h2>Rekap Skripsi Mahasiswa per Angkatan</h2>
</div>

<div class="col">
  <table class="table">
    <tr>
      <td>Angkatan</td>
      <td>Status</td>
      <td>Banyak Mahasiswa</td>
    </tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
    <tr>
      <td rowspan="7">{{ $i }}</td>
      <td>Aktif</td>
      @if (isset($rekap_status[$i]["Aktif"]))
      <td>{{ $rekap_status[$i]["Aktif"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Lulus</td>
      @if (isset($rekap_status[$i]["Lulus"]))
      <td>{{ $rekap_status[$i]["Lulus"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Cuti</td>
      @if (isset($rekap_status[$i]["Cuti"]))
      <td>{{ $rekap_status[$i]["Cuti"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Mangkir</td>
      @if (isset($rekap_status[$i]["Mangkir"]))
      <td>{{ $rekap_status[$i]["Mangkir"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>DO</td>
      @if (isset($rekap_status[$i]["DO"]))
      <td>{{ $rekap_status[$i]["DO"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Undur Diri</td>
      @if (isset($rekap_status[$i]["Undur Diri"]))
      <td>{{ $rekap_status[$i]["Undur Diri"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Meninggal Dunia</td>
      @if (isset($rekap_status[$i]["Meninggal Dunia"]))
      <td>{{ $rekap_status[$i]["Meninggal Dunia"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    @endfor

  </table>
</div>

<script>
  window.print();
</script>