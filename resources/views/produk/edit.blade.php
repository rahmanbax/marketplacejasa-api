<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jasa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Jasa</h1>
            <form id="jasaForm" data-id="{{ $id }}">
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" >Judul</label>
                    <input type="text" id="judul" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" >Deskripsi</label>
                    <textarea id="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" >Durasi</label>
                    <input type="text" id="durasi" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" >Kategori</label>
                    <input type="text" id="kategori" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex place-content-end gap-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out">Simpan</button>
                    <a href="{{ url('produk') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300 ease-in-out">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let id = $('#jasaForm').data('id');
            
            $.ajax({
                url: `http://127.0.0.1:8000/api/produk/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Data Jasa:', response.data); // Debugging line
                    if (response.data) {
                        $('#judul').val(response.data.judul);
                        $('#deskripsi').val(response.data.deskripsi);
                        $('#durasi').val(response.data.durasi);
                        $('#kategori').val(response.data.kategori);
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error); // Debugging line
                    alert('Gagal memuat data.');
                }
            });

            $('#jasaForm').submit(function(e) {
                e.preventDefault();

                let url = `http://127.0.0.1:8000/api/produk/${id}`;
                let method = 'PUT';

                $.ajax({
                    url: url,
                    type: method,
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Data berhasil disimpan!');
                        window.location.href = '/produk';
                    },
                    error: function(xhr) {
                        alert('Gagal menyimpan data.');
                    }
                });
            });
        });
    </script>
</body>

</html>
