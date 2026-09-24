<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Create your TaskNex workspace.">
    <title>{{ $title ?? config('app.name', 'TaskNex') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 min-h-full text-text-primary">
    <main class="relative min-h-dvh overflow-hidden">
        <div class="relative flex min-h-dvh w-full flex-col min-[901px]:flex-row">

            <section class="relative flex min-h-dvh w-full flex-col px-5 py-7 min-[901px]:order-2 min-[901px]:px-12 min-[901px]:py-12 min-[1081px]:px-15 min-[901px]:basis-1/2">
                <header class="flex items-center justify-between">
                    <button type="button" class="group inline-flex items-center gap-3 bg-transparent p-0 text-left" data-notice="Welcome back to your workspace" aria-label="Open TaskNex home">
                        <span class="grid h-10 w-10 rotate-[-8deg] place-items-center rounded-[11px] bg-accent text-surface-raised shadow-[0_0_24px_rgb(199_243_107/16%)] transition-transform duration-200 group-hover:rotate-0" aria-hidden="true">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        <span class="font-display text-3xl font-extrabold tracking-tighter">tasknex<span class="text-accent">.</span></span>
                    </button>
                    <div class="text-xs text-slate-400 flex items-center gap-2">
                        <span class="">Already have an account?</span>
                        <a href="#signin"
                            class="text-accent font-semibold hover:underline underline-offset-2 transition-colors cursor-pointer">Sign
                            in</a>
                    </div>


                </header>

                <div class="mx-auto flex w-full max-w-120 flex-1 flex-col justify-center pt-16 pb-8 max-[480px]:pt-13">
                    {{-- <div class="mb-4 flex items-center gap-2 text-[10px] font-extrabold tracking-[0.2em] text-danger uppercase">
                        <span class="status-dot"></span>
                        Your next chapter
                    </div> --}}
                    <h1 class="font-display max-w-97.5 text-[clamp(2.5rem,5vw,4rem)] leading-[0.98] font-semibold tracking-[-0.075em] max-[480px]:text-[2.7rem]">
                        Signup<span class="text-accent">.</span>
                    </h1>
                    <p class="mt-5 mb-8 max-w-87.5 text-[13px] leading-[1.85] text-text-secondary"></p>

                    <div id="form-view">
                        <form class="grid gap-4" id="signup-form" novalidate>
                            <div class="grid gap-2">
                                <label class="field-label" for="signup-name">Your name</label>
                                <div class="relative">
                                    <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input class="field-input" id="signup-name" name="name" placeholder="Maya Chen" autocomplete="name">
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <label class="field-label" for="signup-email">Email address</label>
                                <div class="relative">
                                    <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                        <path d="m3 7 9 6 9-6"></path>
                                    </svg>
                                    <input class="field-input" id="signup-email" type="email" name="email" placeholder="maya@somewhere.good" autocomplete="email">
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <label class="field-label" for="signup-password">Password</label>
                                    <span class="mr-1 inline-flex items-center gap-1 text-[10px] text-text-muted">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                            <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                        </svg>
                                        Keep it private
                                    </span>
                                </div>
                                <div class="relative">
                                    <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                    </svg>
                                    <input class="field-input pr-12" id="signup-password" type="password" name="password" placeholder="At least 8 characters" autocomplete="new-password">
                                    <button class="absolute top-1/2 right-3 grid h-7 w-7 -translate-y-1/2 place-items-center rounded-md text-text-muted hover:bg-surface-hover hover:text-text-primary" id="password-toggle" type="button" aria-label="Show password">
                                        <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                            <circle cx="12" cy="12" r="2.5"></circle>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1 flex flex-wrap gap-x-4 gap-y-2" aria-live="polite">
                                    <span class="password-check" data-check="length"><span class="check-dot"></span>8 characters</span>
                                    <span class="password-check" data-check="number"><span class="check-dot"></span>One number</span>
                                    <span class="password-check" data-check="uppercase"><span class="check-dot"></span>One uppercase letter</span>
                                </div>
                            </div>


                            <label class="flex cursor-pointer items-start gap-3 pt-7 pb-2 text-[11px] leading-[1.8] text-text-secondary transition-colors duration-200">
                                <input class="peer sr-only" id="terms" type="checkbox">
                                <span class="mt-0.5 grid h-4 w-4 flex-none place-items-center rounded-[5px] border border-[#596079] text-surface-raised peer-checked:border-accent peer-checked:bg-accent" aria-hidden="true">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m5 12 4 4L19 6"></path>
                                    </svg>
                                </span>

                                <span>
                                    I agree to the
                                    <button class="font-bold underline-offset-2 text-accent hover:underline hover:text-accent-hover" type="button" data-notice="Terms opened">terms</button>
                                    and
                                    <button class="font-bold text-accent underline-offset-2 hover:underline hover:text-accent-hover" type="button" data-notice="Privacy policy opened">privacy policy</button>.
                                </span>
                            </label>

                            <p class="hidden rounded-lg border border-danger/25 bg-danger/8 px-3 py-2 text-[11px] font-bold text-[#ffad9c]" id="error-message" role="alert"></p>

                            <button class="btn-primary cursor-pointer" type="submit">
                                Create your account
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m13 6 6 6-6 6"></path>
                                </svg>
                            </button>

                            <div class="flex items-center gap-3 py-1 before:h-px before:flex-1 before:bg-border before:content-[''] after:h-px after:flex-1 after:bg-border after:content-['']">
                                <span class="text-[10px] tracking-[0.16em] text-text-muted uppercase">or continue with</span>
                            </div>

                            <button class="btn-secondary cursor-pointer" type="button" data-notice="Google sign-up is ready to connect">
                                <span class="grid h-5 w-5 place-items-center rounded-full bg-text-primary text-[10px] font-black text-[#283244]"><i class="fa-brands fa-google"></i></span>
                                Continue with Google
                            </button>
                        </form>
                    </div>

                    <div class="hidden rounded-2xl border border-accent/25 bg-[#1c2a20]/70 p-6 shadow-[0_18px_50px_rgb(0_0_0/18%)]" id="success-view">
                        <div class="mb-5 grid h-12 w-12 place-items-center rounded-2xl bg-accent/12 text-accent">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m5 12 4 4L19 6"></path>
                            </svg>
                        </div>
                        <h2 class="font-display mb-2 text-2xl tracking-[-0.04em]">Your space is ready.</h2>
                        <p class="text-[13px] leading-[1.85] text-[#9ca290]">We saved the first step for <strong id="success-email"></strong>. Your TaskNex workspace is ready when you are.</p>
                        <button class="btn-primary mt-6 w-auto px-4" type="button" data-notice="Workspace opened">
                            Open your workspace
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m13 6 6 6-6 6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <footer class="flex items-center justify-between border-t border-[#25273a] pt-5 max-[480px]:flex-col max-[480px]:items-start max-[480px]:gap-3">
                    <span class="text-[11px] text-text-muted">© 2025 TaskNex.</span>
                    {{-- <span class="inline-flex items-center gap-1.5 text-[11px] text-text-muted"><span class="status-dot text-accent"></span>Private by default</span> --}}
                </footer>
            </section>

            <aside class="relative hidden min-h-dvh flex-col overflow-hidden border-l border-border bg-surface-sidebar/72 px-10 py-10 min-[901px]:order-1 min-[901px]:flex min-[901px]:basis-1/2 min-[1081px]:px-16">
                <div class="mx-auto flex w-full max-w-140 flex-1 flex-col justify-center gap-7 py-10">
                    <div>
                        <div class="mb-4 flex items-center gap-2 text-[10px] font-extrabold tracking-[0.2em] text-danger uppercase">
                            <span class="status-dot"></span>
                            a calmer command center
                        </div>
                        <h2 class="font-display max-w-140 text-[clamp(2.4rem,4vw,4.4rem)] leading-[0.97] font-semibold tracking-[-0.075em]">Keep the good stuff close<span class="text-accent">.</span></h2>
                        <p class="mt-5 mb-0 max-w-110 text-[13px] leading-[1.85] text-text-secondary">TaskNex is a quieter way to organize your tasks, stay focused, and make room for what matters.</p>
                    </div>

                    <!-- Redesigned Task Visual Preview / Showcase Widget -->
                    <div class="relative overflow-hidden rounded-[26px] border border-white/8 bg-linear-to-b from-[#181a28]/95 via-[#131422]/95 to-[#0e101a]/95 p-6 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.6),0_0_35px_rgba(199,243,107,0.03)] backdrop-blur-2xl">
                        <!-- Subtle top ambient light line -->
                        <div class="pointer-events-none absolute inset-x-8 top-0 h-px bg-linear-to-r from-transparent via-accent/35 to-transparent"></div>

                        <!-- Header bar with "LIVE PREVIEW" badge and simulated window / workspace controls -->
                        <div class="flex items-center justify-between border-b border-white/6 pb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-accent/25 bg-accent/10 px-2.5 py-0.5 text-[9px] font-black tracking-widest text-accent uppercase">
                                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-accent"></span>
                                    Daily Flow
                                </span>
                                <span class="text-[11px] font-medium text-text-muted">· Focus Session</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-text-muted/60">
                                <span class="h-2 w-2 rounded-full bg-white/10"></span>
                                <span class="h-2 w-2 rounded-full bg-white/10"></span>
                                <span class="h-2 w-2 rounded-full bg-accent/40"></span>
                            </div>
                        </div>

                        <!-- Momentum status metric bar -->
                        <div class="mt-4 flex items-baseline justify-between">
                            <div>
                                <div class="text-[10px] font-extrabold tracking-[0.16em] text-text-muted uppercase">Today's Rhythm</div>
                                <div class="font-display mt-0.5 text-xl font-bold tracking-tight text-text-primary">A little momentum</div>
                            </div>
                            <div class="text-right">
                                <div class="font-display text-sm font-bold text-accent">68%</div>
                                <div class="text-[9px] tracking-wider text-text-muted uppercase">completed</div>
                            </div>
                        </div>

                        <!-- Interactive-looking floating task item cards (clearly distinct from inputs) -->
                        <div class="mt-4 space-y-2.5">
                            <!-- Completed task -->
                            <div class="group flex items-center justify-between rounded-xl border border-accent/20 bg-accent/5 px-3.5 py-2.5 transition duration-150">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="grid h-5 w-5 flex-none place-items-center rounded-lg bg-accent text-surface shadow-[0_0_12px_rgba(199,243,107,0.35)]">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4L19 6"></path></svg>
                                    </span>
                                    <div class="truncate">
                                        <div class="truncate text-[12px] font-semibold text-text-muted line-through">Sketch the opening scene</div>
                                        <div class="text-[10px] text-accent/80 font-medium">Completed · Creative Flow</div>
                                    </div>
                                </div>
                                <span class="rounded bg-accent/15 px-1.5 py-0.5 text-[9px] font-bold text-accent flex-none ml-2">Done</span>
                            </div>

                            <!-- In-progress / active priority task -->
                            <div class="group flex items-center justify-between rounded-xl border border-white/8 bg-[#1a1c2c]/80 px-3.5 py-2.5 shadow-sm transition hover:border-white/15">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="grid h-5 w-5 flex-none place-items-center rounded-lg border border-danger/40 bg-danger/10 text-danger">
                                        <span class="h-1.5 w-1.5 rounded-full bg-danger"></span>
                                    </span>
                                    <div class="truncate">
                                        <div class="truncate text-[12px] font-semibold text-text-primary">Read three pages of The Dawn</div>
                                        <div class="text-[10px] text-text-muted">Reading · Next up</div>
                                    </div>
                                </div>
                                <span class="rounded bg-white/6 px-1.5 py-0.5 text-[9px] font-medium text-text-secondary flex-none ml-2">15 min</span>
                            </div>

                            <!-- Upcoming queue task -->
                            <div class="group flex items-center justify-between rounded-xl border border-white/5 bg-[#141624]/60 px-3.5 py-2.5 transition hover:border-white/10">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="grid h-5 w-5 flex-none place-items-center rounded-lg border border-[#3f435a] bg-transparent text-text-muted">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#525775]"></span>
                                    </span>
                                    <div class="truncate">
                                        <div class="truncate text-[12px] font-medium text-[#c5c7d4]">Plan Saturday's dinner</div>
                                        <div class="text-[10px] text-text-muted">Life admin · Later</div>
                                    </div>
                                </div>
                                <span class="rounded bg-info/10 px-1.5 py-0.5 text-[9px] font-medium text-info flex-none ml-2">Evening</span>
                            </div>
                        </div>

                        <!-- Visual progress tracker footer -->
                        <div class="mt-4 flex items-center justify-between border-t border-white/6 pt-3.5 text-[10px] text-text-muted">
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                                <span>One calm thing at a time</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-accent">1 of 3</span>
                                <div class="h-1.5 w-16 overflow-hidden rounded-full bg-white/8">
                                    <div class="h-full w-1/3 rounded-full bg-accent shadow-[0_0_8px_rgba(199,243,107,0.5)]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fills the space that made the panel feel bottom-heavy, and gives the pitch a second beat -->
                    <div class="grid grid-cols-3 divide-x divide-border rounded-2xl border border-border bg-surface-raised/50">
                        <div class="px-4 py-3.5">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent">
                                <path d="M12 20v-6M6 20V10M18 20V4"></path>
                            </svg>
                            <div class="mt-2 text-[11px] leading-snug text-text-secondary">Set up in under a minute</div>
                        </div>
                        <div class="px-4 py-3.5">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent">
                                <rect x="2" y="4" width="14" height="10" rx="2"></rect>
                                <path d="M8 18h8M12 14v4"></path>
                            </svg>
                            <div class="mt-2 text-[11px] leading-snug text-text-secondary">Same calm on every device</div>
                        </div>
                        <div class="px-4 py-3.5">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent">
                                <path d="M12 3v3m0 12v3m9-9h-3M6 12H3m14.5-6.5-2 2m-9 9-2 2m13 0-2-2m-9-9-2-2"></path>
                            </svg>
                            <div class="mt-2 text-[11px] leading-snug text-text-secondary">No streaks or pressure</div>
                        </div>
                    </div>
                </div>

                {{-- <div class="relative flex items-center gap-3 border-t border-border pt-5">
                    <div class="grid h-8 w-8 place-items-center rounded-full bg-danger text-[10px] font-black text-[#201820]">MC</div>
                    <div>
                        <div class="text-[11px] font-bold text-[#d7d5d0]">Made for your pace</div>
                        <div class="mt-0.5 text-[10px] text-text-muted">No streaks. No noise. Just room.</div>
                    </div>
                </div> --}}
            </aside>
        </div>

        <div class="hidden fixed bottom-5 left-1/2 z-10 -translate-x-1/2 rounded-full border border-[#48503a] bg-[#252b20] px-4 py-2.5 text-[11px] font-bold text-[#d8f89a] shadow-[0_18px_40px_rgb(0_0_0/30%)]" id="toast" role="status"></div>
    </main>
</body>
</html>
