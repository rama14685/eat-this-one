<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eat This One - Interactive Menu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800" x-data="cartApp()">
    
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-orange-600">Eat This One</h1>
            <button @click="cartOpen = true" class="relative flex items-center p-2 text-gray-600 hover:text-orange-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span x-show="totalItems > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full" x-text="totalItems"></span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ currentCategory: 'all' }">
        
        <!-- Category Filter -->
        <div class="flex space-x-2 overflow-x-auto pb-4 mb-6">
            <button @click="currentCategory = 'all'" :class="{'bg-orange-600 text-white': currentCategory === 'all', 'bg-white text-gray-700 hover:bg-gray-100': currentCategory !== 'all'}" class="px-4 py-2 rounded-full font-medium whitespace-nowrap shadow-sm transition">Semua</button>
            @foreach($categories as $category)
                <button @click="currentCategory = '{{ $category->id }}'" :class="{'bg-orange-600 text-white': currentCategory === '{{ $category->id }}', 'bg-white text-gray-700 hover:bg-gray-100': currentCategory !== '{{ $category->id }}'}" class="px-4 py-2 rounded-full font-medium whitespace-nowrap shadow-sm transition">{{ $category->name }}</button>
            @endforeach
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div x-show="currentCategory === 'all' || currentCategory === '{{ $product->category_id }}'" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">
                    <div class="relative cursor-pointer h-48 bg-gray-200" @click="openModal({{ $product }})">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        
                        @if($product->badge)
                            <span class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">{{ $product->badge }}</span>
                        @endif
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 cursor-pointer hover:text-orange-600" @click="openModal({{ $product }})">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-auto flex items-center justify-between">
                            <span class="text-lg font-bold text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->stock > 0)
                                <button @click="addToCart({{ $product }})" class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition">
                                    + Keranjang
                                </button>
                            @else
                                <span class="bg-gray-300 text-gray-600 px-3 py-1.5 rounded-lg text-sm font-medium">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </main>

    <!-- Product Modal -->
    <div x-cloak x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="modalOpen = false"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="modalOpen" x-transition.scale class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white">
                    <div class="relative h-64 bg-gray-200">
                        <template x-if="selectedProduct?.image">
                            <img :src="selectedProduct.image" :alt="selectedProduct.name" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!selectedProduct?.image">
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        </template>
                        <button @click="modalOpen = false" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow hover:bg-gray-100">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2" x-text="selectedProduct?.name"></h3>
                        <p class="text-xl font-bold text-orange-600 mb-4" x-text="selectedProduct ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedProduct.price) : ''"></p>
                        
                        <p class="text-gray-600 mb-4" x-text="selectedProduct?.full_description || selectedProduct?.description"></p>
                        
                        <div class="bg-gray-50 rounded-lg p-3 mb-4 space-y-2 text-sm">
                            <template x-if="selectedProduct?.size">
                                <div class="flex justify-between"><span class="text-gray-500">Ukuran:</span> <span class="font-medium text-gray-900" x-text="selectedProduct.size"></span></div>
                            </template>
                            <template x-if="selectedProduct?.thickness">
                                <div class="flex justify-between"><span class="text-gray-500">Ketebalan:</span> <span class="font-medium text-gray-900" x-text="selectedProduct.thickness"></span></div>
                            </template>
                            <template x-if="selectedProduct?.topping">
                                <div class="flex justify-between"><span class="text-gray-500">Topping:</span> <span class="font-medium text-gray-900" x-text="selectedProduct.topping"></span></div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <template x-if="selectedProduct && selectedProduct.stock > 0">
                        <button @click="addToCart(selectedProduct); modalOpen = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            + Tambah ke Keranjang
                        </button>
                    </template>
                    <template x-if="!selectedProduct || selectedProduct.stock <= 0">
                        <button disabled type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-300 text-base font-medium text-gray-600 sm:ml-3 sm:w-auto sm:text-sm cursor-not-allowed">
                            Habis
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide-over Cart -->
    <div x-cloak x-show="cartOpen" class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="cartOpen" x-transition.opacity class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="cartOpen = false"></div>
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="cartOpen" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto py-6 px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Keranjang Belanja</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button @click="cartOpen = false" type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <template x-for="item in cart" :key="item.id">
                                            <li class="flex py-6">
                                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100">
                                                    <template x-if="item.image">
                                                        <img :src="item.image" :alt="item.name" class="h-full w-full object-cover object-center">
                                                    </template>
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3 x-text="item.name"></h3>
                                                            <p class="ml-4" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(item.price * item.quantity)"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm mt-4">
                                                        <div class="flex items-center border rounded">
                                                            <button @click="updateQuantity(item.id, item.quantity - 1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                            <span class="px-4 py-1 border-x" x-text="item.quantity"></span>
                                                            <button @click="updateQuantity(item.id, item.quantity + 1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                                        </div>

                                                        <div class="flex">
                                                            <button @click="removeFromCart(item.id)" type="button" class="font-medium text-red-600 hover:text-red-500">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                        <template x-if="cart.length === 0">
                                            <p class="text-gray-500 text-center py-8">Keranjang Anda masih kosong.</p>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                                <p>Total Bayar</p>
                                <p x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice)"></p>
                            </div>
                            
                            <template x-if="cart.length > 0">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <input type="text" x-model="customer.name" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="Nama Anda">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                                        <input type="text" x-model="customer.phone" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="08xxxxxxxxxx">
                                    </div>
                                    <button @click="checkout()" :disabled="!customer.name || !customer.phone" class="mt-4 flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                        Pesan via WhatsApp
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js logic -->
    <script>
        function cartApp() {
            return {
                cartOpen: false,
                modalOpen: false,
                selectedProduct: null,
                cart: [],
                customer: {
                    name: '',
                    phone: ''
                },
                
                openModal(product) {
                    this.selectedProduct = product;
                    this.modalOpen = true;
                },
                
                addToCart(product) {
                    let existing = this.cart.find(item => item.id === product.id);
                    if (existing) {
                        if (existing.quantity < product.stock) {
                            existing.quantity++;
                        } else {
                            alert('Maksimal stok tercapai');
                        }
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            image: product.image,
                            quantity: 1,
                            stock: product.stock
                        });
                    }
                    this.cartOpen = true;
                },
                
                updateQuantity(id, newQuantity) {
                    if (newQuantity <= 0) {
                        this.removeFromCart(id);
                        return;
                    }
                    
                    let item = this.cart.find(i => i.id === id);
                    if (item) {
                        if (newQuantity <= item.stock) {
                            item.quantity = newQuantity;
                        } else {
                            alert('Maksimal stok tercapai');
                        }
                    }
                },
                
                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                },
                
                get totalItems() {
                    return this.cart.reduce((total, item) => total + item.quantity, 0);
                },
                
                get totalPrice() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },
                
                checkout() {
                    if (!this.customer.name || !this.customer.phone || this.cart.length === 0) return;
                    
                    let message = `Halo Eat This One,\nSaya ingin memesan:\n\n`;
                    this.cart.forEach(item => {
                        message += `- ${item.name} (${item.quantity}x) = Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}\n`;
                    });
                    
                    message += `\n*Total Bayar: Rp ${new Intl.NumberFormat('id-ID').format(this.totalPrice)}*\n\n`;
                    message += `Data Pemesan:\nNama: ${this.customer.name}\nNo WA: ${this.customer.phone}\n\nMohon info selanjutnya, terima kasih.`;
                    
                    const adminWa = "6281234567890"; 
                    
                    const url = `https://wa.me/${adminWa}?text=${encodeURIComponent(message)}`;
                    window.open(url, '_blank');
                }
            }
        }
    </script>
</body>
</html>
