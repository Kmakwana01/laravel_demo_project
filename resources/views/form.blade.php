@include('bootstrap');

{{-- <h1>Form Page</h1>

<a href="{{ route('Home') }}">Home</a>
<a href="{{ route('About') }}">About</a>
<a href="{{ route('Form') }}">Form</a> --}}

<link rel="stylesheet" href="/css/app.css">
<div class="container">
    <div class="row">
        {{-- @php
            $routeUrl = route('addUser');
            $fullUrl = url('users/' . ltrim(parse_url($routeUrl, PHP_URL_PATH), '/'));
        @endphp --}}
        <form class="col-6 shadow p-4 mt-5 mx-auto" action="{{ route('addUser') }}" method="post">
            {{-- <p class="text-center my-2">{{URL::current()}}</p> --}}
            @csrf
            <div class="mb-3">
                <label for="validationServer03" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="validationServer03"
                    aria-describedby="validationServer03Feedback" name="name" value="{{ old('name') }}">
                @error('name')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="validationServer03" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="validationServer03"
                    aria-describedby="validationServer03Feedback" name="email" value="{{ old('email') }}">
                @error('email')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="validationServer03" class="form-label">Password</label>
                <input class="form-control  @error('password') is-invalid @enderror" id="validationServer03"
                    aria-describedby="validationServer03Feedback" type="password" name="password"
                    value="{{ old('password') }}">
                @error('password')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if (!empty($message))
                <div class="alert alert-success p-1" role="alert">
                    <p class="m-1">{{ $message }}</p>
                </div>
            @endif
            <button type="submit" class="btn btn-primary col-12 mt-0">Submit</button>
        </form>
    </div>
</div>

<div class="container mt-4">
    <!-- Display the message if it exists -->
    @if (!empty($message))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif

    <!-- Table to display user data -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($users))
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <form action="{{ route('users.edit', $user->id) }}" method="get" style="display:inline;">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-warning mx-2">Update</button>
                            </form>

                            <!-- Delete Form -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No users found</td>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</div>
