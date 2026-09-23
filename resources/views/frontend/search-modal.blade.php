<div id="search-modal-container">
    <!-- Backdrop -->
    <div id="search-backdrop"
         class="fixed inset-0 bg-slate-900/40 dark:bg-[#0B1120]/80 backdrop-blur-sm transition-opacity opacity-0 pointer-events-none z-[99]"
         style="transition-duration: 300ms;"></div>

    <!-- Search Modal -->
    <div id="search-modal"
         class="fixed inset-0 z-[100] flex items-start justify-center pt-32 md:pt-40 px-4 sm:px-6 pointer-events-none"
         >

        <!-- Modal Content -->
        <div id="search-modal-content"
             class="relative w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden ring-1 ring-slate-200 dark:ring-zinc-800 flex flex-col max-h-[85vh] transform scale-95 opacity-0 -translate-y-4 transition-all duration-300">

            <form action="{{ route('search') }}" method="GET" class="shrink-0" id="search-form">
                <div class="relative flex items-center p-4 border-b border-slate-100 dark:border-zinc-800">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input name="q"
                           id="search-input"
                           type="text"
                           autocomplete="off"
                           class="w-full bg-transparent border-0 focus:ring-0 focus:border-0 focus:outline-none outline-none shadow-none text-slate-800 dark:text-zinc-100 placeholder-slate-400 text-sm pl-4" style="box-shadow: none;"
                           placeholder="প্রশ্ন, পরীক্ষা, প্রতিষ্ঠান বা বই অনুসন্ধান করুন...">

                    <div id="search-loading" class="absolute right-16 hidden">
                        <svg class="animate-spin h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <button type="button" id="close-search-btn" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 bg-slate-100 dark:bg-zinc-800 dark:hover:text-zinc-300 px-2 py-1 rounded pointer-events-auto cursor-pointer">ESC</button>
                </div>
            </form>

            <div class="overflow-y-auto" id="search-results-container">
                <div id="search-empty-state" class="p-12 text-center">
                    <p class="text-sm text-slate-500 dark:text-zinc-400">যেকোনো কীওয়ার্ড টাইপ করুন (যেমন: বাংলাদেশ, বিসিএস, ঢাকা বিশ্ববিদ্যালয়, কম্পিউটার...)</p>
                </div>

                <div id="search-no-results" class="p-12 text-center hidden">
                    <p class="text-sm text-slate-500 dark:text-zinc-400">কোনো রেজাল্ট পাওয়া যায়নি।</p>
                </div>

                <div id="search-results-list" class="hidden p-4">
                    <h3 class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mb-3 px-2">প্রশ্নসমূহ</h3>
                    <div class="space-y-1" id="search-results-items">
                        <!-- Items injected here -->
                    </div>

                    <div class="mt-6 mb-2 text-center">
                        <a id="search-view-all-link" href="#" class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 flex items-center justify-center gap-1 mx-auto">
                            সকল রেজাল্ট দেখতে ক্লিক করুন <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 dark:bg-zinc-800/50 p-3 shrink-0 flex justify-between items-center text-[10px] text-slate-500 border-t border-slate-100 dark:border-zinc-800 mt-auto">
                <span>সার্চ করে এন্টার চাপলে পূর্ণাঙ্গ রেজাল্ট পেইজে যাবে</span>
                <span class="text-emerald-500 font-medium tracking-wider">Qerobi.Com</span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initSearchModal() {
        const backdrop = document.getElementById('search-backdrop');
        const modal = document.getElementById('search-modal');
        const content = document.getElementById('search-modal-content');
        const input = document.getElementById('search-input');
        const closeBtn = document.getElementById('close-search-btn');

        const loading = document.getElementById('search-loading');
        const emptyState = document.getElementById('search-empty-state');
        const noResults = document.getElementById('search-no-results');
        const resultsList = document.getElementById('search-results-list');
        const resultsItems = document.getElementById('search-results-items');
        const viewAllLink = document.getElementById('search-view-all-link');

        if (!backdrop || !input) return;

        let isOpen = false;
        let timer = null;
        let currentController = null;

        function openModal() {
            if (isOpen) return;
            isOpen = true;

            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100', 'pointer-events-auto');

            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');

            content.classList.remove('opacity-0', '-translate-y-4', 'scale-95');
            content.classList.add('opacity-100', 'translate-y-0', 'scale-100');

            setTimeout(() => input.focus(), 50);
        }

        function closeModal() {
            if (!isOpen) return;
            isOpen = false;

            backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            backdrop.classList.add('opacity-0', 'pointer-events-none');

            modal.classList.remove('pointer-events-auto');
            modal.classList.add('pointer-events-none');

            content.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            content.classList.add('opacity-0', '-translate-y-4', 'scale-95');
        }

        function fetchResults(query) {
            if (query.length < 2) {
                loading.classList.add('hidden');
                resultsList.classList.add('hidden');
                noResults.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            loading.classList.remove('hidden');
            emptyState.classList.add('hidden');

            if (currentController) {
                currentController.abort();
            }
            currentController = new AbortController();

            fetch('/search/live?q=' + encodeURIComponent(query), { signal: currentController.signal })
                .then(response => response.json())
                .then(data => {
                    loading.classList.add('hidden');

                    if (data.results && data.results.length > 0) {
                        noResults.classList.add('hidden');
                        resultsList.classList.remove('hidden');

                        let html = '';
                        data.results.forEach(question => {
                            html += `
                                <a href="/question/${question.slug}" class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-zinc-800/50 transition-colors group">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 shrink-0 mt-0.5">প্রশ্ন</span>
                                    <div class="text-sm text-slate-700 dark:text-zinc-300 font-medium group-hover:text-emerald-600 dark:group-hover:text-emerald-400 line-clamp-1">${question.title}</div>
                                </a>
                            `;
                        });
                        resultsItems.innerHTML = html;
                        viewAllLink.href = '/search?q=' + encodeURIComponent(query);
                    } else {
                        resultsList.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        loading.classList.add('hidden');
                    }
                });
        }

        backdrop.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        closeBtn.addEventListener('click', closeModal);
        window.addEventListener('open-search', openModal);

        input.addEventListener('input', (e) => {
            clearTimeout(timer);
            const val = e.target.value.trim();
            timer = setTimeout(() => fetchResults(val), 300);
        });

        // Expose openModal to window for the header button
        window.openSearchModal = openModal;
        window.closeSearchModal = closeModal;
    }

    document.addEventListener('turbo:load', initSearchModal);
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearchModal);
    } else {
        initSearchModal();
    }
})();

// Global Keyboard Shortcut Listener
// Need to attach this globally outside so it doesn't get bound multiple times on turbo load
if (!window._searchShortcutBound) {
    window._searchShortcutBound = true;
    document.addEventListener('keydown', (e) => {
        // For Windows (Ctrl + K) and Mac (Cmd + K)
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (typeof window.openSearchModal === 'function') {
                window.openSearchModal();
            } else {
                window.dispatchEvent(new CustomEvent('open-search'));
            }
        }

        if (e.key === 'Escape') {
            if (typeof window.closeSearchModal === 'function') {
                window.closeSearchModal();
            }
        }
    });
}
</script>
