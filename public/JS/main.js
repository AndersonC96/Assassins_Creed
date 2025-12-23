/**
 * Assassin's Creed Database - Global JavaScript
 * Features: Back to Top, Favorites System, Share, Loading States
 */

// ============================================
// BACK TO TOP BUTTON
// ============================================
(function initBackToTop() {
    // Create button
    const btn = document.createElement('button');
    btn.id = 'backToTop';
    btn.className = 'back-to-top';
    btn.innerHTML = '<i class="bi bi-chevron-up"></i>';
    btn.title = 'Voltar ao topo';
    btn.setAttribute('aria-label', 'Voltar ao topo');
    document.body.appendChild(btn);

    // Show/hide on scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    // Scroll to top on click
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
})();

// ============================================
// FAVORITES SYSTEM (localStorage)
// ============================================
const Favorites = {
    STORAGE_KEY: 'ac_favorites',

    getAll() {
        try {
            return JSON.parse(localStorage.getItem(this.STORAGE_KEY)) || [];
        } catch {
            return [];
        }
    },

    add(item) {
        const favorites = this.getAll();
        if (!favorites.find(f => f.id === item.id && f.type === item.type)) {
            favorites.push({
                id: item.id,
                type: item.type, // 'game', 'character', 'book'
                name: item.name,
                image: item.image || null,
                addedAt: Date.now()
            });
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(favorites));
            this.updateUI();
            this.showNotification('Adicionado aos favoritos!');
            return true;
        }
        return false;
    },

    remove(id, type) {
        let favorites = this.getAll();
        favorites = favorites.filter(f => !(f.id === id && f.type === type));
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(favorites));
        this.updateUI();
        this.showNotification('Removido dos favoritos');
    },

    toggle(item) {
        if (this.isFavorite(item.id, item.type)) {
            this.remove(item.id, item.type);
            return false;
        } else {
            this.add(item);
            return true;
        }
    },

    isFavorite(id, type) {
        return this.getAll().some(f => f.id === id && f.type === type);
    },

    getCount() {
        return this.getAll().length;
    },

    updateUI() {
        // Update all favorite buttons
        document.querySelectorAll('[data-favorite-id]').forEach(btn => {
            const id = btn.dataset.favoriteId;
            const type = btn.dataset.favoriteType;
            if (this.isFavorite(id, type)) {
                btn.classList.add('is-favorite');
                btn.querySelector('i')?.classList.replace('bi-heart', 'bi-heart-fill');
            } else {
                btn.classList.remove('is-favorite');
                btn.querySelector('i')?.classList.replace('bi-heart-fill', 'bi-heart');
            }
        });

        // Update counter badge
        const counter = document.getElementById('favoritesCount');
        if (counter) {
            const count = this.getCount();
            counter.textContent = count;
            counter.style.display = count > 0 ? 'inline-flex' : 'none';
        }
    },

    showNotification(message) {
        // Remove existing notifications
        document.querySelectorAll('.fav-notification').forEach(n => n.remove());

        const notification = document.createElement('div');
        notification.className = 'fav-notification';
        notification.innerHTML = `<i class="bi bi-heart-fill"></i> ${message}`;
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => notification.classList.add('show'), 10);

        // Remove after 2 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    },

    init() {
        this.updateUI();
        
        // Add click handlers to favorite buttons
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-favorite-id]');
            if (btn) {
                e.preventDefault();
                const item = {
                    id: btn.dataset.favoriteId,
                    type: btn.dataset.favoriteType,
                    name: btn.dataset.favoriteName,
                    image: btn.dataset.favoriteImage
                };
                this.toggle(item);
            }
        });
    }
};

// Initialize favorites
document.addEventListener('DOMContentLoaded', () => Favorites.init());

// ============================================
// SHARE FUNCTIONALITY
// ============================================
const Share = {
    platforms: {
        twitter: (url, text) => 
            `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`,
        facebook: (url) => 
            `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
        whatsapp: (url, text) => 
            `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`,
        telegram: (url, text) => 
            `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`,
        linkedin: (url) => 
            `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`
    },

    async native(title, text, url) {
        if (navigator.share) {
            try {
                await navigator.share({ title, text, url });
                return true;
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error('Share failed:', err);
                }
            }
        }
        return false;
    },

    open(platform, url, text = '') {
        const shareUrl = this.platforms[platform]?.(url || window.location.href, text);
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    },

    copyLink(url) {
        const link = url || window.location.href;
        navigator.clipboard.writeText(link).then(() => {
            this.showCopiedNotification();
        });
    },

    showCopiedNotification() {
        const notification = document.createElement('div');
        notification.className = 'share-notification';
        notification.innerHTML = '<i class="bi bi-check-circle"></i> Link copiado!';
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
};

// ============================================
// LOADING SKELETON
// ============================================
const Skeleton = {
    create(type = 'card') {
        const skeleton = document.createElement('div');
        skeleton.className = `skeleton skeleton-${type}`;
        
        if (type === 'card') {
            skeleton.innerHTML = `
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line" style="width: 80%"></div>
                    <div class="skeleton-line" style="width: 60%"></div>
                    <div class="skeleton-line" style="width: 90%"></div>
                </div>
            `;
        }
        
        return skeleton;
    },

    showIn(container, count = 6) {
        for (let i = 0; i < count; i++) {
            container.appendChild(this.create('card'));
        }
    },

    removeFrom(container) {
        container.querySelectorAll('.skeleton').forEach(s => s.remove());
    }
};

// ============================================
// KEYBOARD SHORTCUTS
// ============================================
document.addEventListener('keydown', (e) => {
    // Don't trigger if typing in input
    if (e.target.matches('input, textarea, select')) return;

    // / - Focus search
    if (e.key === '/') {
        e.preventDefault();
        document.querySelector('#searchInput, .search-input')?.focus();
    }

    // Home - Go to homepage
    if (e.key === 'Home' && e.ctrlKey) {
        e.preventDefault();
        window.location.href = 'index.php';
    }

    // Escape - Clear search
    if (e.key === 'Escape') {
        const searchInput = document.querySelector('#searchInput, .search-input');
        if (searchInput && document.activeElement === searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.blur();
        }
    }
});

// ============================================
// BREADCRUMBS
// ============================================
const Breadcrumbs = {
    container: null,

    init() {
        this.container = document.getElementById('breadcrumbs');
        if (!this.container) return;
        
        // Auto-generate from current page
        const path = window.location.pathname;
        const pageName = path.split('/').pop().replace('.php', '');
        
        const crumbs = [
            { name: 'Home', url: 'index.php' }
        ];
        
        // Add current page if not home
        if (pageName && pageName !== 'index') {
            const pageNames = {
                'jogos': 'Jogos',
                'game_details': 'Detalhes do Jogo',
                'personagens': 'Personagens',
                'timeline': 'Timeline',
                'livros': 'Livros & Mídia',
                '404': 'Página Não Encontrada'
            };
            crumbs.push({
                name: pageNames[pageName] || pageName,
                url: null // Current page
            });
        }
        
        this.render(crumbs);
    },

    render(crumbs) {
        if (!this.container) return;
        
        this.container.innerHTML = crumbs.map((crumb, i) => {
            const isLast = i === crumbs.length - 1;
            if (isLast) {
                return `<span class="breadcrumb-current">${crumb.name}</span>`;
            }
            return `<a href="${crumb.url}" class="breadcrumb-link">${crumb.name}</a>
                    <i class="bi bi-chevron-right breadcrumb-separator"></i>`;
        }).join('');
    }
};

// Initialize breadcrumbs
document.addEventListener('DOMContentLoaded', () => Breadcrumbs.init());

// ============================================
// UTILITY FUNCTIONS
// ============================================
const Utils = {
    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Format date
    formatDate(timestamp, locale = 'pt-BR') {
        return new Date(timestamp * 1000).toLocaleDateString(locale, {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    },

    // Truncate text
    truncate(str, length = 100) {
        if (str.length <= length) return str;
        return str.substring(0, length).trim() + '...';
    }
};

// Export for use in other scripts
window.ACDatabase = {
    Favorites,
    Share,
    Skeleton,
    Breadcrumbs,
    Utils
};

console.log('🦅 Assassin\'s Creed Database initialized');
