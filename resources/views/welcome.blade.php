@extends('layouts.frontend')

@section('title', 'ক্যারিয়াের গড়ার জন্য বিশ্বস্ত ও তথ্যবহু ডিজিটাল প্রশ্নভান্ডার')
@section('description', 'বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও ভর্তি পরীক্ষার বিগত প্রশ্ন, শিক্ষক-যাচাই করা ব্যাখ্যাসহ সমাধান এবং প্রতিষ্ঠানভিত্তিক প্রশ্ন আর্কাইভ।')

@section('content')
    <div id="top" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6 space-y-6 sm:space-y-8">

        <!-- ============================================== -->
        <!-- HERO -->
        <!-- ============================================== -->
        <section class="relative rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-emerald-50/60 via-white to-teal-50/50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] overflow-hidden">

            <div class="absolute inset-0 pointer-events-none bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(15,23,42,0.05)_35px,rgba(15,23,42,0.05)_36px)] dark:bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(148,163,184,0.06)_35px,rgba(148,163,184,0.06)_36px)]"></div>

            <div class="relative grid lg:grid-cols-12 gap-10 px-6 py-10 sm:px-10 sm:py-14">

                <div class="lg:col-span-7 pr-0 lg:pr-8">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-800/50 mb-6 w-max">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-extrabold text-emerald-700 dark:text-emerald-400 tracking-wide">হালনাগাদ ২১ সেপ্টেম্বর, ২০২৬</span>
                    </div>

                    <!-- Main Heading with Gradient -->
                    <h1 class="text-[2.25rem] sm:text-5xl lg:text-[3.5rem] font-extrabold text-slate-900 dark:text-white leading-[1.2] tracking-tight">
                            নির্ভুল, তথ্যবহুল ও ব্যাখ্যাসহ <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300">
                            ডিজিটাল প্রশ্নভান্ডার।
                        </span>
                    </h1>

                    <p class="mt-5 text-[15px] sm:text-[17px] text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl font-medium">
                        বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও ভর্তি পরীক্ষার বিগত প্রশ্ন — প্রতিটি উত্তর শিক্ষক দ্বারা যাচাই করা। ভুল মনে হলে প্রশ্নের নিচেই আপত্তি জানাতে পারবেন।
                    </p>

                    <!-- Search -->
                    <div class="mt-9 max-w-xl">
                        <label for="qb-search" class="block text-[13px] font-semibold text-slate-900 dark:text-slate-300 mb-2">কী খুঁজছেন?</label>
                        <div class="flex items-stretch border-b-2 border-slate-900 dark:border-slate-600 focus-within:border-emerald-500 dark:focus-within:border-emerald-400 focus-within:shadow-[0_4px_16px_-4px_rgba(16,185,129,0.25)] transition-all rounded-t-lg">
                            <span class="flex items-center pl-1 text-slate-400 dark:text-slate-500">
                                <svg class="w-4.5 h-4.5" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input id="qb-search" type="text" readonly
                                   onclick="window.dispatchEvent(new CustomEvent('open-search'))"
                                   placeholder="৫০তম বিসিএস, প্রাথমিক শিক্ষক ২০২৬…"
                                   class="w-full bg-transparent pl-3 pr-1 py-3 text-base sm:text-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none cursor-pointer">
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'))"
                                    class="shrink-0 px-5 py-3 text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-slate-900 dark:hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded transition-colors">
                                খুঁজুন
                            </button>
                        </div>

                        <p class="mt-4 flex items-center gap-3 flex-wrap text-[13px] text-slate-500 dark:text-slate-400 font-medium">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> <span class="font-extrabold text-slate-800 dark:text-slate-200 tabular-nums">৩২০+</span> পরীক্ষা</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> <span class="font-extrabold text-slate-800 dark:text-slate-200 tabular-nums">১২,৪০০+</span> প্রশ্ন</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                            <span>শিক্ষক-যাচাই ব্যাখ্যা</span>
                        </p>

                        <!-- Popular Tags -->
                        <div class="flex flex-wrap items-center gap-2 mt-6">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mr-1">জনপ্রিয়:</span>
                            <a href="#" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-emerald-100 hover:text-emerald-700 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400 transition-colors">শিক্ষক নিয়োগ</a>
                            <a href="#" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-emerald-100 hover:text-emerald-700 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400 transition-colors">বিসিএস প্রশ্ন</a>
                            <a href="#" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-emerald-100 hover:text-emerald-700 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400 transition-colors">মডেল টেস্ট</a>
                        </div>
                    </div>
                </div>

                <!-- Quiet live panel -->
                <aside class="lg:col-span-5 lg:pl-8 lg:border-l border-slate-200 dark:border-slate-800">
                    <h2 class="text-[13px] font-bold text-slate-900 dark:text-slate-300 mb-4">আবেদনের সময় ফুরাচ্ছে</h2>
                    <ul>
                        <li class="group flex items-baseline justify-between gap-4 py-3 border-t border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">খাদ্য অধিদপ্তর, উপ-পরিদর্শক</a>
                            <span class="shrink-0 inline-flex items-center gap-1.5 text-[13px] font-bold text-rose-700 dark:text-rose-300">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-500 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-600"></span>
                                </span>
                                আজ শেষ
                            </span>
                        </li>
                        <li class="group flex items-baseline justify-between gap-4 py-3 border-t border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">বাংলাদেশ রেলওয়ে, ওয়েম্যান</a>
                            <span class="shrink-0 text-xs font-medium text-slate-500 dark:text-slate-400">৪ দিন বাকি</span>
                        </li>
                        <li class="group flex items-baseline justify-between gap-4 py-3 border-y border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">বাংলাদেশ ব্যাংক, অফিসার</a>
                            <span class="shrink-0 text-xs font-medium text-slate-500 dark:text-slate-400">১০ দিন বাকি</span>
                        </li>
                    </ul>
                    <a href="#" class="group inline-flex items-center gap-1.5 mt-4 text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">
                        সব বিজ্ঞপ্তি দেখুন
                        <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                    </a>
                </aside>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- WHAT YOU CAN DO -->
        <!-- ============================================== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-slate-200 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden">
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:-translate-y-0.5 hover:z-10 hover:shadow-lg transition-all">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">জব সল্যুশন</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">বিগত পরীক্ষার প্রশ্ন, ব্যাখ্যাসহ উত্তর</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:-translate-y-0.5 hover:z-10 hover:shadow-lg transition-all">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">প্রশ্ন আর্কাইভ</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">প্রতিষ্ঠান ও সাল ধরে সাজানো</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:-translate-y-0.5 hover:z-10 hover:shadow-lg transition-all">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">মডেল টেস্ট</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">সময় ধরে পরীক্ষা, সঙ্গে সঙ্গে ফল</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:-translate-y-0.5 hover:z-10 hover:shadow-lg transition-all">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">শিক্ষকের সহায়তা</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">আটকে গেলে প্রশ্ন করুন, উত্তর পাবেন</p>
            </a>
        </section>

        <!-- ============================================== -->
        <!-- ARCHIVE INDEX + ACADEMIC -->
        <!-- ============================================== -->
        <section class="grid lg:grid-cols-12 gap-10 lg:gap-14">

            <div class="lg:col-span-7">
                <div class="flex items-baseline justify-between mb-5">
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">প্রতিষ্ঠানভিত্তিক আর্কাইভ</h2>
                    <a href="{{ route('job-solutions.index') }}" class="group inline-flex items-center gap-1.5 text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">
                        সব দেখুন
                        <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                    </a>
                </div>

                <ul>
                    @foreach($topOrganizations as $org)
                    <li>
                        <a href="{{ route('organization.show', $org->slug) }}" class="group flex items-center justify-between gap-6 px-1 py-4 border-t {{ $loop->last ? 'border-b' : '' }} border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 truncate">{{ $org->name }}</span>
                            <span class="flex items-center gap-2.5 shrink-0">
                                <span class="text-xs text-slate-500 dark:text-slate-400 tabular-nums">{{ $org->past_exams_count }}টি পরীক্ষা</span>
                                <span class="opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 text-emerald-600 dark:text-emerald-400 transition-all">→</span>
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">একাডেমিক ও ভর্তি</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">এসএসসি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">বোর্ড প্রশ্ন ও অধ্যায়ভিত্তিক টেস্ট</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">এইচএসসি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">সব বোর্ডের বিগত প্রশ্ন সমাধান</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">বিশ্ববিদ্যালয় ভর্তি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">ঢাবি, রাবি, চবি ও গুচ্ছ</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">মেডিকেল ও বুয়েট</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">বিগত বছরের প্রশ্ন ও মডেল টেস্ট</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- RECENT SOLUTIONS -->
        <!-- ============================================== -->
        <section>
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">সদ্য যুক্ত সমাধান</h2>
                <a href="{{ route('job-solutions.index') }}" class="group inline-flex items-center gap-1.5 text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">
                    সব সমাধান
                    <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach($recentExams as $exam)
                <a href="{{ route('job-solutions.show', [$exam->organization->slug, $exam->slug]) }}" class="group relative flex items-stretch rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] overflow-hidden hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                    @if($loop->first)
                        <span class="absolute top-3 right-3 text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">নতুন</span>
                    @endif
                    <div class="flex flex-col justify-center gap-2.5 px-3.5 bg-slate-50 dark:bg-[#0B1120] border-r border-slate-200 dark:border-slate-800" aria-hidden="true">
                        <span class="w-2.5 h-2.5 rounded-full border-2 {{ $loop->index % 4 == 0 ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300 dark:border-slate-700' }}"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 {{ $loop->index % 4 == 1 ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300 dark:border-slate-700' }}"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 {{ $loop->index % 4 == 2 ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300 dark:border-slate-700' }}"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 {{ $loop->index % 4 == 3 ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300 dark:border-slate-700' }}"></span>
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-2.5">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $exam->organization->name ?? 'অজানা প্রতিষ্ঠান' }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                            <span>{{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->translatedFormat('d F, Y') : 'N/A' }}</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-slate-900 dark:text-white leading-[1.6] group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors {{ $loop->first ? 'pr-10' : '' }}">
                            {{ $exam->title }}
                        </h3>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ strtoupper($exam->type ?? 'MCQ') }}
                            </span>
                            @if($exam->total_questions)
                                <span class="text-[13px] text-slate-500 dark:text-slate-400">{{ $exam->total_questions }}টি প্রশ্ন</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <!-- ============================================== -->
        <!-- CIRCULARS -->
        <!-- ============================================== -->
        <section>
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">চলমান নিয়োগ বিজ্ঞপ্তি</h2>
                <a href="#" class="group inline-flex items-center gap-1.5 text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">
                    সব বিজ্ঞপ্তি
                    <span class="inline-block transition-transform group-hover:translate-x-0.5">→</span>
                </a>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-800">

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-rose-500 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                    <div class="flex items-center gap-1.5 text-[13px] font-bold text-rose-600 dark:text-rose-400">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <span>আজ শেষ</span>
                            <span class="block text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">১৮ সেপ্টেম্বর</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">খাদ্য অধিদপ্তর — উপ-খাদ্য পরিদর্শক</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">৪১০টি পদ। স্নাতক পাস প্রার্থীরা অনলাইনে আবেদন করতে পারবেন।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-transparent hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <span class="text-[13px] font-bold text-slate-900 dark:text-slate-200">৪ দিন বাকি</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">২২ সেপ্টেম্বর</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">বাংলাদেশ রেলওয়ে — ওয়েম্যান</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">১৩৮৫টি পদ। অষ্টম শ্রেণি পাস হলেই আবেদন করা যাবে।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-transparent hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <span class="text-[13px] font-bold text-slate-900 dark:text-slate-200">১০ দিন বাকি</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">২৮ সেপ্টেম্বর</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">বাংলাদেশ ব্যাংক — অফিসার (জেনারেল)</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">২৫০টি পদ। প্রিলিমিনারি পরীক্ষা ডিসেম্বরে হওয়ার সম্ভাবনা।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

            </div>
        </section>

        <!-- ============================================== -->
        <!-- TRUST / STATS BAND — bridges content and footer -->
        <!-- ============================================== -->
        <section class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] px-6 py-6 sm:py-7">
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-slate-200 dark:divide-slate-800 text-center">
                <div class="px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tabular-nums">৩২০+</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">সংরক্ষিত পরীক্ষা</div>
                </div>
                <div class="px-2">
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 tabular-nums">১২,৪০০+</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">সমাধানকৃত প্রশ্ন</div>
                </div>
                <div class="px-2 border-t sm:border-t-0 border-slate-200 dark:border-slate-800 pt-4 sm:pt-0 mt-4 sm:mt-0">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tabular-nums">৪১+</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">প্রতিষ্ঠান কভার</div>
                </div>
                <div class="px-2 border-t sm:border-t-0 border-slate-200 dark:border-slate-800 pt-4 sm:pt-0 mt-4 sm:mt-0">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">১০০%</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">শিক্ষক-যাচাই ব্যাখ্যা</div>
                </div>
            </div>
        </section>

    </div>

@endsection
