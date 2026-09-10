<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eat This One - Menu</title>
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; scroll-padding-top: 7rem; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { overflow-x: hidden; }
        #home, #about, #menu, #order-guide, #contact { scroll-margin-top: 7rem; }
        .et-display { font-family: 'DM Serif Display', Georgia, serif; }
        .et-slogan { letter-spacing: .12em; }
        .et-checker { background-color: #0038FF; background-image: linear-gradient(45deg, #FFFFFF 25%, transparent 25%), linear-gradient(-45deg, #FFFFFF 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #FFFFFF 75%), linear-gradient(-45deg, transparent 75%, #FFFFFF 75%); background-position: 0 0, 0 12px, 12px -12px, -12px 0; background-size: 24px 24px; }
        .et-hero-sky { background: linear-gradient(135deg, #8ED8FF 0%, #DDF5FF 52%, #FFFFFF 100%); }
        .et-hero-grid { background-image: linear-gradient(rgb(0 56 255 / .08) 1px, transparent 1px), linear-gradient(90deg, rgb(0 56 255 / .08) 1px, transparent 1px); background-size: 28px 28px; }
        .et-sticker { transform: rotate(-8deg); box-shadow: 7px 8px 0 #0B1A3A; }
        .et-product-stack { transform: rotate(4deg); }
        .et-product-stack img { box-shadow: 8px 10px 0 rgb(0 56 255 / .2); }
        .et-order-cards { min-height: 20rem; }
        @media (max-width: 639px) {
            html { scroll-padding-top: 8.5rem; }
            #home, #about, #menu, #order-guide, #contact { scroll-margin-top: 8.5rem; }
            .et-hero-sky .et-product-stack { inset-inline: .75rem; top: 3.5rem; gap: .5rem; }
            .et-hero-sky .et-product-stack > div { border-width: 3px; border-radius: .75rem; }
            .et-hero-sky .et-product-stack + div { left: .25rem; bottom: 2rem; height: 6rem; width: 8.5rem; font-size: 1rem; }
            .et-hero-sky .et-product-stack ~ a { right: .25rem; bottom: 2rem; height: 5.25rem; width: 5.25rem; font-size: .65rem; }
            .et-hero-sky .et-product-stack ~ span:last-child { right: 4.25rem; bottom: .25rem; font-size: .65rem; }
            .et-order-cards { height: 12rem; min-height: 12rem; }
            #order-guide { grid-template-columns: minmax(0, 1fr); gap: 1rem; padding: 1.25rem; }
            #order-guide .et-order-cards { width: 100%; max-width: none; }
            #order-guide .et-stack-card { padding: 1.25rem; }
            #order-guide h2 { font-size: 1.75rem; line-height: 1.1; }
            #order-guide .et-stack-card h3 { font-size: 1.2rem; }
            #order-guide .et-stack-card p { max-width: 18rem; font-size: .7rem; line-height: 1.2rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
        }
        [x-show="cartOpen"] aside ul > :not([hidden]) ~ :not([hidden]) { border-color: rgb(0 56 255 / 0.1) !important; }
        [x-show="cartOpen"] aside [x-show="cart.length > 0"] { background: #F4F7FF !important; border-color: rgb(0 56 255 / 0.1) !important; }
        [x-show="cartOpen"] aside input, [x-show="cartOpen"] aside textarea { border-color: rgb(0 56 255 / 0.15) !important; background: #FFFFFF !important; }
        [x-show="cartOpen"] aside input:focus, [x-show="cartOpen"] aside textarea:focus { border-color: #0038FF !important; --tw-ring-color: rgb(0 56 255 / 0.15) !important; }
        [x-show="cartOpen"] aside [class*="[#A31D5D]"] { color: #0038FF !important; border-color: rgb(0 56 255 / 0.2) !important; }
        [x-show="cartOpen"] aside [class*="[#FDF2F7]"] { background: #F4F7FF !important; }
        [x-show="cartOpen"] aside [class*="[#351827]"], [x-show="cartOpen"] aside [class*="[#765568]"] { color: #0B1A3A !important; }
        @keyframes et-marquee { from { transform: translateX(100%); } to { transform: translateX(-100%); } }
        .et-marquee { animation: et-marquee 24s linear infinite; }
        .et-marquee-slow { animation-duration: 34s; }
        .et-marquee-fast { animation-duration: 15s; }
        .et-float { animation: et-float 4s ease-in-out infinite; }
        @keyframes et-float { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-7px) rotate(2deg); } }
        .et-stack-card { transform-origin: 50% 100%; transition: transform .65s cubic-bezier(.22, 1, .36, 1), opacity .45s ease, filter .45s ease; }
        .et-stack-card:hover { transform: translateY(-8px) rotate(0deg) !important; }
        @media (prefers-reduced-motion: reduce) { .et-stack-card { transition: none; } }
    </style>
</head>
<body class="min-h-screen bg-[#F4F7FF] text-[#0B1A3A]" x-data="cartApp({{ Js::from($addOnPayloads) }})">
    <header class="sticky top-0 z-40 border-b border-[#0038FF]/20 bg-white/75 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center gap-5 px-5 py-3 sm:px-8">
            <a href="#home" class="flex shrink-0 items-center gap-2 text-xl font-extrabold tracking-tight text-[#0038FF] sm:text-2xl"><img src="{{ asset('logo.jpg') }}" alt="" class="h-9 w-9 rounded-full object-cover shadow-sm"> <span class="et-display">Eat This One</span></a>
            <nav class="hidden flex-1 items-center justify-center gap-5 text-xs font-extrabold uppercase tracking-wide text-[#405070] lg:flex" aria-label="Navigasi utama">
                <a href="#home" class="transition hover:text-[#0038FF]">Home</a>
                <a href="#about" class="transition hover:text-[#0038FF]">About Us</a>
                <a href="#menu" class="transition hover:text-[#0038FF]">Menu Catalog</a>
                <a href="#order-guide" class="transition hover:text-[#0038FF]">How to Order</a>
                <a href="#contact" class="transition hover:text-[#0038FF]">Contact</a>
            </nav>
            <a href="https://wa.me/6282311681167" target="_blank" rel="noreferrer" class="ml-auto hidden text-xs font-bold text-[#405070] transition hover:text-[#0038FF] xl:block">WA 0823 1168 1167</a>
            <button @click="cartOpen = true" class="relative flex shrink-0 items-center gap-2 rounded-full bg-[#0038FF] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#002BB8] focus:outline-none focus:ring-2 focus:ring-[#0038FF]/30" aria-label="Buka keranjang">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5.4 5M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8 2a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" /></svg>
                <span class="hidden sm:inline">Quick Order</span>
                <span x-show="totalItems > 0" x-text="totalItems" class="absolute -right-2 -top-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-white px-1.5 text-xs font-extrabold text-[#0038FF]"></span>
            </button>
        </div>
        <nav class="flex gap-5 overflow-x-auto border-t border-[#0038FF]/10 px-5 py-2 text-[10px] font-extrabold uppercase tracking-wide text-[#405070] lg:hidden" aria-label="Navigasi mobile">
            <a href="#home" class="shrink-0">Home</a><a href="#about" class="shrink-0">About Us</a><a href="#menu" class="shrink-0">Menu Catalog</a><a href="#order-guide" class="shrink-0">How to Order</a><a href="#contact" class="shrink-0">Contact</a>
        </nav>
    </header>

    @if($runningTexts->isNotEmpty())
        <div class="overflow-hidden border-b border-[#0038FF]/30 bg-[#0038FF] py-2 text-sm font-bold text-white">
            <div class="flex min-w-max gap-16 et-marquee {{ $runningTexts->first()->speed === 'slow' ? 'et-marquee-slow' : ($runningTexts->first()->speed === 'fast' ? 'et-marquee-fast' : '') }}">
                @foreach($runningTexts as $runningText)
                    <span>{{ $runningText->content }} <b aria-hidden="true">✦</b></span>
                @endforeach
            </div>
        </div>
    @endif

    <main class="pb-16">
        <section id="home" class="et-hero-sky et-hero-grid relative overflow-hidden border-b-0">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 pb-16 pt-12 sm:px-8 lg:min-h-150 lg:grid-cols-[.9fr_1.1fr] lg:pb-20 lg:pt-16">
                <div class="relative z-10">
                    <span class="et-sticker inline-block rounded-full bg-[#E11D48] px-4 py-2 text-[10px] font-extrabold uppercase tracking-[.2em] text-white">Street-pop dessert bar</span>
                    <h1 class="et-display mt-7 max-w-xl text-5xl leading-[.92] text-[#0038FF] sm:text-7xl">Sweet & savory<br><span class="text-white [text-shadow:3px_3px_0_#0038FF]">delivered</span><br>to your door.</h1>
                    <p class="mt-6 max-w-md text-sm font-semibold leading-7 text-[#0B1A3A] sm:text-base">Gabin Bar Ice Cream, dimsum, dan camilan kecil yang dibuat untuk menghadirkan big happiness di setiap gigitan.</p>
                    <div class="mt-7 flex flex-wrap items-center gap-3"><a href="#menu" class="rounded-full bg-[#0038FF] px-5 py-3 text-sm font-extrabold text-white shadow-[5px_5px_0_#0B1A3A] transition hover:-translate-y-1">Explore Menu <span aria-hidden="true">↘</span></a><span class="rounded-full border-2 border-[#0B1A3A] bg-white/60 px-4 py-2 text-xs font-extrabold text-[#0B1A3A]">Small bites, big happiness.</span></div>
                </div>
                <div class="relative min-h-97.5 lg:min-h-125">
                    <div class="absolute right-0 top-5 h-72 w-72 rounded-full border-18 border-white/70 bg-[#0038FF]/15 sm:h-96 sm:w-96"></div>
                    <div class="et-product-stack absolute inset-x-5 top-14 z-10 mx-auto grid max-w-md grid-cols-3 gap-3 sm:inset-x-12 sm:top-20">
                        @foreach($products->take(6) as $heroProduct)
                            <div class="aspect-4/5 rotate-{{ ($loop->index % 2 === 0) ? '[-4deg]' : '[5deg]' }} overflow-hidden rounded-2xl border-4 border-white bg-[#0038FF] {{ $loop->index === 1 ? 'translate-y-7' : '' }} {{ $loop->index === 4 ? '-translate-y-5' : '' }}">
                                @if($heroProduct->image)
                                    <img src="{{ filter_var($heroProduct->image, FILTER_VALIDATE_URL) ? $heroProduct->image : rtrim(config('app.url'), '/') . '/storage/' . ltrim($heroProduct->image, '/') }}" alt="{{ $heroProduct->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center p-2 text-center text-xs font-extrabold text-white">{{ $heroProduct->name }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute bottom-8 left-0 z-20 flex h-28 w-44 -rotate-6 items-center justify-center rounded-2xl border-4 border-[#0B1A3A] bg-[#0038FF] text-center text-xl font-extrabold text-white shadow-[8px_9px_0_#0B1A3A] sm:left-8">EAT<br>THIS ONE</div>
                    <a href="#menu" class="et-float absolute bottom-7 right-0 z-30 flex h-24 w-24 rotate-12 items-center justify-center rounded-full border-4 border-[#0B1A3A] bg-white text-center text-xs font-extrabold text-[#0038FF] shadow-[5px_6px_0_#0B1A3A]">Quick<br>Order<br><span class="text-[#E11D48]">↘</span></a>
                    <span class="absolute left-1 top-2 rotate-12 text-5xl text-[#E11D48]" aria-hidden="true">✦</span>
                    <span class="absolute bottom-1 right-28 rounded-full bg-[#F4E8D1] px-3 py-2 text-xs font-extrabold text-[#0B1A3A] shadow-md">Rp 8.000</span>
                </div>
            </div>
            <div class="et-checker h-7 w-full border-y-4 border-[#0B1A3A]"></div>
        </section>

        <section id="about" class="bg-[#0038FF] px-5 py-16 text-white sm:px-8 sm:py-24">
            <div class="mx-auto grid max-w-7xl gap-8 md:grid-cols-[.35fr_1fr] md:items-end"><p class="text-xs font-extrabold uppercase tracking-[.25em] text-[#F4E8D1]">Our little philosophy</p><div><blockquote class="et-display max-w-4xl text-4xl leading-tight sm:text-6xl">“Eat This One was created from a simple idea: <span class="text-[#F4E8D1]">small bites, big happiness.</span>”</blockquote><a href="#contact" class="mt-8 inline-flex items-center gap-3 rounded-full bg-[#0B1A3A] px-5 py-3 text-sm font-extrabold text-white transition hover:bg-white hover:text-[#0038FF]">More About Us <span aria-hidden="true">↗</span></a></div></div>
        </section>

        <div id="menu" class="mx-auto max-w-7xl px-5 pt-16 sm:px-8">

        <div x-data="{ currentCategory: 'all' }">
            <div class="mb-8 flex gap-2 overflow-x-auto pb-2" role="tablist" aria-label="Kategori produk">
                <button @click="currentCategory = 'all'" :class="currentCategory === 'all' ? 'bg-[#0038FF] text-white shadow-md' : 'bg-white text-[#405070] hover:border-[#0038FF] hover:text-[#0038FF]'" class="shrink-0 rounded-full border border-transparent px-5 py-2.5 text-sm font-bold transition">Semua menu</button>
                @foreach($categories as $category)
                    <button @click="currentCategory = '{{ $category->id }}'" :class="currentCategory === '{{ $category->id }}' ? 'bg-[#0038FF] text-white shadow-md' : 'bg-white text-[#405070] hover:border-[#0038FF] hover:text-[#0038FF]'" class="shrink-0 rounded-full border border-transparent px-5 py-2.5 text-sm font-bold transition">{{ $category->name }}</button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($products as $product)
                    @php
                        $productPayload = $product->toArray();
                        $productPayload['image'] = $product->image && filter_var($product->image, FILTER_VALIDATE_URL)
                            ? $product->image
                            : ($product->image ? rtrim(config('app.url'), '/') . '/storage/' . ltrim($product->image, '/') : null);
                    @endphp
                    <article x-show="currentCategory === 'all' || currentCategory === '{{ $product->category_id }}'" x-transition class="group flex flex-col overflow-hidden rounded-3xl border border-[#0038FF]/20 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#0038FF]/10">
                        <div class="relative h-56 cursor-pointer overflow-hidden bg-[#EAF0FF]" @click="openModal({{ Js::from($productPayload) }})">
                            @if($product->image)
                                <img src="{{ $productPayload['image'] }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center text-sm font-semibold text-[#0038FF]/50">No Image</div>
                            @endif
                            @if($product->badge)
                                <span class="absolute right-3 top-3 rounded-full bg-[#0038FF] px-3 py-1 text-xs font-extrabold text-white shadow-sm">{{ $product->badge }}</span>
                            @endif
                            <span class="absolute bottom-3 left-3 rounded-full bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-[#0038FF] backdrop-blur">{{ $product->category?->name ?? 'Menu' }}</span>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 p-5">
                            <div>
                                <h2 class="cursor-pointer text-lg font-extrabold text-[#0B1A3A] transition group-hover:text-[#0038FF]" @click="openModal({{ Js::from($productPayload) }})">{{ $product->name }}</h2>
                                <p class="mt-1 line-clamp-2 text-sm leading-6 text-[#405070]">{{ $product->description }}</p>
                            </div>
                            <div class="mt-auto flex items-center justify-between gap-3 pt-2">
                                <span class="text-base font-extrabold text-[#0038FF]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->stock > 0)
                                    <button @click="addToCart({{ Js::from($productPayload) }})" class="rounded-full border border-[#0038FF] bg-white px-3.5 py-2 text-xs font-extrabold text-[#0038FF] transition hover:bg-[#0038FF] hover:text-white">+ Keranjang</button>
                                @else
                                    <span class="rounded-full bg-[#FCE7EF] px-3.5 py-2 text-xs font-bold text-[#E11D48]">Stok habis</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
        </div>

        <section class="mt-16 rounded-4xl border border-[#F4E8D1] bg-white p-5 shadow-sm sm:p-8" id="addons">
            <div class="mb-6 flex items-center gap-4"><span class="et-float flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F4E8D1] text-2xl">📦</span><div><p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#0038FF]">Packing tambahan</p><h2 class="text-2xl font-extrabold text-[#0B1A3A]">Bikin pesananmu makin aman</h2><p class="mt-1 text-sm text-[#405070]">Pilih perlengkapan yang kamu butuhkan untuk pengiriman.</p></div></div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($addOns as $addOn)
                    @php
                        $addOnPayload = ['id' => $addOn->id, 'name' => $addOn->name, 'price' => $addOn->price, 'image' => $addOn->image ? rtrim(config('app.url'), '/') . '/storage/' . ltrim($addOn->image, '/') : null];
                    @endphp
                    <article class="flex gap-3 rounded-2xl border border-[#F4E8D1] bg-white p-3 transition hover:-translate-y-1 hover:shadow-md">
                        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-[#F4E8D1]">@if($addOnPayload['image'])<img src="{{ $addOnPayload['image'] }}" alt="{{ $addOn->name }}" class="h-full w-full object-cover">@else<span class="flex h-full items-center justify-center text-2xl">📦</span>@endif</div>
                        <div class="min-w-0 flex-1"><h3 class="truncate text-sm font-extrabold text-[#0B1A3A]">{{ $addOn->name }}</h3><p class="mt-1 line-clamp-2 text-xs leading-5 text-[#405070]">{{ $addOn->description }}</p><div class="mt-2 flex items-center justify-between gap-2"><strong class="text-sm text-[#0038FF]">Rp {{ number_format($addOn->price, 0, ',', '.') }}</strong><button @click="addOnToCart({{ Js::from($addOnPayload) }})" class="rounded-full bg-[#F4E8D1] px-3 py-1.5 text-xs font-extrabold text-[#0B1A3A] transition hover:bg-[#EBD9B8]">+ Pilih</button></div></div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mt-16 grid items-center gap-8 overflow-hidden rounded-4xl border border-[#0038FF]/15 bg-white p-6 shadow-sm sm:p-10 md:grid-cols-[.8fr_1.2fr]" id="order-guide" x-data="orderSteps()" x-init="startShuffle()">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#E11D48]">Cara order</p>
                <h2 class="et-display mt-2 text-3xl text-[#0038FF]">Tiga langkah menuju camilan favoritmu</h2>
                <p class="mt-4 max-w-md text-sm leading-7 text-[#405070]">Kartu ini berganti otomatis. Klik kartu mana pun untuk melihat langkahnya lebih dekat.</p>
                <div class="mt-6 flex gap-2" role="tablist" aria-label="Langkah pemesanan">
                    <template x-for="(step, index) in steps" :key="step.number">
                        <button type="button" @click="active = index" :aria-label="`Lihat langkah ${step.number}`" :aria-selected="active === index" class="h-2.5 rounded-full transition-all" :class="active === index ? 'w-9 bg-[#0038FF]' : 'w-2.5 bg-[#BFD0FF] hover:bg-[#0038FF]'" role="tab"></button>
                    </template>
                </div>
            </div>
            <div class="et-order-cards relative mx-auto h-75 w-full max-w-110 sm:h-80" @mouseenter="pauseShuffle()" @mouseleave="startShuffle()" @focusin="pauseShuffle()" @focusout="startShuffle()">
                <template x-for="(step, index) in steps" :key="step.number">
                    <button type="button" @click="active = index" class="et-stack-card absolute inset-0 flex h-full w-full flex-col justify-between rounded-3xl p-7 text-left shadow-xl focus:outline-none focus:ring-4 focus:ring-[#0038FF]/20" :class="step.theme" :style="cardStyle(index)" :aria-label="`Langkah ${step.number}: ${step.title}`">
                        <div class="flex items-start justify-between"><span class="text-5xl font-extrabold opacity-90" x-text="step.number"></span><span class="rounded-full bg-white/25 px-3 py-1 text-xs font-extrabold" x-text="step.label"></span></div>
                        <div><h3 class="text-2xl font-extrabold" x-text="step.title"></h3><p class="mt-2 max-w-sm text-sm leading-6 opacity-80" x-text="step.description"></p></div>
                    </button>
                </template>
            </div>
        </section>
    </main>

    <footer id="contact" class="border-t border-[#0038FF]/10 bg-white px-5 py-8 sm:px-8"><div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 text-sm text-[#405070] sm:flex-row sm:items-center"><div><strong class="text-[#0038FF]">Eat This One</strong><p class="mt-1">Sweet & savory moments, delivered with care.</p></div><div class="flex gap-4 font-bold"><a href="https://instagram.com/eat.this.one_" target="_blank" rel="noreferrer" class="hover:text-[#0038FF]">Instagram</a><a href="https://wa.me/6282311681167" target="_blank" rel="noreferrer" class="hover:text-[#22C55E]">WhatsApp</a></div></div></footer>

    <div x-cloak x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-[#0B1A3A]/70 backdrop-blur-sm" @click="modalOpen = false"></div>
            <div x-show="modalOpen" x-transition.scale class="relative w-full max-w-lg overflow-hidden rounded-3xl border border-[#0038FF]/25 bg-white shadow-2xl">
                <div class="relative h-64 bg-[#EAF0FF]">
                    <template x-if="selectedProduct?.image"><img :src="selectedProduct.image" :alt="selectedProduct.name" class="h-full w-full object-cover"></template>
                    <template x-if="!selectedProduct?.image"><div class="flex h-full items-center justify-center text-sm text-[#0038FF]/50">No Image</div></template>
                    <button @click="modalOpen = false" class="absolute right-4 top-4 rounded-full bg-white/90 p-2 text-[#0038FF] shadow backdrop-blur transition hover:bg-white" aria-label="Tutup detail"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="m6 6 12 12M18 6 6 18" /></svg></button>
                </div>
                <div class="space-y-4 p-6">
                    <div><h2 class="text-2xl font-extrabold text-[#0B1A3A]" x-text="selectedProduct?.name"></h2><p class="mt-1 text-xl font-extrabold text-[#0038FF]" x-text="selectedProduct ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedProduct.price) : ''"></p></div>
                    <p class="leading-7 text-[#405070]" x-text="selectedProduct?.full_description || selectedProduct?.description"></p>
                    <div class="space-y-2 rounded-2xl bg-[#F4F7FF] p-4 text-sm text-[#405070]">
                        <template x-if="selectedProduct?.size"><div class="flex justify-between"><span>Ukuran</span><strong class="text-[#0B1A3A]" x-text="selectedProduct.size"></strong></div></template>
                        <template x-if="selectedProduct?.thickness"><div class="flex justify-between"><span>Ketebalan</span><strong class="text-[#0B1A3A]" x-text="selectedProduct.thickness"></strong></div></template>
                        <template x-if="selectedProduct?.topping"><div class="flex justify-between"><span>Topping</span><strong class="text-[#0B1A3A]" x-text="selectedProduct.topping"></strong></div></template>
                    </div>
                    <p class="et-slogan text-center text-[11px] font-extrabold uppercase text-[#0038FF]">Small bites, big happiness.</p>
                    <template x-if="selectedProduct && selectedProduct.stock > 0"><button @click="addToCart(selectedProduct); modalOpen = false" class="w-full rounded-full bg-[#0038FF] px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-[#002BB8]">+ Tambah ke Keranjang</button></template>
                    <template x-if="!selectedProduct || selectedProduct.stock <= 0"><button disabled class="w-full cursor-not-allowed rounded-full bg-[#FCE7EF] px-5 py-3.5 text-sm font-extrabold text-[#E11D48]">Stok habis</button></template>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="cartOpen" class="fixed inset-0 z-50" role="dialog" aria-modal="true">
        <div x-show="cartOpen" x-transition.opacity class="absolute inset-0 bg-[#0B1A3A]/70 backdrop-blur-sm" @click="cartOpen = false"></div>
        <aside x-show="cartOpen" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="absolute right-0 top-0 flex h-full w-full max-w-md flex-col border-l border-[#0038FF]/20 bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#0038FF]/10 px-5 py-5"><div><p class="text-xs font-bold uppercase tracking-widest text-[#0038FF]">Your picks</p><h2 class="text-xl font-extrabold text-[#0B1A3A]">Keranjang</h2></div><button @click="cartOpen = false" class="rounded-full p-2 text-[#405070] hover:bg-[#F4F7FF]" aria-label="Tutup keranjang"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="m6 6 12 12M18 6 6 18" /></svg></button></div>
            <div class="flex-1 overflow-y-auto px-5 py-4">
                <template x-if="cart.length === 0"><div class="flex h-full flex-col items-center justify-center gap-3 text-center"><span class="text-4xl text-[#0038FF]">♡</span><p class="font-bold text-[#0B1A3A]">Keranjang masih kosong</p><p class="text-sm text-[#405070]">Pilih camilan untuk memulai pesananmu.</p></div></template>
                <ul class="divide-y divide-[#A31D5D]/10"><template x-for="item in cart" :key="item.id"><li class="flex gap-3 py-4"><div class="h-16 w-16 shrink-0 overflow-hidden rounded-2xl bg-[#F8E4ED]"><template x-if="item.image"><img :src="item.image" :alt="item.name" class="h-full w-full object-cover"></template><template x-if="!item.image"><span class="flex h-full items-center justify-center text-2xl">📦</span></template></div><div class="min-w-0 flex-1"><div class="flex justify-between gap-2"><div><span class="text-[10px] font-extrabold uppercase tracking-wide text-[#E11D48]" x-text="item.type === 'addon' ? 'Packing' : 'Produk'"></span><h3 class="truncate text-sm font-bold text-[#351827]" x-text="item.name"></h3></div><p class="shrink-0 text-sm font-extrabold text-[#A31D5D]" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(item.price * item.quantity)"></p></div><div class="mt-3 flex items-center justify-between"><div class="flex items-center rounded-full border border-[#A31D5D]/20 bg-[#FDF2F7]"><button @click="updateQuantity(item.id, item.quantity - 1)" class="px-3 py-1 text-[#A31D5D]">-</button><span class="border-x border-[#A31D5D]/20 px-3 py-1 text-xs font-bold" x-text="item.quantity"></span><button @click="updateQuantity(item.id, item.quantity + 1)" class="px-3 py-1 text-[#A31D5D]">+</button></div><button @click="removeFromCart(item.id)" class="text-xs font-bold text-[#E11D48] hover:underline">Hapus</button></div></div></li></template></ul>
            </div>
            <div x-show="cart.length > 0" class="border-t border-[#A31D5D]/10 bg-[#FDF2F7] p-5"><div class="mb-4 flex justify-between text-base font-extrabold text-[#351827]"><span>Total bayar</span><span class="text-[#A31D5D]" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice)"></span></div><div class="space-y-3"><input type="text" x-model="customer.name" class="w-full rounded-2xl border border-[#A31D5D]/15 bg-[#FFFDF7] px-4 py-3 text-sm outline-none transition placeholder:text-[#9D8190] focus:border-[#A31D5D] focus:ring-2 focus:ring-[#A31D5D]/15" placeholder="Nama lengkap"><input type="tel" x-model="customer.phone" class="w-full rounded-2xl border border-[#A31D5D]/15 bg-[#FFFDF7] px-4 py-3 text-sm outline-none transition placeholder:text-[#9D8190] focus:border-[#A31D5D] focus:ring-2 focus:ring-[#A31D5D]/15" placeholder="Nomor WhatsApp"><textarea x-model="customer.notes" rows="2" class="w-full rounded-2xl border border-[#A31D5D]/15 bg-[#FFFDF7] px-4 py-3 text-sm outline-none transition placeholder:text-[#9D8190] focus:border-[#A31D5D] focus:ring-2 focus:ring-[#A31D5D]/15" placeholder="Catatan pesanan (opsional)"></textarea><button @click="checkout()" :disabled="!customer.name || !customer.phone || submitting" class="flex w-full items-center justify-center gap-2 rounded-full bg-[#22C55E] px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-[#16A34A] disabled:cursor-not-allowed disabled:bg-[#B9C7BD]"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.5 4.1 1.6 5.9L.2 24l6.5-1.7a11.8 11.8 0 0 0 5.4 1.3h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.2-6.1-3.5-8.3Zm-8.4 18.1h-.1c-1.7 0-3.4-.5-4.8-2.9a9.8 9.8 0 0 1-1.5-5.2C2.3 6.4 6.7 2 12.1 2c2.6 0 5.1 1 6.9 2.9a9.8 9.8 0 0 1 2.9 7c0 5.4-4.4 9.7-9.8 9.7Zm5.3-7.3c-.3-.2-1.7-.8-2-.9-.3-.1-.5-.2-.7.2-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-1.6-.8-2.6-1.4-3.6-3.2-.3-.5.3-.5.8-1.6.1-.2.1-.4 0-.6-.1-.2-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.4 1.4 3.6c.2.2 2.3 3.5 5.6 4.9.8.3 1.5.5 2 .7.8-.1 1.7-.7 1.9-1.3.2-.6.2-1.2.1-1.3-.1-.2-.3-.3-.6-.4Z" /></svg><span x-text="submitting ? 'Menyiapkan order...' : 'Pesan via WhatsApp'"></span></button></div></div>
        </aside>
    </div>

    <script>
        function orderSteps() {
            return {
                active: 0,
                timer: null,
                steps: [
                    { number: '01', label: 'Pilih', title: 'Pilih menu', description: 'Pilih produk favorit dan add-on packing yang kamu perlukan.', theme: 'bg-[#0038FF] text-white' },
                    { number: '02', label: 'Isi data', title: 'Isi data', description: 'Masukkan nama dan nomor WhatsApp di dalam keranjang.', theme: 'bg-[#F4E8D1] text-[#0B1A3A]' },
                    { number: '03', label: 'Kirim', title: 'Kirim order', description: 'Klik Pesan via WhatsApp dan tunggu konfirmasi dari kami.', theme: 'bg-[#E11D48] text-white' },
                ],
                cardStyle(index) {
                    const offset = (index - this.active + this.steps.length) % this.steps.length;
                    const styles = [
                        { transform: 'translate3d(0, 0, 0) rotate(0deg) scale(1)', opacity: '1', zIndex: 3, filter: 'none' },
                        { transform: 'translate3d(18px, 12px, 0) rotate(5deg) scale(.94)', opacity: '.86', zIndex: 2, filter: 'saturate(.86)' },
                        { transform: 'translate3d(34px, 22px, 0) rotate(9deg) scale(.88)', opacity: '.7', zIndex: 1, filter: 'saturate(.7)' },
                    ];
                    return styles[offset];
                },
                startShuffle() {
                    this.pauseShuffle();
                    this.timer = setInterval(() => { this.active = (this.active + 1) % this.steps.length; }, 3600);
                },
                pauseShuffle() {
                    if (this.timer) { clearInterval(this.timer); this.timer = null; }
                },
            };
        }

        function cartApp(addOns) {
            return {
                cartOpen: false, modalOpen: false, selectedProduct: null, cart: [], submitting: false,
                addOns, customer: { name: '', phone: '', notes: '' },
                openModal(product) { this.selectedProduct = product; this.modalOpen = true; },
                addToCart(product) {
                    const key = `product-${product.id}`;
                    const existing = this.cart.find(item => item.id === key);
                    if (existing) {
                        if (existing.quantity < product.stock) existing.quantity++;
                        else alert('Maksimal stok tercapai');
                    } else {
                        this.cart.push({ id: key, sourceId: product.id, type: 'product', name: product.name, price: product.price, image: product.image, quantity: 1, stock: product.stock });
                    }
                    this.cartOpen = true;
                },
                addOnToCart(addOn) {
                    const key = `addon-${addOn.id}`;
                    const existing = this.cart.find(item => item.id === key);
                    if (existing) existing.quantity++;
                    else this.cart.push({ id: key, sourceId: addOn.id, type: 'addon', name: addOn.name, price: addOn.price, image: addOn.image, quantity: 1, stock: 99 });
                    this.cartOpen = true;
                },
                updateQuantity(id, newQuantity) {
                    if (newQuantity <= 0) { this.removeFromCart(id); return; }
                    const item = this.cart.find(entry => entry.id === id);
                    if (item && newQuantity <= item.stock) item.quantity = newQuantity;
                },
                removeFromCart(id) { this.cart = this.cart.filter(item => item.id !== id); },
                get totalItems() { return this.cart.reduce((total, item) => total + item.quantity, 0); },
                get totalPrice() { return this.cart.reduce((total, item) => total + item.price * item.quantity, 0); },
                async checkout() {
                    if (!this.customer.name || !this.customer.phone || !this.cart.length || this.submitting) return;
                    this.submitting = true;
                    try {
                        const response = await fetch('{{ route('orders.store') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                            body: JSON.stringify({
                                name: this.customer.name,
                                phone: this.customer.phone,
                                notes: this.customer.notes,
                                items: this.cart.filter(item => item.type === 'product').map(item => ({ id: item.sourceId, quantity: item.quantity })),
                                addons: this.cart.filter(item => item.type === 'addon').map(item => ({ id: item.sourceId, quantity: item.quantity })),
                            }),
                        });
                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Order gagal disimpan.');
                        window.open(data.whatsapp_url, '_blank');
                    } catch (error) {
                        alert(error.message);
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
</body>
</html>