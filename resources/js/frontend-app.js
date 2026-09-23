import * as Turbo from "@hotwired/turbo";
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import 'katex/dist/katex.min.css';
import './security-shield';

// --- Alpine.js Setup ---
window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.start();

// --- Turbo Drive Customization ---
document.addEventListener("turbo:load", function() {
    const progressBar = document.querySelector('.turbo-progress-bar');
    if (progressBar) {
        progressBar.style.backgroundColor = '#10b981'; // Emerald Color
    }
});

// --- MathJax/KaTeX Rendering Setup ---
window.renderKatex = async function() {
    // Check if the page actually contains math-related elements to save bandwidth (optional but good for performance)
    // We check for common math delimiters or specific math attributes
    const hasMath = document.querySelector('[data-math-content], script[type^="math/tex"]') !== null ||
                    document.body.innerHTML.includes('$$') ||
                    document.body.innerHTML.includes('\\[');

    if (!hasMath) {
        document.body.classList.remove('math-loading');
        return;
    }

    try {
        // Dynamically import KaTeX and its CSS only when needed
        // This removes them from the main bundle, drastically improving initial load speed
        const [katexModule, renderMathModule] = await Promise.all([
            import('katex'),
            import('katex/dist/contrib/auto-render')
        ]);

        const katex = katexModule.default;
        const renderMathInElement = renderMathModule.default;

        renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '\\[', right: '\\]', display: true},
                {left: '$', right: '$', display: false},
                {left: '\\(', right: '\\)', display: false}
            ],
            throwOnError: false,
            ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code", "div.ck-editor-container"]
        });

        // Fallback for old MathJax elements
        document.querySelectorAll('script[type="math/tex"]').forEach(el => {
            let tex = el.textContent || el.innerText;
            let span = document.createElement('span');
            try {
                katex.render(tex, span, { displayMode: false, throwOnError: false });
                el.replaceWith(span);
            } catch(e) {}
        });

        document.querySelectorAll('script[type="math/tex; mode=display"]').forEach(el => {
            let tex = el.textContent || el.innerText;
            let div = document.createElement('div');
            try {
                katex.render(tex, div, { displayMode: true, throwOnError: false });
                el.replaceWith(div);
            } catch(e) {}
        });
    } catch (error) {
        console.error("Failed to load KaTeX:", error);
    } finally {
        document.body.classList.remove('math-loading');
    }
};


// --- Initial load & Turbo render hooks (Flicker-Free) ---

// ১. ওয়েবসাইটের প্রথমবার লোড হওয়ার জন্য (First direct visit)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.renderKatex === 'function') window.renderKatex();
    });
} else {
    if (typeof window.renderKatex === 'function') window.renderKatex();
}

// ২. এক লিংক থেকে অন্য লিংকে যাওয়ার জন্য (Turbo Navigation)
document.addEventListener('turbo:render', () => {
    if (typeof window.renderKatex === 'function') {
        window.renderKatex();
    }
});
