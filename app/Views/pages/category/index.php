<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Manage Categories</h2>
      <button onclick="openAddCategoryModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Add Category</button>
    </div>
    <!-- Categories List -->
    <div id="categoriesList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php if (empty($categories)): ?>
        <p class="text-gray-600">No categories available.</p>
      <?php else: ?>
        <?php foreach ($categories as $category): ?>
          <div class="bg-gray-200 p-4 rounded-lg shadow flex justify-between items-center">
            <h4 class="text-xl font-bold text-gray-800"><?= esc($category['name']); ?></h4>
            <div class="space-x-2 flex items-center">
              <button onclick="openEditCategoryModal('<?= esc($category['id']); ?>', '<?= esc($category['name']); ?>')" class="text-indigo-600 hover:text-blue-700">
                <svg class="feather feather-edit" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
              </button>
              <button onclick="confirmDeleteCategory('<?= esc($category['id']); ?>')" class="text-red-600 hover:text-red-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold text-gray-800">Add New Category</h3>
      <button onclick="closeAddCategoryModal()" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <form id="addCategoryForm" action="<?= base_url('/category/add'); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="mb-4">
        <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-4">Category Name</label>
        <input type="text" id="categoryName" name="category_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-2" required>
      </div>
      <div class="flex justify-end">
        <button type="button" onclick="closeAddCategoryModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded mr-2">Cancel</button>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-7 rounded">Add</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold text-gray-800">Edit Category</h3>
      <button onclick="closeEditCategoryModal()" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <form id="editCategoryForm" action="<?= base_url('/category/edit'); ?>" method="POST">
      <?= csrf_field(); ?>
      <input type="hidden" id="editCategoryId" name="category_id">
      <div class="mb-4">
        <label for="editCategoryName" class="block text-sm font-medium text-gray-700 mb-4">Category Name</label>
        <input type="text" id="editCategoryName" name="category_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-2" required>
      </div>
      <div class="flex justify-end">
        <button type="button" onclick="closeEditCategoryModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded mr-2">Cancel</button>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-7 rounded">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold text-gray-800">Delete Category</h3>
      <button onclick="closeDeleteCategoryModal()" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <p class="text-gray-600 mb-6">Are you sure you want to delete this category?</p>
    <form id="deleteCategoryForm" action="<?= base_url('/category/delete'); ?>" method="POST">
      <?= csrf_field(); ?>
      <input type="hidden" id="deleteCategoryId" name="category_id">
      <div class="flex justify-end">
        <button type="button" onclick="closeDeleteCategoryModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded mr-2">Cancel</button>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-7 rounded">Yes</button>
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

<!-- JavaScript to handle category operations -->
<script>
  function openAddCategoryModal() {
    document.getElementById('addCategoryModal').classList.remove('hidden');
  }

  function closeAddCategoryModal() {
    document.getElementById('categoryName').value = '';
    document.getElementById('addCategoryModal').classList.add('hidden');
  }

  function openEditCategoryModal(id, name) {
    document.getElementById('editCategoryId').value = id;
    document.getElementById('editCategoryName').value = name;
    document.getElementById('editCategoryModal').classList.remove('hidden');
  }

  function closeEditCategoryModal() {
    document.getElementById('editCategoryName').value = '';
    document.getElementById('editCategoryModal').classList.add('hidden');
  }

  function confirmDeleteCategory(id) {
    document.getElementById('deleteCategoryId').value = id;
    document.getElementById('deleteCategoryModal').classList.remove('hidden');
  }

  function closeDeleteCategoryModal() {
    document.getElementById('deleteCategoryModal').classList.add('hidden');
  }

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