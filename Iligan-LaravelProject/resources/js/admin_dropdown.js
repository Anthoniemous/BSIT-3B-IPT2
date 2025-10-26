
    document.getElementById('productsDropdownBtn').addEventListener('click', () => {
      const menu = document.getElementById('productsDropdown');
      const arrow = document.getElementById('productsArrow');
      menu.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
    });