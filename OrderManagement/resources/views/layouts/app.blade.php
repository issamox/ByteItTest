<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Byteit Test Technique </title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-blue-600 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">BYTEIT</h1>
        <nav>
            <ul class="flex space-x-6">
                <li><a href="{{ route('products.index') }}" class="hover:text-gray-300">Products</a></li>
                <li><a href="{{ route('clients.index') }}" class="hover:text-gray-300">Clients</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="container mx-auto my-8">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 My Application. All rights reserved.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Display Success Message -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Good job!',
            text: '{{ session('success')  }}',
            icon: 'success',
        })
    </script>
@endif

</body>
</html>
