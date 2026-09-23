<!-- MOBILE APP-LIKE BOTTOM NAVIGATION BAR -->
<!-- ============================================== -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#0B1120]/95 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
    <div class="flex items-center justify-between px-4 py-2.5 max-w-md mx-auto">

        @php
            $bottomMenu = \App\Models\Menu::with('parentItems')->where('location', 'bottom_nav')->where('is_active', true)->first();
            $bottomItems = $bottomMenu ? $bottomMenu->parentItems : collect();
        @endphp
        
        @foreach($bottomItems as $item)
            @php
                // Check active state
                $isActive = false;
                if ($item->url === '/' && request()->is('/')) {
                    $isActive = true;
                } elseif ($item->url !== '/' && $item->url !== '#' && request()->is(ltrim($item->url, '/') . '*')) {
                    $isActive = true;
                }
            @endphp
            @if($item->url === '#search')
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'))" class="relative flex flex-col items-center gap-1 w-14 {{ $isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400 hover:text-emerald-600' }} transition-colors outline-none border-0 bg-transparent">
            @else
            <a href="{{ str_starts_with($item->url, '#') || str_starts_with($item->url, 'http') ? $item->url : url($item->url) }}" 
               class="relative flex flex-col items-center gap-1 w-14 {{ $isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400 hover:text-emerald-600' }} transition-colors">
            @endif
                
                <div class="relative">
                    @if($item->icon)
                        @if(str_contains($item->icon, '<svg'))
                            <div class="w-[22px] h-[22px]">{!! $item->icon !!}</div>
                        @else
                            <flux:icon :icon="$item->icon" class="w-[22px] h-[22px]" />
                        @endif
                    @else
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    @endif
                    
                    @if($item->badge)
                        <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500 border border-white dark:border-slate-900"></span>
                        </span>
                    @endif
                </div>
                
                <span class="text-[10px] font-bold {{ $item->badge && $isActive ? 'text-rose-600 dark:text-rose-400' : '' }}">{{ $item->title }}</span>
            @if($item->url === '#search')
            </button>
            @else
            </a>
            @endif
        @endforeach

        <!-- Menu Drawer Trigger (Fixed at the end) -->
        <button onclick="toggleMobileMenu()" class="flex flex-col items-center gap-1 w-14 text-slate-500 dark:text-slate-400 hover:text-emerald-600 transition-colors outline-none">
            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <span class="text-[10px] font-semibold">মেনু</span>
        </button>
    </div>
</nav>
