@include('bootstrap');

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <h1>Edit User</h1>

            @if (!empty($message))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <!-- Update User Form -->
            @if (!empty($user))
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="validationServer03" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="validationServer03" aria-describedby="validationServer03Feedback" name="name"
                            value="{{ $user->name }}">
                        @error('name')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="validationServer03" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                            id="validationServer03" aria-describedby="validationServer03Feedback" name="email"
                            value="{{ $user->email }}">
                        @error('email')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="validationServer03" class="form-label">Password</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank if you don't want to change">
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
            @endif

        </div>
    </div>

    <!-- Optional JavaScript -->
</body>

</html>
