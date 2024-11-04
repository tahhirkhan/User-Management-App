<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- navbar start -->
<nav class="navbar navbar-expand-lg " style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Navbar</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <div class="d-flex">
        <a href="{{ route('showAllUsers') }}" class="btn btn-outline-success">All Users</a>
      </div>
      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    </div>
  </div>
</nav>
<!-- navbar end -->

<!-- form start -->
<div class="card m-3 p-4 border border-black">
    <form  method="POST" action="{{ route('submitAddUserForm') }}" class="row g-3">
        @csrf
        <h3 class="text-center mt-1">Add User</h3>

        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control border border-black" id="inputEmail4">
            @error('name')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="form-control border border-black" id="inputPassword4">
            @error('username')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control border border-black" id="inputAddress" placeholder="">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Phone Number</label>
            <input type="text" name="phoneNumber" value="{{ old('phoneNumber') }}" class="form-control border border-black" id="inputAddress2" placeholder="">
            @error('phoneNumber')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" name="city" value="{{ old('city') }}" class="form-control border border-black" id="inputCity">
            @error('city')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="inputState" class="form-label">State</label>
            <input type="text" name="state" value="{{ old('state') }}" class="form-control border border-black" id="inputState">
            @error('state')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="inputCountry" class="form-label">Country</label>
            <input type="text" name="country" value="{{ old('country') }}" class="form-control border border-black" id="inputCountry">
            @error('country')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3">Add User</button>
        </div>
    </form>
</div>
<!-- form end -->