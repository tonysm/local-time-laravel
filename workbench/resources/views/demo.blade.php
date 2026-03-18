<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Local Time Laravel</title>

        <script type="importmap">
        {
            "imports": {
                "local-time": "/vendor/local-time-laravel/local-time.js"
            }
        }
        </script>

        <script type="module">
            import LocalTime from "local-time"
            LocalTime.start()
        </script>
    </head>
    <body>
        <h1>Local Time Laravel Demo</h1>

        <h2>Time</h2>
        <x-local-time::time :value="now()" />

        <h2>Date</h2>
        <x-local-time::date :value="now()" />

        <h2>Ago</h2>
        <x-local-time::ago :value="now()->subMinutes(5)" />

        <h2>Relative</h2>
        <x-local-time::relative :value="now()->addDays(2)" />

        <h2>Null</h2>
        <x-local-time::relative :value="null" />
    </body>
</html>
