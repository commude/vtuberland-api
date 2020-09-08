<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>VTuberland</title>

        <style>
            body, html {
                height: 100%;
                margin: 0;
            }

            .bg {
              /* The image used */
              background-image: url({{ asset('images/tmp.png') }});

              /* Full height */
              height: 100%;

              /* Center and scale the image nicely */
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
            }
            </style>
    </head>
    <body>
        <div class="bg"></div>
    </body>
</html>
