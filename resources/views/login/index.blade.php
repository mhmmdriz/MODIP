@include('templates.header')

<div class="row d-flex justify-content-center">
  <div class="col my-5" style="max-width: 800px; max-height: 531px">
    <div class="card mb-3" >
      <div class="row g-0">
        <div class="col-md-5" style="overflow: hidden">
          <img src="img/if.undip.png" class="img-fluid rounded-start h-100 object-fit-cover">
        </div>
        <div class="col-md-7">
          <div class="card-body ms-2">
            <h5 class="card-title">Sign In</h5>
            <hr>
            <div class="mb-3">
              @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('loginError') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
            </div>

            <form action="/login" method="post">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="mb-3">
                <div id="login_error" class="form-text"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('templates.footer')
