<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang di Digital Perpustakaan Stockify</h1>
    <p class="text-gray-700 leading-relaxed mb-4">
        Website ini adalah sebuah platform Digital Perpustakaan berbasis website yang bertujuan untuk mempermudah pengelolaan dan akses buku secara online. Platform ini dilengkapi dengan berbagai fitur yang mempermudah pengguna untuk mengelola dan mencari buku sesuai dengan kebutuhan mereka.
    </p>
    <h2 class="text-2xl font-semibold text-gray-800 mt-6 mb-4">Fitur Utama:</h2>
    <ul class="list-disc pl-5 text-gray-700">
        <li><strong>Login dan Register:</strong> Pengguna dapat mendaftar dan masuk sebagai Admin atau User untuk mengelola konten perpustakaan.</li>
        <li><strong>Daftar/List Data Buku:</strong> Menampilkan daftar buku yang tersedia dengan fitur filter berdasarkan kategori.</li>
        <li><strong>Manajemen Data Buku:</strong> Admin dapat melakukan tindakan Create, Read, Update, Delete (CRUD) dan mengunggah file buku (PDF) serta cover buku (jpeg/jpg/png).</li>
        <li><strong>Manajemen Kategori Buku:</strong> Fitur untuk menambah, mengedit, dan menghapus kategori buku.</li>
        <li><strong>Export Data:</strong> Pengguna dapat mengekspor daftar buku ke format Excel atau PDF untuk kemudahan pengelolaan offline.</li>
        <li><strong>Hak Akses:</strong> Hak akses yang dibatasi sesuai dengan peran pengguna, seperti admin atau user biasa.</li>
    </ul>
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