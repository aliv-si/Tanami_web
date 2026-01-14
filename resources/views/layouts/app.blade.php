<!DOCTYPE html>
<html class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Tanami - Sustainable Agritech')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <link href="https://fonts.googleapis.com/css2?
    family=Inter:wght@400;500;700;900&
    family=Plus+Jakarta+Sans:wght@400;500;600;700;800&
    display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap"
        rel="stylesheet" />

    <style>
        /* Hide scrollbar but keep scroll functionality */
        html {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        html::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#53be20",
                        "background-light": "#f7f7f7",
                        "background-dark": "#162012",
                        "content-dark": "#1e3f1b",
                        "content-light": "#f2f4f0",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        heading: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        lg: "0.75rem",
                        xl: "1rem",
                        full: "9999px",
                    },
                },
            },
        }
    </script>

    @stack('head')
</head>

<body class="bg-background-light dark:bg-background-dark font-sans text-content-dark">
    <x-navbar />
    @include('components.alert')

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>