import $ from "jquery";
import TomSelect from "tom-select";
import ApexCharts from "apexcharts";

// Global Window Objects
window.TomSelect = TomSelect;
window.ApexCharts = ApexCharts;
window.$ = window.jQuery = $;

// ==========================================
// ১. UI কাস্টম এলিমেন্ট (ui-modal) কনফ্লিক্ট রোধ (Local Dev / HMR Fix)
// ==========================================
if (typeof customElements !== 'undefined') {
    const originalDefine = customElements.define;
    customElements.define = function(name, constructor, options) {
        if (!customElements.get(name)) {
            originalDefine.call(customElements, name, constructor, options);
        }
    };
}

// ==========================================
// ২. Alpine & Plugins (Alpine components)
// ==========================================
// Alpine is started directly without a server-side UI runtime
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(collapse);


// ==========================================
// ৩. পৃষ্ঠা টোস্ট ইভেন্টস
// ==========================================
window.addEventListener('success', event => {
    let msg = event.detail?.message || (event.detail?.[0] && event.detail[0]?.message);
    if (msg && window.AppUI) window.AppUI.toast({ text: msg, variant: 'success' });
});
window.addEventListener('warning', event => {
    let msg = event.detail?.message || (event.detail?.[0] && event.detail[0]?.message);
    if (msg && window.AppUI) window.AppUI.toast({ text: msg, variant: 'warning' });
});
window.addEventListener('error', event => {
    let msg = event.detail?.message || (event.detail?.[0] && event.detail[0]?.message);
    if (msg && window.AppUI) window.AppUI.toast({ text: msg, variant: 'danger' });
});


// ==========================================
// ৪. MathJax/KaTeX Rendering Hooks
// ==========================================
import renderMathInElement from 'katex/dist/contrib/auto-render';
import katex from 'katex';
import 'katex/dist/katex.min.css';

window.renderKatex = function() {
    renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},
            {left: '\\[', right: '\\]', display: true},
            {left: '$', right: '$', display: false},
            {left: '\\(', right: '\\)', display: false}
        ],
        throwOnError: false,
        ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code", "div.ck-editor-container", "ui-toast"]
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

    document.body.classList.remove('math-loading');
};

// Auto-render on initial load
setTimeout(window.renderKatex, 100);

window.renderMathJax = function () {
    setTimeout(() => {
        window.renderKatex();
    }, 100);
};

// MathJax/KaTeX এর জন্য ইভেন্ট লিসেনারসমূহ
document.addEventListener('DOMContentLoaded', window.renderMathJax);
window.addEventListener('practice-content-updated', window.renderMathJax);

// Prevent page controller from overwriting KaTeX rendered math during component updates (prevents flickering)



// ==========================================
// ৫. UI delete confirmation
// ==========================================
window.confirmDeleteAction = function (callback) {
    window.pendingDeleteAction = callback;
    if (window.AppUI && typeof window.AppUI.modal === 'function') {
        window.AppUI.modal('delete-confirmation').show();
    } else {
        document.dispatchEvent(new CustomEvent('modal-show', { bubbles: true, detail: { name: 'delete-confirmation' } }));
    }
};

window.confirmPendingDeletion = function () {
    const callback = window.pendingDeleteAction;

    window.pendingDeleteAction = null;
    if (window.AppUI && typeof window.AppUI.modal === 'function') {
        window.AppUI.modal('delete-confirmation').close();
    } else {
        document.dispatchEvent(new CustomEvent('modal-close', { bubbles: true, detail: { name: 'delete-confirmation' } }));
    }

    if (typeof callback === 'function') {
        callback();
    }
};


// ==========================================
// ৬. Global CKEditor & MathJax Helpers
// ==========================================
window.wrapMathForCKEditor = function(html) {
    if (!html || typeof html !== 'string') return html;
    let cleanHtml = html.replace(/<span class="math-tex">([\s\S]*?)<\/span>/g, '$1');

    // Convert $...$ to \(...\)
    cleanHtml = cleanHtml.replace(/(^|[^\\])\$([^\$]+?)\$/g, '$1\\($2\\)');

    cleanHtml = cleanHtml.replace(/\\\(([\s\S]*?)\\\)/g, '<span class="math-tex">\\($1\\)</span>');
    cleanHtml = cleanHtml.replace(/\\\[([\s\S]*?)\\\]/g, '<span class="math-tex">\\[$1\\]</span>');
    return cleanHtml;
};

window.initGlobalCkEditor = function(elementId, pageComponent, pageProperty, isAdvanced = false) {
    const el = document.getElementById(elementId);
    if (!el || el.offsetParent === null) return null;

    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[elementId]) {
        try { CKEDITOR.instances[elementId].destroy(true); } catch(e) {}
    }

    let toolbarConfig = [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Subscript', 'Superscript'] },
        { name: 'insert', items: ['SpecialCharacter', 'Mathjax'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'document', items: ['Source'] }
    ];

    if (isAdvanced) {
        toolbarConfig = [
            { name: 'clipboard', items: ['Undo', 'Redo'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialCharacter', 'Mathjax'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize'] },
            { name: 'document', items: ['Source'] }
        ];
    }

    const editor = CKEDITOR.replace(elementId, {
        extraPlugins: 'mathjax,tableresize,wordcount,notification,justify,font,colorbutton',
        mathJaxLib: '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
        toolbar: toolbarConfig,
        height: isAdvanced ? 180 : 120,
        allowedContent: true,
        uiColor: document.documentElement.classList.contains('dark') ? '#2d3748' : '#f9fafb'
    });

    editor.on('instanceReady', function() {
        let currentData = editor.getData();
        let formattedData = window.wrapMathForCKEditor(currentData);
        if (currentData !== formattedData) {
            editor.setData(formattedData);
        }
    });

    editor.on('paste', function(evt) {
        evt.data.dataValue = window.wrapMathForCKEditor(evt.data.dataValue);
    });

    if (pageProperty && pageComponent) {
        let ckDebounceTimer;
        editor.on('change', function () {
            let data = editor.getData();
            clearTimeout(ckDebounceTimer);
            ckDebounceTimer = setTimeout(() => {
                if (typeof pageComponent.set === 'function') {
                    pageComponent.set(pageProperty, data);
                } else if (typeof pageComponent.$set === 'function') {
                    pageComponent.$set(pageProperty, data);
                } else {
                    pageComponent[pageProperty] = data;
                }
                if (pageProperty === 'title') {
                    let isEditMode = window.location.href.includes('/edit');
                    let slugInput = document.getElementById('slug_input');
                    if (slugInput) {
                        let isManualEdited = slugInput.getAttribute('data-manual') === 'true';
                        let isSlugEmpty = slugInput.value.trim() === '';
                        if ((!isEditMode || isSlugEmpty) && !isManualEdited) {
                            let div = document.createElement("div");
                            div.innerHTML = data;
                            let plainText = div.innerText || div.textContent || "";
                            let newSlug = plainText.trim().toLowerCase().replace(/[^\w\u0980-\u09FF\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '').substring(0, 100);
                            window.dispatchEvent(new CustomEvent('slug-auto-updated', { detail: newSlug }));
                        }
                    }
                }
            }, 500);
        });
    }

    return editor;
};

// Global cleanup for CKEditor to avoid memory leaks or duplicate instances on page navigation
window.addEventListener('beforeunload', () => {
    if (typeof CKEDITOR !== 'undefined') {
        for (let instanceName in CKEDITOR.instances) {
            try { CKEDITOR.instances[instanceName].destroy(true); } catch(e) {}
        }
    }
});


const normalizeFieldName = name => name.replace(/\.([^.]+)/g, '[$1]');
const parseAction = expression => {
    const match = String(expression || '').trim().match(/^([\w$]+)(?:\((.*)\))?$/s);
    if (!match) return null;
    let args = [];
    if (match[2]?.trim()) {
        try { args = Function(`"use strict"; return [${match[2]}]`)(); } catch (_) { args = []; }
    }
    return { name: match[1], args };
};
const submitPageAction = (expression, source = document.body) => {
    const action = parseAction(expression);
    if (!action) return;
    const form = source.closest?.('form') || document.createElement('form');
    if (!form.isConnected) document.body.appendChild(form);
    form.method = 'POST';
    form.action = window.location.href;
    if (!form.querySelector('[name="_token"]')) {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        form.insertAdjacentHTML('beforeend', `<input type="hidden" name="_token" value="${token || ''}">`);
    }
    [[' _action'.trim(), action.name], ['_arguments', JSON.stringify(action.args)]].forEach(([name, value]) => {
        let input = form.querySelector(`[name="${name}"]`);
        if (!input) { input = document.createElement('input'); input.type = 'hidden'; input.name = name; form.appendChild(input); }
        input.value = value;
    });
    form.submit();
};

window.Page = new Proxy(window.__pageState || {}, {
    get(target, property) {
        if (property === 'set' || property === '$set') return (name, value) => {
            target[name] = value;
            const control = document.querySelector(`[data-page-model="${name}"], [data-page-model\\.live="${name}"]`);
            if (control) control.value = value ?? '';
        };
        if (property === 'upload') return (name, file) => {
            const control = document.querySelector(`[data-page-model="${name}"]`);
            if (control && file) { const transfer = new DataTransfer(); transfer.items.add(file); control.files = transfer.files; }
        };
        if (property in target) return target[property];
        return (...args) => submitPageAction(`${String(property)}(${args.map(JSON.stringify).join(',')})`);
    }
});
Alpine.magic('page', () => window.Page);

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-page-model], [data-page-model\\.live], [data-page-model\\.defer]').forEach(control => {
        const model = control.getAttribute('data-page-model') || control.getAttribute('data-page-model.live') || control.getAttribute('data-page-model.defer');
        if (!control.name) control.name = normalizeFieldName(model);
        if (window.__pageState?.[model] !== undefined && !control.value) control.value = window.__pageState[model] ?? '';
    });
    document.querySelectorAll('[data-page-submit], [data-page-submit\\.prevent]').forEach(form => form.addEventListener('submit', event => {
        event.preventDefault();
        submitPageAction(form.getAttribute('data-page-submit') || form.getAttribute('data-page-submit.prevent'), form);
    }));
    document.querySelectorAll('[data-page-click], [data-page-click\\.prevent]').forEach(element => element.addEventListener('click', event => {
        event.preventDefault();
        const confirmation = element.getAttribute('data-page-confirm');
        if (confirmation && !window.confirm(confirmation)) return;
        submitPageAction(element.getAttribute('data-page-click') || element.getAttribute('data-page-click.prevent'), element);
    }));
    Alpine.start();
});
