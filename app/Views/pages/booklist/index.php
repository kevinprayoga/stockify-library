<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="w-full max-w-3xl mx-auto">
  <h1 class="text-3xl font-bold text-gray-800 mb-6">Booklist</h1>

  <!-- Filter Dropdown and Add Button -->
  <div class="flex justify-between mb-4">
    <div class="relative inline-block text-left">
      <button id="filterButton" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Filter
        <svg id="icon-open" class="-mr-1 ml-2 h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M19 15l-7-7-7 7" />
        </svg>
        <svg id="icon-closed" class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Dropdown Menu -->
      <div id="filterDropdown" class="hidden origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="filterButton">
          <a href="#" class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-category="all" onclick="activeLink(this)">All</a>
          <?php if (empty($categories)): ?>
            <p class="text-gray-600">No categories available.</p>
          <?php else: ?>
            <?php foreach ($categories as $category): ?>
              <a href="#" class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" data-category="<?= esc($category['id']); ?>" onclick="activeLink(this)"><?= esc($category['name']); ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <button id="addBookButton" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Add New Book
    </button>
  </div>

  <!-- Daftar Buku -->
  <div id="bookList" class="space-y-4">
    <?php if (empty($books)): ?>
      <p class="text-gray-600">No books available.</p>
    <?php else: ?>
      <?php foreach ($books as $book): ?>
        <div class="book-item bg-white p-4 rounded-lg shadow-md" data-category="<?= esc($book['category_id']); ?>">
          <a href="/booklist/<?= esc($book['id']); ?>">
            <h2 class="text-xl font-bold text-gray-800"><?= esc($book['title']); ?></h2>
            <p class="text-gray-600"><?= esc($book['description']); ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<script>
// JavaScript untuk Dropdown Filter
document.getElementById('filterButton').addEventListener('click', function() {
  const dropdown = document.getElementById('filterDropdown');
  const iconOpen = document.getElementById('icon-open');
  const iconClosed = document.getElementById('icon-closed');

  dropdown.classList.toggle('hidden');
  iconOpen.classList.toggle('hidden');
  iconClosed.classList.toggle('hidden');
});

// JavaScript untuk Memfilter Daftar Buku
document.querySelectorAll('.filter-option').forEach(option => {
  option.addEventListener('click', function(event) {
    event.preventDefault();
    const selectedCategory = this.getAttribute('data-category');
    const books = document.querySelectorAll('.book-item');

    books.forEach(book => {
      if (selectedCategory === 'all' || book.getAttribute('data-category') === selectedCategory) {
        book.style.display = 'block';
      } else {
        book.style.display = 'none';
      }
    });

    // Close the dropdown after selection
    document.getElementById('filterDropdown').classList.add('hidden');
  });
});

// JavaScript untuk Tombol Tambah Buku Baru
document.getElementById('addBookButton').addEventListener('click', function() {
  window.location.href = '/booklist/addBooklist';
});

function activeLink(element) {
  const links = document.querySelectorAll('.filter-option');
  links.forEach(item => {
    item.classList.remove('bg-gray-100', 'text-indigo-600');
  });
  element.classList.add('bg-gray-100', 'text-indigo-600');

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
</script>
<?= $this->endSection(); ?>