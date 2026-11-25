<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UTS Pem Web')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .add-card-btn {
            width: 84px;
            height: 84px;
            background: linear-gradient(135deg, #74c476 0%, #5cb85c 100%);
            transition: transform 0.15s ease, filter 0.15s ease;
        }

        .add-card-btn:hover {
            transform: scale(1.05);
            filter: brightness(0.95);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-white">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="{{ route('home') }}">UTS Pem Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">MOHAMMAD KELVIN GOSAL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">24010110213</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">Features</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">Pricing</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">FAQs</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">About</a>
                </li>
            </ul>
            <p class="text-center text-body-secondary mb-0">
                &copy; 2025 Dibuat Sejujurjurnya Oleh Team MOHAMMAD KELVIN GOSAL dan SAMFAHRID RAIKI ALFAUZI (24010110252) Tanpa Mencotek dari Tim Lain
            </p>
        </footer>
    </div>
</body>

</html>
