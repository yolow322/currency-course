<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body>
        <h1 class="text-center">
            <b>{{$exception->getCode() . ' - ' . $exception->getMessage()}}</b>
        </h1>
    </body>
</html>