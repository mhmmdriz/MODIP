<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
    text-align: center
  }
</style>

<div class="col">
  <h2>Rekap PKL Mahasiswa Perwalian per Angkatan</h2>
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
      @if (isset($rekap_pkl[$i]))
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">Sudah</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">Belum</td>
      @else
      <td>Sudah</td>
      <td>Belum</td>
      @endif
    @endfor
    </tr>
    
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_pkl[$i]))
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">{{ $rekap_pkl[$i]["sudah_pkl"] }}</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">{{ $rekap_pkl[$i]["belum_pkl"] }}</td>
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
      @if (isset($rekap_pkl[$i]))
      <td>{{ $rekap_pkl[$i]["sudah_pkl"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr>
    <tr>
      <td>Belum</td>
      @if (isset($rekap_pkl[$i]))
      <td>{{ $rekap_pkl[$i]["belum_pkl"] }}</td>
      @else
      <td>0</td>  
      @endif
    </tr> --}}
    {{-- @endfor --}}
  </table>
</div>

<script>
  print();
</script>