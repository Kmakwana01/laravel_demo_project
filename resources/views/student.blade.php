@include('bootstrap')



<link rel="stylesheet" href="/css/app.css">
<div class="container">
    <div class="row">
        {{-- @php
            $routeUrl = route('addUser');
            $fullUrl = url('users/' . ltrim(parse_url($routeUrl, PHP_URL_PATH), '/'));
        @endphp --}}
        <form class="col-6 shadow p-4 mt-5 mx-auto" action="{{ route('Add_Student') }}" method="post">
            {{-- <p class="text-center my-2">{{URL::current()}}</p> --}}
            @csrf
            @method('POST')
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
                <label for="validationServer03" class="form-label">Roll No.</label>
                <input class="form-control  @error('roll_no') is-invalid @enderror" id="validationServer03"
                    aria-describedby="validationServer03Feedback" type="text" name="roll_no"
                    value="{{ old('roll_no') }}">
                @error('roll_no')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            @if (request()->has('message'))
                <div class="alert alert-success p-1" role="alert">
                    <p class="m-1"> {{ request()->query('message') }}</p>
                </div>
            @endif


            <button type="submit" class="btn btn-primary col-12 mt-0">Submit</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="row">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand">Navbar</a>
                <form class="d-flex mb-0" role="search" method="GET" action="{{ route('search') }}">
                    <input class="form-control me-2" placeholder="Search" aria-label="Search" name="search"
                        value="{{ @$search }}" required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
</div>

<div class="container mt-4">
    <!-- Display the message if it exists -->
    @if (request()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ request()->query('message') }}
        </div>
    @endif



    <!-- Table to display user data -->
    <form id="batch-delete-form" action="{{ route('Delete_Multiple_Students') }}" method="POST">
        @csrf
        @method('POST   ')
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roll No.</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}"></td>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->roll_no }}</td>
                        <td>{{ $student->created_at }}</td>
                        <td>{{ $student->updated_at }}</td>
                        <td>

                            <form action="{{ route('Edit_Student', $student->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-warning mx-2"
                                    style="display:none;">Update</button>
                            </form>
                            <form action="{{ route('Edit_Student', $student->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-warning mx-2">Update</button>
                            </form>

                            <form action="{{ route('Delete_Student', $student->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-2">Delete</button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No students found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-start mt-4">
            <button type="submit" class="btn btn-danger">Delete Selected</button>
        </div>
    </form>



</div>



<div class="d-flex justify-content-center mt-4">
    {{ $students->appends(request()->query())->links('vendor.pagination.custom') }}
</div>
