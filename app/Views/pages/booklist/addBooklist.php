<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-lg">
    <a href="<?= base_url('booklist'); ?>" class="text-indigo-600 hover:text-indigo-700 flex">
      <svg class="w-6 h-6 mb-3 -ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Back
    </a>
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Book</h2>
    <form id="bookForm" enctype="multipart/form-data" action="<?= base_url('booklist/storeBooklist'); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="mb-4">
        <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
        <input type="text" id="judul" name="judul" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
        <div class="relative inline-block text-left w-full">
          <button id="filterButton" class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Filter
            <svg id="icon-open" class="-mr-1 ml-2 h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M19 15l-7-7-7 7" />
            </svg>
            <svg id="icon-closed" class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <input type="hidden" id="kategori" name="kategori">
          <div id="filterDropdown" class="hidden origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="filterButton">
              <?php if (empty($categories)): ?>
                  <p class="text-gray-600">No categories available.</p>
              <?php else: ?>
                <?php foreach ($categories as $category): ?>
                  <p class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-category="<?= esc($category['id']); ?>" onclick="activeLink(this)"><?= esc($category['name']); ?></>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
      <div class="mb-4">
        <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
        <textarea id="deskripsi" name="deskripsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3" required></textarea>
      </div>
      <div class="mb-4">
        <label for="jumlah" class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
        <input type="number" id="jumlah" name="jumlah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="fileBuku" class="block text-gray-700 text-sm font-bold mb-2">Upload File (PDF):</label>
        <input type="file" id="fileBuku" name="fileBuku" accept="application/pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-6">
        <label for="coverBuku" class="block text-gray-700 text-sm font-bold mb-2">Upload Books's Cover (jpeg/jpg/png):</label>
        <input type="file" id="coverBuku" name="coverBuku" accept="image/jpeg, image/png, image/jpg" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="flex items-center justify-between">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline">
          Add Book
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Pop-up HTML -->
<div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="relative bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
    <button onclick="closePopup()" class="absolute top-0 right-0 mt-2 mr-2 text-gray-500 hover:text-gray-700">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
    <div id="popup-icon" class="mb-4">
      <!-- Icon akan diisi melalui JavaScript -->
    </div>
    <h3 id="popup-message" class="text-lg font-bold mt-10 text-gray-800"></h3>
  </div>
</div>

<script>
  document.getElementById('bookForm').addEventListener('submit', function(event) {
    // Logika untuk menangani pengiriman formulir bisa dimasukkan di sini
  });

  // JavaScript untuk Dropdown Filter
  document.getElementById('filterButton').addEventListener('click', function() {
    const dropdown = document.getElementById('filterDropdown');
    const iconOpen = document.getElementById('icon-open');
    const iconClosed = document.getElementById('icon-closed');

    dropdown.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClosed.classList.toggle('hidden');
  });

  function activeLink(element) {
    const links = document.querySelectorAll('.filter-option');
    links.forEach(item => {
      item.classList.remove('bg-gray-100', 'text-indigo-600');
    });
    element.classList.add('bg-gray-100', 'text-indigo-600');

    // Set nilai kategori yang dipilih ke input tersembunyi
    document.getElementById('kategori').value = element.getAttribute('data-category');

    // Mengubah teks tombol sesuai dengan pilihan dropdown
    const filterButton = document.getElementById('filterButton');
    filterButton.childNodes[0].nodeValue = element.innerText + " "; // Update text, retain the space for the icon
  }

  // Menutup dropdown ketika mengklik di luar dropdown
  window.onclick = function(event) {
    if (!event.target.matches('#filterButton')) {
      const dropdown = document.getElementById('filterDropdown');
      const iconOpen = document.getElementById('icon-open');
      const iconClosed = document.getElementById('icon-closed');

      if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
        iconOpen.classList.add('hidden');
        iconClosed.classList.remove('hidden');
        iconClosed.classList.add('block');
      }
    }
  };
  <?php if (session()->getFlashdata('success')): ?>
    document.getElementById('popup-icon').innerHTML = `
      <svg class="w-32 h-32 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
    `;
    document.getElementById('popup-message').innerText = '<?= session()->getFlashdata('success'); ?>';
    document.getElementById('popup').classList.remove('hidden');
  <?php elseif (session()->getFlashdata('error')): ?>
    document.getElementById('popup-icon').innerHTML = `
      <svg class="w-32 h-32 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    `;
    document.getElementById('popup-message').innerText = '<?= session()->getFlashdata('error'); ?>';
    document.getElementById('popup').classList.remove('hidden');
  <?php endif; ?>

  function closePopup() {
    document.getElementById('popup').classList.add('hidden');
  }
</script>
<?= $this->endSection(); ?>