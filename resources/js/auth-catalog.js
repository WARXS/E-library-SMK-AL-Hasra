document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.passwordToggle);
        if (!input) return;

        const shouldReveal = input.type === 'password';
        input.type = shouldReveal ? 'text' : 'password';
        button.textContent = shouldReveal ? 'Sembunyikan' : 'Tampilkan';
        button.setAttribute('aria-pressed', String(shouldReveal));
        button.setAttribute('aria-label', `${shouldReveal ? 'Sembunyikan' : 'Tampilkan'} password`);
    });
});

document.querySelectorAll('[data-loading-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('[data-submit-label]');
        if (!button) return;

        button.disabled = true;
        button.textContent = button.dataset.loadingLabel || 'Memproses…';
    });
});

const catalog = document.querySelector('[data-catalog]');

if (catalog) {
    const search = catalog.querySelector('[data-catalog-search]');
    const cards = [...catalog.querySelectorAll('[data-book-card]')];
    const filterButtons = [...catalog.querySelectorAll('[data-publisher-filter]')];
    const resultCount = catalog.querySelector('[data-result-count]');
    const emptyState = catalog.querySelector('[data-catalog-empty]');
    const filterSidebar = catalog.querySelector('[data-filter-sidebar]');
    const filterToggle = catalog.querySelector('[data-filter-toggle]');
    let activePublisher = '';

    const normalize = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('id');

    const updateResults = () => {
        const query = normalize(search?.value.trim() || '');
        let visibleCount = 0;

        cards.forEach((card) => {
            const matchesPublisher = !activePublisher || card.dataset.publisher === activePublisher;
            const matchesSearch = !query || normalize(card.dataset.search || '').includes(query);
            const isVisible = matchesPublisher && matchesSearch;
            card.hidden = !isVisible;

            if (isVisible) {
                visibleCount += 1;
                card.classList.remove('book-card--filtered-in');
                requestAnimationFrame(() => card.classList.add('book-card--filtered-in'));
            }
        });

        if (resultCount) {
            resultCount.textContent = `${visibleCount} buku ditemukan`;
        }

        emptyState?.classList.toggle('is-visible', visibleCount === 0);
        filterButtons.forEach((button) => {
            button.setAttribute('aria-pressed', String(button.dataset.publisherFilter === activePublisher));
        });
    };

    search?.addEventListener('input', updateResults);

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            activePublisher = button.dataset.publisherFilter || '';
            updateResults();

            if (filterSidebar && window.matchMedia('(max-width: 760px)').matches) {
                filterSidebar.classList.remove('is-open');
                filterToggle?.setAttribute('aria-expanded', 'false');
            }
        });
    });

    filterToggle?.addEventListener('click', () => {
        const isOpen = filterSidebar?.classList.toggle('is-open') ?? false;
        filterToggle.setAttribute('aria-expanded', String(isOpen));
    });

    updateResults();
}
