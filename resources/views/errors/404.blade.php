@extends('layouts.frontend')

@section('title', '৪০৪ - পেইজটি খুঁজে পাওয়া যায়নি | Qerobi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-20">
        <section class="relative text-center rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-emerald-50/60 via-white to-teal-50/50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] overflow-hidden px-6 py-16 sm:py-24">

            <!-- Background Grid Pattern -->
            <div class="absolute inset-0 pointer-events-none bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(15,23,42,0.05)_35px,rgba(15,23,42,0.05)_36px)] dark:bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(148,163,184,0.06)_35px,rgba(148,163,184,0.06)_36px)]"></div>

            <div class="relative z-10">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-800/50 mb-6 w-max mx-auto">
                    <span class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400 tracking-wide">এরর ৪০৪ (404)</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-[1.3] tracking-tight mb-5">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 dark:from-indigo-400 dark:to-blue-300">
                    পেইজটি খুঁজে পাওয়া যায়নি!
                </span>
                </h1>

                <!-- Description -->
                <p class="text-base sm:text-[17px] text-slate-600 dark:text-slate-400 max-w-xl mx-auto mb-10 leading-relaxed font-medium">
                    দুঃখিত, আপনি যে পেইজটি খুঁজছেন তা হয়তো মুছে ফেলা হয়েছে, নাম পরিবর্তন করা হয়েছে অথবা সাময়িকভাবে অনুপলব্ধ। দয়া করে ওয়েবসাইটের ইউআরএল (URL) সঠিক কি না তা চেক করুন।
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-lg transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        হোমপেজে ফিরে যান
                    </a>
                    <a href="{{ route('job-solutions.index') ?? '#' }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors shadow-sm w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        প্রশ্নভান্ডার খুঁজুন
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
