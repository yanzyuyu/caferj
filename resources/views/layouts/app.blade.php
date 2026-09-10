<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Cafe RJ') — POS</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
        }
    }
}
</script>
<style>
:root {
    --sb-thumb: #d4d4d8;
    --sb-thumb-hover: #71717a;
    --sb-track: transparent;
}
* {
    scrollbar-width: thin;
    scrollbar-color: var(--sb-thumb) var(--sb-track);
}
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: var(--sb-track);
}
::-webkit-scrollbar-thumb {
    background: var(--sb-thumb);
    border-radius: 9999px;
    transition: background 0.15s ease;
}
::-webkit-scrollbar-thumb:hover {
    background: var(--sb-thumb-hover);
}

select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #ffffff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2371717a' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1rem;
    padding-right: 2.5rem !important;
    cursor: pointer;
}
</style>
</head>
<body class="bg-zinc-50 font-sans text-zinc-800">

<div class="flex min-h-screen relative overflow-x-hidden">
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-zinc-950/60 z-40 md:hidden hidden transition-opacity"></div>

    <aside id="sidebar-menu" class="fixed inset-y-0 left-0 z-50 w-64 bg-zinc-900 text-zinc-100 flex flex-col flex-shrink-0 -translate-x-full md:translate-x-0 md:static transition-transform duration-200 ease-in-out shadow-xl md:shadow-none">
        <div class="px-6 py-5 border-b border-zinc-700 flex items-center justify-between">
            <div>
                <span class="text-lg font-bold tracking-tight">Cafe RJ</span>
                <p class="text-xs text-zinc-400 mt-0.5">Point of Sale System</p>
            </div>
            <button type="button" onclick="toggleMobileSidebar()" class="md:hidden p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors" aria-label="Tutup Menu">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pos.index') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Kasir POS
            </a>

            <a href="{{ route('transactions.history') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('transactions.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Riwayat Transaksi
            </a>

            @if(auth()->user()->role === 'admin')
            <div class="pt-3 pb-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-widest text-zinc-500">Manajemen</p>
            </div>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                Kategori Menu
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Produk & Menu
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Pengguna
            </a>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }} transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Laporan Omzet
            </a>
            @endif
        </nav>

        <div class="px-4 py-4 border-t border-zinc-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-zinc-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-zinc-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-zinc-400 hover:text-white hover:bg-zinc-800 rounded-lg transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 w-full">
        <header class="bg-white border-b border-zinc-200 px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between flex-shrink-0 sticky top-0 z-30">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button" onclick="toggleMobileSidebar()" class="md:hidden p-1.5 -ml-1 rounded-lg text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 transition-colors focus:outline-none" aria-label="Buka Menu">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="text-sm sm:text-base font-semibold text-zinc-900 truncate">@yield('page-title', 'Dashboard')</h1>
            </div>
            <span class="text-xs text-zinc-500 hidden sm:inline flex-shrink-0">{{ now()->translatedFormat('l, d F Y') }}</span>
        </header>

        @if(session('success'))
        <div class="mx-4 sm:mx-6 mt-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mx-4 sm:mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        <div class="flex-1 p-3.5 sm:p-6 overflow-auto">
            @yield('content')
        </div>
    </main>
</div>

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar-menu');
    const backdrop = document.getElementById('sidebar-backdrop');
    if (!sidebar || !backdrop) return;
    const isHidden = sidebar.classList.contains('-translate-x-full');
    if (isHidden) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

function initCustomSelects() {
    document.querySelectorAll('select:not([data-customized])').forEach(function(sel) {
        sel.setAttribute('data-customized', 'true');
        
        const wrapper = document.createElement('div');
        wrapper.className = 'custom-select-wrapper relative w-full';
        sel.parentNode.insertBefore(wrapper, sel);
        wrapper.appendChild(sel);
        
        sel.classList.add('sr-only');
        sel.tabIndex = -1;
        
        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'custom-select-trigger w-full px-3 py-2.5 text-sm bg-white border border-zinc-300 rounded-lg flex items-center justify-between shadow-sm hover:border-zinc-400 focus:outline-none focus:border-zinc-900 focus:ring-2 focus:ring-zinc-100 transition-all text-left';
        
        if (sel.classList.contains('border-red-400') || sel.matches('.border-red-400')) {
            trigger.classList.add('border-red-400', 'bg-red-50');
        }
        
        const label = document.createElement('span');
        label.className = 'truncate text-zinc-900 font-medium';
        const selectedOpt = sel.options[sel.selectedIndex] || sel.options[0];
        label.textContent = selectedOpt ? selectedOpt.textContent : '';
        if (selectedOpt && selectedOpt.value === '') {
            label.className = 'truncate text-zinc-400';
        }
        
        const arrow = document.createElement('span');
        arrow.className = 'ml-2 text-zinc-400 flex-shrink-0 transition-transform duration-200';
        arrow.innerHTML = '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>';
        
        trigger.appendChild(label);
        trigger.appendChild(arrow);
        wrapper.appendChild(trigger);
        
        const menu = document.createElement('div');
        menu.className = 'custom-select-menu hidden absolute left-0 right-0 z-50 mt-1.5 max-h-60 overflow-y-auto bg-white border border-zinc-200 rounded-xl shadow-lg p-1.5 space-y-0.5';
        
        function updateMenuOptions() {
            menu.innerHTML = '';
            Array.from(sel.options).forEach(function(opt) {
                const item = document.createElement('div');
                const isSelected = opt.selected;
                item.className = 'custom-select-option px-3 py-2 text-sm rounded-lg cursor-pointer flex items-center justify-between transition-colors ' + 
                    (isSelected ? 'bg-zinc-900 text-white font-medium' : 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900');
                
                const itemText = document.createElement('span');
                itemText.textContent = opt.textContent;
                item.appendChild(itemText);
                
                if (isSelected && opt.value !== '') {
                    const check = document.createElement('span');
                    check.innerHTML = '<svg class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                    item.appendChild(check);
                }
                
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sel.value = opt.value;
                    sel.dispatchEvent(new Event('change', { bubbles: true }));
                    label.textContent = opt.textContent;
                    label.className = opt.value === '' ? 'truncate text-zinc-400' : 'truncate text-zinc-900 font-medium';
                    closeDropdown();
                    updateMenuOptions();
                });
                
                menu.appendChild(item);
            });
        }
        
        updateMenuOptions();
        wrapper.appendChild(menu);
        
        function openDropdown() {
            closeAllCustomSelects(wrapper);
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            trigger.classList.add('border-zinc-900', 'ring-2', 'ring-zinc-100');
        }
        
        function closeDropdown() {
            menu.classList.add('hidden');
            arrow.classList.remove('rotate-180');
            trigger.classList.remove('border-zinc-900', 'ring-2', 'ring-zinc-100');
        }
        
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (menu.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        });
        
        sel.addEventListener('change', function() {
            const current = sel.options[sel.selectedIndex];
            if (current) {
                label.textContent = current.textContent;
                label.className = current.value === '' ? 'truncate text-zinc-400' : 'truncate text-zinc-900 font-medium';
            }
            updateMenuOptions();
        });
    });
}

function closeAllCustomSelects(except) {
    document.querySelectorAll('.custom-select-wrapper').forEach(function(wrap) {
        if (wrap !== except) {
            const m = wrap.querySelector('.custom-select-menu');
            const a = wrap.querySelector('.custom-select-trigger span:last-child');
            const t = wrap.querySelector('.custom-select-trigger');
            if (m) m.classList.add('hidden');
            if (a) a.classList.remove('rotate-180');
            if (t) t.classList.remove('border-zinc-900', 'ring-2', 'ring-zinc-100');
        }
    });
}

document.addEventListener('click', function() {
    closeAllCustomSelects();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAllCustomSelects();
    }
});

window.addEventListener('DOMContentLoaded', initCustomSelects);
</script>

</body>
</html>
