@extends('layouts.frontend')

@section('title', '৪২৯ - অতিরিক্ত রিকোয়েস্ট | Qerobi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-20">
        <section class="relative text-center rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-emerald-50/60 via-white to-teal-50/50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] overflow-hidden px-6 py-16 sm:py-24">

            <div class="absolute inset-0 pointer-events-none bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(15,23,42,0.05)_35px,rgba(15,23,42,0.05)_36px)] dark:bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(148,163,184,0.06)_35px,rgba(148,163,184,0.06)_36px)]"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-50 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-800/50 mb-6 w-max mx-auto">
                    <span class="text-sm font-extrabold text-orange-600 dark:text-orange-400 tracking-wide">এরর ৪২৯ (429)</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-[1.3] tracking-tight mb-5">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500 dark:from-orange-400 dark:to-amber-300">
                    একটু ধীরে!
                </span>
                </h1>

                <p class="text-base sm:text-[17px] text-slate-600 dark:text-slate-400 max-w-xl mx-auto mb-10 leading-relaxed font-medium">
                    আপনি খুব কম সময়ে অনেক বেশি রিকোয়েস্ট পাঠিয়েছেন। সার্ভারকে একটু বিশ্রাম দিন এবং কিছুক্ষণ অপেক্ষা করে আবার চেষ্টা করুন।
                </p>

                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    হোমপেজে ফিরে যান
                </a>
            </div>
        </section>
    </div>
@endsection
