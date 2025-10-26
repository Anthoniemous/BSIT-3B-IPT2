document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('user-dropdown-btn');
    const menu = document.getElementById('user-dropdown-menu');
    const wrapper = document.getElementById('user-dropdown-wrapper');

    btn.addEventListener('click', function (e) {
      e.stopPropagation(); 
      const isHidden = menu.classList.contains('hidden');
      if (isHidden) {
        openMenu();
      } else {
        closeMenu();
      }
    });

    menu.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    document.addEventListener('click', function () {
      closeMenu();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMenu();
    });

    function openMenu() {
      menu.classList.remove('hidden');
      btn.setAttribute('aria-expanded', 'true');
      const firstLink = menu.querySelector('a');
      if (firstLink) firstLink.focus();
    }

    function closeMenu() {
      if (!menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
      }
    }
  });