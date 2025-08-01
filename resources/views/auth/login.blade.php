<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {!! App\Models\Company::first()->company_name ?? '' !!}</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-with-prefix.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <style>
        .company_logo{
            width: 50% !important;
            height: auto !important;
        }
    </style>
    <div class="container">
      <div class="row">
        <!-- Left Blank Side -->
        <div class="col-lg-6">
                {!! App\Models\Company::first()->logo ?? '' !!}
        </div>

        <!-- Right Side Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center right-side">
          <div class="form-2-wrapper">

            <h3 class="text-center mb-4">Sign Into Your Account</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
              <div class="mb-3 form-box">
                <input type="text" class="form-control" id="email" name="username" placeholder="Enter Your Username" required>
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                  <a href="forget-3.html" class="text-decoration-none float-end">Forget Password</a>
                </div>

              </div>
              <button type="submit" class="btn btn-outline-secondary login-btn w-100 mb-3">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>


</body>

</html>
