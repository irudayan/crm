<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        html {
            background: #f1f1f1;
        }

        body {
            background: #fff;
            border: 1px solid #ccd0d4;
            color: #444;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Nunito, Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            margin: 2em auto;
            padding: 1em 2em;
            max-width: 700px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
        }

        h1 {
            border-bottom: 1px solid #dadada;
            clear: both;
            color: #666;
            font-size: 24px;
            margin: 30px 0 0 0;
            padding: 0;
            padding-bottom: 7px;
        }

        #error-page {
            margin-top: 50px;
        }

        #error-page p,
        #error-page .wp-die-message {
            font-size: 14px;
            line-height: 1.5;
            margin: 25px 0 20px;
        }

        #error-page code {
            font-family: Nunito, Consolas, Monaco, monospace;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        a {
            color: #0073aa;
        }

        a:hover,
        a:active {
            color: #006799;
        }

        a:focus {
            color: #124964;
            -webkit-box-shadow:
                0 0 0 1px #5b9dd9,
                0 0 2px 1px rgba(30, 140, 190, 0.8);
            box-shadow:
                0 0 0 1px #5b9dd9,
                0 0 2px 1px rgba(30, 140, 190, 0.8);
            outline: none;
        }
    </style>
</head>

<body id="error-page">

    <div class="wp-die-message">
        <h1>@yield('code') - @yield('message') </h1> @yield('content')
    </div>


</body>

</html>
