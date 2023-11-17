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
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      <td colspan="2">{{ $i }}</td>
    @endfor
    </tr>
  
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_skripsi[$i]))
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Sudah">Sudah</td>
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Belum">Belum</td>
      @else
      <td>Sudah</td>
      <td>Belum</td>
      @endif
    @endfor
    </tr>
    
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_skripsi[$i]))
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Sudah">{{ $rekap_skripsi[$i]["sudah_skripsi"] }}</td>
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Belum">{{ $rekap_skripsi[$i]["belum_skripsi"] }}</td>
      @else
      <td>0</td>
      <td>0</td>  
      @endif
    @endfor
    </tr>
    
    {{-- <tr>
      <td>Angkatan</td>
      <td>Status</td>
      <td>Banyak Mahasiswa</td>
    </tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
    <tr>
      <td rowspan="2">{{ $i }}</td>
      <td>Sudah</td>
      @if (isset($rekap_skripsi[$i]))
      <td>{{ $rekap_skripsi[$i]["sudah_skripsi"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Belum</td>
      @if (isset($rekap_skripsi[$i]))
      <td>{{ $rekap_skripsi[$i]["belum_skripsi"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    @endfor --}}

  </table>
</div>

<script>
  window.print();
</script>