// Hiệu ứng cho thẻ card hoặc thông báo
document.addEventListener('DOMContentLoaded', function () {
  const cards = document.querySelectorAll('.card');

  cards.forEach(card => {
    card.addEventListener('mouseover', () => card.classList.add('shadow-lg'));
    card.addEventListener('mouseout', () => card.classList.remove('shadow-lg'));
  });
});
