@extends('layouts.frontend')

@section('title', '৫০৩ - রক্ষণাবেক্ষণের কাজ চলছে | Qerobi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-20">
        <section class="relative text-center rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-emerald-50/60 via-white to-teal-50/50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] overflow-hidden px-6 py-16 sm:py-24">

            <div class="absolute inset-0 pointer-events-none bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(15,23,42,0.05)_35px,rgba(15,23,42,0.05)_36px)] dark:bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(148,163,184,0.06)_35px,rgba(148,163,184,0.06)_36px)]"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-800/50 mb-6 w-max mx-auto">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                    <span class="text-sm font-extrabold text-emerald-700 dark:text-emerald-400 tracking-wide">আপডেট চলমান (503)</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-[1.3] tracking-tight mb-5">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300">
                    সাইট আপডেটের কাজ চলছে!
                </span>
                </h1>

                <p class="text-base sm:text-[17px] text-slate-600 dark:text-slate-400 max-w-xl mx-auto mb-10 leading-relaxed font-medium">
                    আপনাদের আরও উন্নত সেবা দেওয়ার লক্ষ্যে বর্তমানে আমাদের ওয়েবসাইটে রক্ষণাবেক্ষণের কাজ চলছে। খুব শীঘ্রই আমরা নতুন রূপে ফিরে আসছি। সাময়িক এই অসুবিধার জন্য আমরা আন্তরিকভাবে দুঃখিত।
                </p>

                <div class="flex items-center justify-center gap-3">
                    <a href="mailto:support@qerobi.com" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        যোগাযোগ করুন
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
