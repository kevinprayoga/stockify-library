<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-3xl font-bold text-gray-800">Edit Book Details</h2>
    </div>
    <form id="editBookForm" enctype="multipart/form-data" action="<?= base_url('booklist/update/'.$book['id']); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="col-span-1">
          <img src="<?= base_url('cover/' . $cover['name']); ?>" alt="Cover Buku" class="rounded-lg shadow-md w-full mb-4">
          <label for="coverBuku" class="block text-gray-700 text-sm font-bold mb-2">Change Cover Buku (jpeg/jpg/png):</label>
          <div class="flex items-center space-x-2">
            <input type="file" id="coverBuku" name="coverBuku" accept="image/jpeg, image/png, image/jpg" class="hidden shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            <button type="button" id="cover-button" onclick="toggleCoverUpload()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
          </div>
        </div>
        <div class="col-span-2">
          <div class="mb-4">
            <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?= esc($book['title']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
          </div>
          <div class="mb-4">
            <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori Buku:</label>
            <div class="relative inline-block text-left w-full">
              <select id="kategori" name="kategori" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <?php if (empty($categories)): ?>
                <p class="text-gray-600">No categories available.</p>
              <?php else: ?>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= esc($category['id']); ?>" <?= $book['category_id'] == $category['id'] ? 'selected' : ''; ?>><?= esc($category['name']); ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3" required><?= esc($book['description']); ?></textarea>
          </div>
          <div class="mb-4">
            <label for="jumlah" class="block text-gray-700 text-sm font-bold mb-2">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" value="<?= esc($book['stock']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
          </div>
          <div class="mb-4">
            <label for="fileBuku" class="block text-gray-700 text-sm font-bold mb-2">Upload File Buku (PDF):</label>
            <div class="flex items-center space-x-2">
              <input type="file" id="fileBuku" name="fileBuku" accept="application/pdf" class="hidden shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
              <button type="button" id="file-button" onclick="toggleFileUpload()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
            </div>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-end">
        <button type="button" onclick="cancelEdit()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-10 rounded focus:outline-none focus:shadow-outline mr-4">Cancel</button>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline">Update Book</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleCoverUpload() {
    const coverInput = document.getElementById('coverBuku');
    const coverButton = document.getElementById('cover-button');
    coverInput.classList.toggle('hidden');
    coverInput.disabled = !coverInput.disabled;
    coverButton.classList.toggle('hidden');
  }

  function toggleFileUpload() {
    const fileInput = document.getElementById('fileBuku');
    const fileButton = document.getElementById('file-button');
    fileInput.classList.toggle('hidden');
    fileInput.disabled = !fileInput.disabled;
    fileButton.classList.toggle('hidden');
  }

  function cancelEdit() {
    window.history.back();
  }

  document.getElementById('editBookForm').addEventListener('submit', function(event) {
    // Logika untuk menangani pengiriman formulir bisa dimasukkan di sini
  });
</script>
<?= $this->endSection(); ?>