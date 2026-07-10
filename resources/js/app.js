import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Cart store using Alpine
Alpine.store('cart', {
    items: JSON.parse(localStorage.getItem('cart_items') || '[]'),
    
    get count() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    },
    
    get total() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },

    addItem(menu) {
        const existing = this.items.find(item => item.id === menu.id && item.notes === (menu.notes || ''));
        if (existing) {
            existing.quantity++;
        } else {
            this.items.push({
                id: menu.id,
                name: menu.name,
                price: menu.price,
                quantity: 1,
                notes: menu.notes || '',
                image: menu.image || '',
            });
        }
        this.save();
    },

    removeItem(index) {
        this.items.splice(index, 1);
        this.save();
    },

    updateQuantity(index, qty) {
        if (qty <= 0) {
            this.removeItem(index);
        } else {
            this.items[index].quantity = qty;
            this.save();
        }
    },

    clear() {
        this.items = [];
        this.save();
    },

    save() {
        localStorage.setItem('cart_items', JSON.stringify(this.items));
    },

    formatPrice(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }
});

// Notification sound for staff
Alpine.store('notification', {
    audio: null,
    
    init() {
        this.audio = new Audio('/sounds/notification.mp3');
    },
    
    play() {
        if (this.audio) {
            this.audio.play().catch(() => {});
        }
    }
});

Alpine.start();
