<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-12">
        <div class="flex justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Jasa</h1>
            <a href="{{ url('produk/create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Tambah Jasa</a>
        </div>

        <div class="mt-8">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md overflow-hidden" id="produk-table">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-6 text-left font-semibold text-gray-700">No</th>
                            <th class="py-3 px-6 text-left font-semibold text-gray-700">Nama Jasa</th>
                            <th class="py-3 px-6 text-left font-semibold text-gray-700">Deskripsi</th>
                            <th class="py-3 px-6 text-left font-semibold text-gray-700">Durasi</th>
                            <th class="py-3 px-6 text-left font-semibold text-gray-700">Kategori</th>
                            <th class="py-3 px-6 text-right font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="produk-data">
                        <!-- Data akan dimuat di sini menggunakan AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
        // Function to load data using AJAX
        function loadData() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/produk',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let tableBody = $('#produk-data');
                    tableBody.empty();

                    if (response.status && response.data.length > 0) {
                        $.each(response.data, function(index, item) {
                            tableBody.append(`
                                <tr class="border-b hover:bg-gray-100 transition">
                                    <td class="py-4 px-6 text-gray-800">${index + 1}</td>
                                    <td class="py-4 px-6 text-gray-800">${item.judul}</td>
                                    <td class="py-4 px-6 text-gray-800">${item.deskripsi}</td>
                                    <td class="py-4 px-6 text-gray-800">${item.durasi}</td>
                                    <td class="py-4 px-6 text-gray-800">${item.kategori}</td>
                                    <td>
                                        <a href="produk/${item.id}/edit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">Edit</a>
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 deleteBarangBtn" data-id="${item.id}">Hapus</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        tableBody.append(`
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-gray-800 text-center">Tidak ada data jasa.</td>
                            </tr>
                        `);
                    }
                },
                error: function() {
                    let tableBody = $('#produk-data');
                    tableBody.empty();
                    tableBody.append(`
                        <tr>
                            <td colspan="6" class="text-center">Gagal memuat data.</td>
                        </tr>
                    `);
                }
            });
        }

        // Call loadData on page load
        loadData();

        // Handle delete
        $(document).on('click', '.deleteBarangBtn', function() {
            let id = $(this).data('id');
            
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `http://127.0.0.1:8000/api/produk/${id}`,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        $('#alert-container').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div>
                        `);
                        loadData(); // Update data after delete
                    },
                    error: function() {
                        $('#alert-container').html(`
                            <div class="alert alert-danger">
                                Gagal menghapus data.
                            </div>
                        `);
                    }
                });
            }
        });
    });
    </script>
</body>

</html>
