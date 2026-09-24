<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section
    class="relative flex min-h-dvh w-full flex-col px-5 py-7 min-[901px]:order-2 min-[901px]:px-12 min-[901px]:py-12 min-[1081px]:px-15 min-[901px]:basis-1/2">
    <header class="flex items-center justify-between">
        <button type="button" class="group inline-flex items-center gap-3 bg-transparent p-0 text-left"
            data-notice="Welcome back to your workspace" aria-label="Open TaskNex home">
            <span
                class="grid h-10 w-10 rotate-[-8deg] place-items-center rounded-[11px] bg-accent text-surface-raised shadow-[0_0_24px_rgb(199_243_107/16%)] transition-transform duration-200 group-hover:rotate-0"
                aria-hidden="true">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span class="font-display text-3xl font-extrabold tracking-tighter">tasknex<span
                    class="text-accent">.</span></span>
        </button>
        <div class="text-xs text-slate-400 flex items-center gap-2">
            <span class="">Already have an account?</span>
            <a href="#signin"
                class="text-accent font-semibold hover:underline underline-offset-2 transition-colors cursor-pointer">Sign
                in</a>
        </div>


    </header>

    <div class="mx-auto flex w-full max-w-120 flex-1 flex-col justify-center pt-16 pb-8 max-[480px]:pt-13">
        {{-- <div
            class="mb-4 flex items-center gap-2 text-[10px] font-extrabold tracking-[0.2em] text-danger uppercase">
            <span class="status-dot"></span>
            Your next chapter
        </div> --}}
        <h1
            class="font-display mb-12 max-w-97.5 text-[clamp(2.5rem,5vw,4rem)] leading-[0.98] font-semibold tracking-[-0.075em] max-[480px]:text-[2.7rem]">
            Signup<span class="text-accent">.</span>
        </h1>

        <div id="form-view">
            <form class="grid gap-4" id="signup-form" novalidate>
                <div class="grid gap-2">
                    <label class="field-label" for="signup-name">Your name</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input class="field-input" id="signup-name" name="name" placeholder="Maya Chen"
                            autocomplete="name">
                    </div>
                </div>

                <div class="grid gap-2">
                    <label class="field-label" for="signup-email">Email address</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="m3 7 9 6 9-6"></path>
                        </svg>
                        <input class="field-input" id="signup-email" type="email" name="email"
                            placeholder="maya@somewhere.good" autocomplete="email">
                    </div>
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <label class="field-label" for="signup-password">Password</label>
                        <span class="mr-1 inline-flex items-center gap-1 text-[10px] text-text-muted">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                            </svg>
                            Password must be strong
                        </span>
                    </div>
                    <div class="relative">
                        <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                            <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                        </svg>
                        <input class="field-input pr-12" id="signup-password" type="password" name="password"
                            placeholder="At least 8 characters" autocomplete="new-password">
                        <button
                            class="absolute top-1/2 right-3 grid h-7 w-7 -translate-y-1/2 place-items-center rounded-md text-text-muted hover:bg-surface-hover hover:text-text-primary"
                            id="password-toggle" type="button" aria-label="Show password">
                            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                <circle cx="12" cy="12" r="2.5"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <label class="field-label" for="signup-password">Confirm Password</label>

                    </div>
                    <div class="relative">
                        <svg class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-text-muted"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                            <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                        </svg>
                        <input class="field-input pr-12" id="signup-password" type="password" name="password"
                            placeholder="Re-enter password" autocomplete="confirm-password">
                        <button
                            class="absolute top-1/2 right-3 grid h-7 w-7 -translate-y-1/2 place-items-center rounded-md text-text-muted hover:bg-surface-hover hover:text-text-primary"
                            id="password-toggle" type="button" aria-label="Show password">
                            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                <circle cx="12" cy="12" r="2.5"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <label
                    class="flex cursor-pointer items-start gap-3 pt-7 pb-2 text-[11px] leading-[1.8] text-text-secondary transition-colors duration-200">
                    <input class="peer sr-only" id="terms" type="checkbox">
                    <span
                        class="mt-0.5 grid h-4 w-4 flex-none place-items-center rounded-[5px] border border-[#596079] text-surface-raised peer-checked:border-accent peer-checked:bg-accent"
                        aria-hidden="true">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m5 12 4 4L19 6"></path>
                        </svg>
                    </span>

                    <span>
                        I agree to the
                        <button class="font-bold underline-offset-2 text-accent hover:underline hover:text-accent-hover"
                            type="button" data-notice="Terms opened">terms</button>
                        and
                        <button class="font-bold text-accent underline-offset-2 hover:underline hover:text-accent-hover"
                            type="button" data-notice="Privacy policy opened">privacy policy</button>.
                    </span>
                </label>

                <p class="hidden rounded-lg border border-danger/25 bg-danger/8 px-3 py-2 text-[11px] font-bold text-[#ffad9c]"
                    id="error-message" role="alert"></p>

                <button class="btn-primary cursor-pointer" type="submit">
                    Create your account
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </button>

                <div
                    class="flex items-center gap-3 py-1 before:h-px before:flex-1 before:bg-border before:content-[''] after:h-px after:flex-1 after:bg-border after:content-['']">
                    <span class="text-[10px] tracking-[0.16em] text-text-muted uppercase">or continue with</span>
                </div>

                <button class="btn-secondary cursor-pointer" type="button"
                    data-notice="Google sign-up is ready to connect">
                    <span
                        class="grid h-5 w-5 place-items-center rounded-full bg-text-primary text-[10px] font-black text-[#283244]"><i
                            class="fa-brands fa-google"></i></span>
                    Continue with Google
                </button>
            </form>
        </div>

        <div class="hidden rounded-2xl border border-accent/25 bg-[#1c2a20]/70 p-6 shadow-[0_18px_50px_rgb(0_0_0/18%)]"
            id="success-view">
            <div class="mb-5 grid h-12 w-12 place-items-center rounded-2xl bg-accent/12 text-accent">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m5 12 4 4L19 6"></path>
                </svg>
            </div>
            <h2 class="font-display mb-2 text-2xl tracking-[-0.04em]">Your space is ready.</h2>
            <p class="text-[13px] leading-[1.85] text-[#9ca290]">We saved the first step for <strong
                    id="success-email"></strong>. Your TaskNex workspace is ready when you are.</p>
            <button class="btn-primary mt-6 w-auto px-4" type="button" data-notice="Workspace opened">
                Open your workspace
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m13 6 6 6-6 6"></path>
                </svg>
            </button>
        </div>
    </div>

    <footer
        class="flex items-center justify-between border-t border-[#25273a] pt-5 max-[480px]:flex-col max-[480px]:items-start max-[480px]:gap-3">
        <span class="text-[11px] text-text-muted">© 2025 TaskNex.</span>
        {{-- <span class="inline-flex items-center gap-1.5 text-[11px] text-text-muted"><span
                class="status-dot text-accent"></span>Private by default</span> --}}
    </footer>
</section>
