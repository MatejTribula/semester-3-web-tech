document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('sortMostFavorited');
    if (!btn) return;
  
    // Find the card section this button belongs to, then its card-container
    const section = btn.closest('.card-section') || document;
    const container = section.querySelector('.card-container');
    if (!container) return;
  
    // Next sort direction (label shows what clicking will do)
    let nextSort = 'desc';
    btn.textContent = 'Sort by Most Favorited';
  
    btn.addEventListener('click', (e) => {
      e.preventDefault();
  
      const cards = Array.from(container.querySelectorAll('a.card'));
      if (cards.length === 0) return;
  
      const desc = nextSort === 'desc';
  
      cards.sort((a, b) => {
        const aCount = parseInt(a.dataset.favcount || '0', 10);
        const bCount = parseInt(b.dataset.favcount || '0', 10);
        return desc ? (bCount - aCount) : (aCount - bCount);
      });
  
      // Efficient re-append (won’t “lose” nodes)
      const frag = document.createDocumentFragment();
      cards.forEach(card => frag.appendChild(card));
      container.appendChild(frag);
  
      nextSort = desc ? 'asc' : 'desc';
      btn.textContent = nextSort === 'desc'
        ? 'Sort by Most Favorited'
        : 'Sort by Least Favorited';
    });
  });