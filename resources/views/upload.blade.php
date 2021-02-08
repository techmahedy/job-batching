<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body class="antialiased">

      <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv">
            <input type="submit" value="submit">
      </form>

    </body>
</html>
