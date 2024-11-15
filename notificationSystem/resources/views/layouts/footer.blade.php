<!-- Footer -->
<footer class="bg-gray-800 text-white py-4 fixed left-0 bottom-0 right-0 w-full mt-4 shadow-lg">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 My Application. All rights reserved.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/js/main.js"></script>
@yield('scripts')
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

@vite('resources/js/app.js')
    </body>
</html>
