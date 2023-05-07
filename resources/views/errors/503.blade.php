<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>503 | Service Unavailable</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-black">

    <style>
        .main {
            display: flex;
            height: 100vh;
            width: 100%;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <div class="flex items-center justify-center py-12 main">
        <div class="bg-transparant rounded-md flex items-center justify-center mx-4 md:w-2/3">
            <div class="flex flex-col items-center py-16">
                <img style="width: 30rem" class="mb-2" src="{{ asset('src/img/error/503.svg') }}" alt="404 error">
                <h1 class="py-4 text-3xl lg:text-2xl font-bold text-center text-gray-800 dark:text-gray-200">
                    Sorry, we are down for maintenance.
                </h1>
                <p class="pt-4 text-center font-semibold text-gray-800 dark:text-gray-400">
                    We sincerely apologize for the inconvenience. DMIEsys is currently undergoing scheduled maintenance
                    and upgrades but will return shortly. Please check later.
                </p>
            </div>
        </div>
    </div>

</body>

</html>
