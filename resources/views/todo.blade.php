<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>TODO list</title>
</head>

<body>
    <div class="container mt-5">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row justify-content-end">
            <div class="col-lg-6 text-end">
                @auth
                <a href="{{ route('user.logout') }}" class="btn btn-primary">Logout</a>
                @endauth
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <h2>Страница задач</h2>
                @auth
                    <form method="POST" action="{{ route('todos.store') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" placeholder="Название">
                        </div>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </form>
                    <h3>Ваши задачи</h3>
                    @if(Auth::check())
                        @if(Auth::user()->todos->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->todos as $todo)
                                        <tr>
                                            <td>{{ $todo->id }}</td>
                                            <td>{{ $todo->title }}</td>
                                            <td>{{ $todo->created_at }}</td>
                                            <td>
                                                @if($todo->is_completed)
                                                    <div class="badge bg-success">Completed</div>
                                                @else
                                                    <div class="badge bg-warning">Not Completed</div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('todos.edit', ['todo' => $todo->id]) }}" class="btn btn-info">Edit</a>
                                                <form action="{{ route('todos.destroy', ['todo' => $todo->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No todos found.</p>
                        @endif
                    @endif
                @else
                    <p>Пожалуйста, <a href="{{ route('user.login') }}">войдите</a>, чтобы просмотреть свою страницу задач.</p>
                @endauth
            </div>
        </div>
    </div>

    <!-- Ваши скрипты -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>
