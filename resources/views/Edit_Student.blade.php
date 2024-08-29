@include('bootstrap')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit student</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            @if (!empty($message))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <!-- Update student Form -->
            @if (!empty($student))
                <form class="col-6 shadow p-4 mt-5 mx-auto" action="{{ route('Update_Student', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div><h3 class="text-center" >Edit Student</h3></div>
                    <div class="mb-3 mt-2">
                        <label for="validationServer03" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="validationServer03" aria-describedby="validationServer03Feedback" name="name"
                            value="{{ $student->name }}">
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
                            value="{{ $student->email }}">
                        @error('email')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="validationServer03" class="form-label">Roll_No.</label>
                           <input type="text" class="form-control @error('roll_no') is-invalid @enderror" id="roll_no" name="roll_no"  value="{{ $student->roll_no }}">
                        @error('roll_no')
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

</body>

</html>
