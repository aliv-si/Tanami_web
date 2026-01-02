<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Tailwind Test</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center">

    <div class="text-center space-y-6">

        {{-- Laravel Check --}}
        <h1 class="text-4xl font-bold">
            Laravel: <span class="text-green-400">OK</span>
        </h1>

        {{-- Tailwind Check --}}
        <div class="p-6 rounded-lg bg-gray-800 border border-gray-700">
            <p class="text-xl">
                Tailwind CSS:
                <span class="px-3 py-1 bg-green-500 text-black rounded">WORKING</span>
            </p>
        </div>

        {{-- Interactive Tailwind Test --}}
        <button
            class="px-6 py-3 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-lg transition">
            Tailwind Interaction Test
        </button>

    </div>

</body>
</html>
