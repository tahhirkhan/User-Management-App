<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- toast start -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<!-- toast end -->

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
        <a href="{{ route('addUserForm') }}" class="btn btn-outline-success"><i class="bi bi-plus-circle"></i> Add User</a>
      </div>
      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    </div>
  </div>
</nav>
<!-- navbar end -->

<!-- table start -->
<div class="card p-3 m-2">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            @if($data->isNotEmpty())
            @php
                $count = 1;
            @endphp
            @foreach($data as $da)
            <tr>
                <th scope="row">{{ $count }}</th>
                <td>{{ $da->username ?? '' }}</td>
                <td>{{ $da->full_name ?? '' }}</td>
                <td>{{ $da->email->email ?? '' }}</td>
                <td>{{ $da->phoneNumber->phone_number ?? ''}}</td>
                <td>
                    {{ $da->address->city ?? '' }},
                    {{ $da->address->state ?? '' }},
                    {{ $da->address->country ?? '' }}
                </td>
                <td>
                    <a href="#" class="view-details" data-id="{{ base64_encode($da->id) }}" data-username="{{ $da->username }}" data-name="{{ $da->full_name }}" data-email="{{ $da->email->email }}" data-phone="{{ $da->phoneNumber->phone_number }}" data-city="{{ $da->address->city }}" data-state="{{ $da->address->state }}" data-country="{{ $da->address->country }}"><i class="btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"></i></a>
                    <a href="{{ route('deleteUser', base64_encode($da->id)) }}"><i class="btn btn-danger bi bi-trash-fill"></i></a>        
                </td>
            </tr>
            @php
                $count++;
            @endphp
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<!-- table start -->

<!-- modal start --> 
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update User Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('updateUserDetails') }}">
          @csrf

          <input type="hidden" name="user_id" id="user-id">

          <div class="mb-3">
            <label for="user-name" class="col-form-label">Username</label>
            <input type="text" name="username" class="form-control border border-black" id="user-name">
            @error('username')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Name</label>
            <input type="text" name="name" class="form-control border border-black" id="recipient-name">
            @error('name')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="message-email" class="col-form-label">Email</label>
            <input type="text" name="email" class="form-control border border-black" id="message-email">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label for="message-phone" class="col-form-label">Phone Number</label>
            <input type="text" name="phoneNumber" class="form-control border border-black" id="message-phone">
            @error('phoneNumber')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="message-city" class="col-form-label">City</label>
            <input type="text" name="city" class="form-control border border-black" id="message-city">
            @error('city')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="message-state" class="col-form-label">State</label>
            <input type="text" name="state" class="form-control border border-black" id="message-state">
            @error('state')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="message-country" class="col-form-label">Country</label>
            <input type="text" name="country" class="form-control border border-black" id="message-country">
            @error('country')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div> -->
    </div>
  </div>
</div>
<!-- modal end -->

<script>
  // Listen for clicks on the eye icon
  document.querySelectorAll('.view-details').forEach(item => {
    item.addEventListener('click', event => {
      // Get data attributes from the clicked row
      const id = event.currentTarget.getAttribute('data-id');
      const username = event.currentTarget.getAttribute('data-username');
      const name = event.currentTarget.getAttribute('data-name');
      const email = event.currentTarget.getAttribute('data-email');
      const phone = event.currentTarget.getAttribute('data-phone');
      const city = event.currentTarget.getAttribute('data-city');
      const state = event.currentTarget.getAttribute('data-state');
      const country = event.currentTarget.getAttribute('data-country');
      
      // Set values in the modal input fields
      document.getElementById('user-id').value = id;
      document.getElementById('user-name').value = username;
      document.getElementById('recipient-name').value = name;
      document.getElementById('message-email').value = email;
      document.getElementById('message-phone').value = phone;
      document.getElementById('message-city').value = city;
      document.getElementById('message-state').value = state;
      document.getElementById('message-country').value = country;
    });
  });
</script>

<script>
  function showUserSavedAlert(message_type, message_title) {
    Swal.fire({
      title: message_title,
      icon: message_type
    });
  }
</script>

<!-- if session has a success parameter only then the above written sweet alert will be fired -->
<!-- @if(Session::has('success'))
<script>
  showUserSavedAlert('success', '{{ Session::get('success') }}');
</script>
@endif -->

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('toastMessage');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>
@endif



