<!DOCTYPE html>
<html>
<head>
    <title>Shark App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('sharks.index') }}">shark Alert</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('sharks.index') }}">View All sharks</a></li>
            <li><a href="{{ route('sharks.create') }}">Create a shark</a>
        </ul>
    </nav>

    @yield('content')

</div>
</body>
</html>
