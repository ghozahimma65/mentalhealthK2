<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Task App</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="{{ url('/task') }}">Home</a></li>
            <li><a href="{{ url('/task/create') }}">Create Task</a></li>
        </ul>
    </nav>
</header>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Task App</p>
    </footer>
</body>
</html>
