<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stockify</title>
  <link rel="stylesheet" href="/css/app.css">
</head>

<body>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-20 w-auto" src="/image/logo.png" alt="Your Company">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign In to Your Account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="<?= base_url('/login/save'); ?>" method="POST">
        <?= csrf_field(); ?>
        <div>
          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
          <div class="mt-2">
            <input id="name" name="name" type="name" autocomplete="name" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Haven't registered yet?
        <a href="./register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign Up here</a>
      </p>
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
</body>
</html>