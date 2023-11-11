<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
    text-align: center
  }

  .col{
    display: flex;
    justify-content: center;
  }
</style>
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
      <td>~</td>
      <td>~</td>  
      @endif
    @endfor
    </tr>
  </table>
</div>

<script>
  window.print();
</script>