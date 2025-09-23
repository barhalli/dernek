// Basit bildirim kapatma
window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-close]').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.closest('[data-alert]');
      if (target) {
        target.remove();
      }
    });
  });
});
