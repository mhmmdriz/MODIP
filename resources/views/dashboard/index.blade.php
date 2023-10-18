@include('templates.header')

<div class="row d-flex justify-content-center">
  <div class="col my-5" style="max-width: 800px; max-height: 531px">
    <div class="card mb-3" >
      @can('mahasiswa')
        @include('dashboard.partials.mahasiswa')
      @endcan
      @can('dosenwali')
        @include('dashboard.partials.dosenwali')          
      @endcan
      @can('departemen')
        @include('dashboard.partials.departemen')
      @endcan
      @can('operator')
        @include('dashboard.partials.operator')
      @endcan
    </div>
  </div>
</div>

@include('templates.footer')
