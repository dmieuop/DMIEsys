<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 | Page Not Found</title>
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
                <img style="width: 20rem" class="mb-2" src="{{ asset('src/img/error/404.svg') }}" alt="404 error">
                <h1 class="py-4 text-3xl lg:text-2xl font-bold text-center text-gray-800 dark:text-gray-200">
                    Congratulation! you've found nothing.
                </h1>
                <p class="pt-4 text-center font-semibold text-gray-800 dark:text-gray-400">
                    The content you're looking for doesn't exist. Either it was removed, or you mistyped the link.
                </p>
                <p class="py-2 pb-4 font-semibold text-center text-gray-800 dark:text-gray-400">
                    Sorry about that! Please visit our hompage to get where you need to go.
                </p>
                <a href="{{ route('home') }}" class="btn btn-blue">Go To Home</a>
            </div>
        </div>
    </div>

</body>

</html>
