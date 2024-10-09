<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <a href="<?= base_url('booklist'); ?>" class="text-indigo-600 hover:text-indigo-700 flex">
      <svg class="w-6 h-6 mb-3 -ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Back
    </a>
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-3xl font-bold text-gray-800"><?= esc($book['title']); ?></h2>
      <div class="space-x-4">
        <button onclick="editBook('<?= esc($book['id']); ?>')" class="text-indigo-600 border border-indigo-600 hover:bg-gray-100 font-bold py-2 px-4 rounded">Modify</button>
        <button onclick="confirmDeleteBook('<?= esc($book['id']); ?>')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="col-span-1">
        <?php if($cover): ?>
          <img src="<?= base_url('cover/' . $cover['name']); ?>" alt="Cover Buku" class="rounded-lg shadow-md w-full">
        <?php else: ?>
          <img src="<?= base_url('images/default_cover.jpeg'); ?>" alt="Cover Buku" class="rounded-lg shadow-md w-full">
        <?php endif; ?>
      </div>
      <div class="col-span-2">
        <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= esc($book['title']); ?></h3>
        <p class="text-gray-600 mb-4"><span class="font-semibold">Category:</span> <?= esc($book['category']); ?></p>
        <p class="text-gray-600 mb-4"><span class="font-semibold">Description:</span> <?= esc($book['description']); ?></p>
        <p class="text-gray-600 mb-4"><span class="font-semibold">Stock:</span> <?= esc($book['stock']); ?> Eksemplar</p>
        <?php if($file): ?>
          <button onclick="exportPDF('<?= esc($file['name']); ?>')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mt-4">Download PDF</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteBookModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold text-gray-800">Delete Book</h3>
      <button onclick="closeDeleteBookModal()" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <p class="text-gray-600 mb-6">Are you sure you want to delete this book?</p>
    <form id="deleteBookForm" action="delete/<?= esc($book['id']); ?>" method="POST">
      <?= csrf_field(); ?>
      <input type="hidden" id="deleteBookId" name="book_id">
      <div class="flex justify-end">
        <button type="button" onclick="closeDeleteBookModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded mr-2">Cancel</button>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-7 rounded">Yes</button>
      </div>
    </form>
  </div>
</div>

<script>
  function confirmDeleteBook(id) {
    document.getElementById('deleteBookId').value = id;
    document.getElementById('deleteBookModal').classList.remove('hidden');
  }

  function closeDeleteBookModal() {
    document.getElementById('deleteBookModal').classList.add('hidden');
  }

  function exportPDF(file) {
    window.location.href = '<?= base_url('booklist/download'); ?>/' + file;
  }

  function editBook(id) {
    window.location.href = '<?= base_url('booklist'); ?>/' + id + '/edit';
  }

  function deleteBook(id) {
    confirmDeleteBook(id);
  }
</script>
<?= $this->endSection(); ?>