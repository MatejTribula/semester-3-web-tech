document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.tag-button');
    const cards   = document.querySelectorAll('.card[data-tags]');

    if (!buttons.length || !cards.length) return;

    // set of currently selected tags
    const selectedTags = new Set();

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const tag = btn.dataset.tag;

            // toggle tag state by clicking
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                selectedTags.delete(tag);
            } else {
                btn.classList.add('active');
                selectedTags.add(tag);
            }

            // apply filtering
            filterCards(cards, selectedTags);
        });
    });
});

function filterCards(cards, selectedTags) {
    // if no tags are selected, shows everything
    if (selectedTags.size === 0) {
        cards.forEach(card => {
            card.style.display = '';
        });
        return;
    }

    cards.forEach(card => {
        const raw = card.dataset.tags || '';
        const cardTags = raw.split(',')
            .map(t => t.trim().toLowerCase())
            .filter(Boolean);

        // or-logic for tags. 
        const shouldShow = cardTags.some(tag => selectedTags.has(tag));

        card.style.display = shouldShow ? '' : 'none';
    });
}