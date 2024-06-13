<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jasa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Tambah Jasa</h1>
            <form id="add-form" enctype="multipart/form-data">
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="judul">Judul</label>
                    <input type="text" name="judul" id="judul" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="durasi">Durasi Pengerjaan</label>
                    <input type="text" name="durasi" id="durasi" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex place-content-end gap-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out">Tambah</button>
                    <a href="{{ url('produk') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300 ease-in-out">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add-form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: 'http://127.0.0.1:8001/api/produk',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Data berhasil ditambahkan!');
                        window.location.href = "{{ url('produk') }}";
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>

</html>
