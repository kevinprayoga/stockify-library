<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="stylesheet" href="/css/app.css">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!--
              Icon when menu is closed.

              Menu open: "hidden", Menu closed: "block"
            -->
            <svg id="mobile-closed" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!--
              Icon when menu is open.

              Menu open: "block", Menu closed: "hidden"
            -->
            <svg id="mobile-open" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div id="navbar-main" class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <button type="button" id="navbar-logo" class="flex flex-shrink-0 items-center hover:bg-gray-700">
            <a href="/">
              <img class="h-8 w-auto" src="/image/logo.png" alt="Your Company">
            </a>
          </button>
          <div id="navbar-main" class="hidden sm:ml-6 sm:block">
            <div id="navbar-list" class="flex space-x-4">
              <?php
              $current_page = basename($_SERVER['PHP_SELF']);
              ?>

              <a href="/booklist" class="navbar-dropdown rounded-md px-3 py-2 text-sm font-medium <?= $current_page == 'booklist' || $current_page == 'addBooklist' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Booklist</a>
              <?php if (session()->get('role') === 'Admin') : ?>
                <a href="/category" class="navbar-dropdown rounded-md px-3 py-2 text-sm font-medium <?= $current_page == 'category' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?>">Category</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div id="nav-additional" class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <!-- Profile dropdown -->
          <div id="nav-profile" class="relative ml-3">
            <div>
              <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full" src="/image/cat.jpeg" alt="profile-picture">
              </button>
            </div>
            <div id="nav-prof-list" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <a href="<?= base_url('/logout'); ?>" class="block hover:bg-gray-100 px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <a href="/booklist" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Booklist</a>
        <a href="/category" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Category</a>
      </div>
    </div>
  </nav>

  <script>
    function toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
      if (mobileMenu.classList.contains('hidden')) {
        document.getElementById('mobile-open').classList.remove('block');
        document.getElementById('mobile-open').classList.add('hidden');
        document.getElementById('mobile-closed').classList.remove('hidden');
        document.getElementById('mobile-closed').classList.add('block');
      } else {
        document.getElementById('mobile-closed').classList.remove('block');
        document.getElementById('mobile-closed').classList.add('hidden');
        document.getElementById('mobile-open').classList.remove('hidden');
        document.getElementById('mobile-open').classList.add('block');
      }
    }

    document.getElementById('user-menu-button').addEventListener('click', function() {
      const dropdownMenu = document.getElementById('nav-prof-list');
      if (dropdownMenu.classList.contains('hidden')) {
        // Transition for entering
        dropdownMenu.classList.remove('hidden');
        dropdownMenu.classList.remove('opacity-0', 'scale-95');
        dropdownMenu.classList.add('opacity-100', 'scale-100');
      } else {
        // Transition for leaving
        dropdownMenu.classList.add('opacity-0', 'scale-95');
        dropdownMenu.classList.remove('opacity-100', 'scale-100');

        // After the transition duration, hide the dropdown
        setTimeout(() => {
            dropdownMenu.classList.add('hidden');
        }, 75); // Match this duration with the leaving transition duration
      }
    });

    window.onclick = function(event) {
      const dropdownMenu = document.getElementById('nav-prof-list');
      const userMenuButton = document.getElementById('user-menu-button');

      if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
        if (!dropdownMenu.classList.contains('hidden')) {
          dropdownMenu.classList.add('opacity-0', 'scale-95');
          dropdownMenu.classList.remove('opacity-100', 'scale-100');
          setTimeout(() => {
            dropdownMenu.classList.add('hidden');
          }, 75);
        }
      }
    };
  </script>

  <main class="flex-grow container mx-auto py-10 px-6">
    <?= $this->renderSection('content'); ?>
  </main>

</body>

<footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://kevinprayoga-website.vercel.app/" class="hover:underline">Stockify</a>. All Rights Reserved.
    </span>
    <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
      <li>
        <a href="#" class="hover:underline me-4 md:me-6">About</a>
      </li>
      <li>
        <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
      </li>
      <li>
        <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
      </li>
      <li>
        <a href="#" class="hover:underline">Contact</a>
      </li>
    </ul>
    </div>
</footer>
</html>