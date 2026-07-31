<x-layouts.auth title="Reset Password | Fixoria Sales">
    <!-- Header Section -->
    <div class="text-center mb-2">
        <div class="flex items-center justify-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">password</span>
            </div>
        </div>
        <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Create New Password</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Your new password must be different from previous used passwords.
        </p>
    </div>

    <!-- Error Feedback Area -->
    @if($errors->any())
    <div class="flex items-center gap-3 p-4 bg-error-bg rounded-lg border border-error/10" id="error-alert">
        <span class="material-symbols-outlined text-error-text text-sm">error</span>
        <span class="font-body-md text-body-md text-error-text">{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- Reset Form -->
    <form class="flex flex-col gap-5" id="reset-form" method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token ?? 'sample-token' }}">
        
        <!-- Email Field (hidden or read-only) -->
        <input type="hidden" name="email" value="{{ request('email', old('email')) }}">

        <!-- New Password Field -->
        <div class="flex flex-col gap-1.5">
            <label class="font-label-sm text-label-sm text-label" for="password">New Password</label>
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline transition-colors group-focus-within:text-primary-container">lock</span>
                <input class="w-full h-10 pl-10 pr-10 rounded-lg border border-border bg-white text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" id="password" name="password" placeholder="••••••••" required type="password">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" id="toggle-password">
                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                </button>
            </div>
        </div>

        <!-- Confirm New Password Field -->
        <div class="flex flex-col gap-1.5">
            <label class="font-label-sm text-label-sm text-label" for="password_confirmation">Confirm New Password</label>
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline transition-colors group-focus-within:text-primary-container">lock_reset</span>
                <input class="w-full h-10 pl-10 pr-10 rounded-lg border border-border bg-white text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required type="password">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" id="toggle-password-confirm">
                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                </button>
            </div>
        </div>

        <!-- Password Requirements Checklist -->
        <div class="bg-surface-container-low/60 rounded-lg p-4 space-y-2.5 border border-border/50">
            <p class="font-label-sm text-[11px] text-on-surface-variant opacity-70 tracking-wider">PASSWORD REQUIREMENTS</p>
            <ul class="space-y-2">
                <li class="flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant transition-colors" id="req-length">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    At least 8 characters
                </li>
                <li class="flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant transition-colors" id="req-number">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    At least 1 number (0-9)
                </li>
                <li class="flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant transition-colors" id="req-special">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    At least 1 special character
                </li>
            </ul>
        </div>

        <!-- Primary Action -->
        <button class="w-full h-11 bg-primary-container text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary transition-all shadow-lg shadow-primary-container/20 active:scale-[0.98] mt-2 flex items-center justify-center gap-2" type="submit">
            Reset Password
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-2">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-border"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase">
            <span class="bg-surface px-2 text-outline font-label-sm tracking-wider">Or</span>
        </div>
    </div>

    <!-- Back to Sign In Link -->
    <div class="text-center">
        <a class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant hover:text-primary-container transition-colors group" href="{{ route('login') }}">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
            Back to Sign In
        </a>
    </div>

    <!-- Micro-interactions & Requirement Checker Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const toggleBtn = document.getElementById('toggle-password');
            const toggleConfirmBtn = document.getElementById('toggle-password-confirm');

            const setupToggle = (btn, input) => {
                if (btn && input) {
                    btn.addEventListener('click', () => {
                        const isPass = input.type === 'password';
                        input.type = isPass ? 'text' : 'password';
                        const icon = btn.querySelector('span');
                        if (icon) {
                            icon.innerText = isPass ? 'visibility' : 'visibility_off';
                        }
                    });
                }
            };

            setupToggle(toggleBtn, passInput);
            setupToggle(toggleConfirmBtn, confirmInput);

            if (passInput) {
                passInput.addEventListener('input', () => {
                    const val = passInput.value;
                    updateRequirement('req-length', val.length >= 8);
                    updateRequirement('req-number', /\d/.test(val));
                    updateRequirement('req-special', /[!@#$%^&*(),.?":{}|<>]/.test(val));
                });
            }

            function updateRequirement(id, isValid) {
                const el = document.getElementById(id);
                if (!el) return;
                const icon = el.querySelector('span');
                if (isValid) {
                    el.classList.add('text-primary-container', 'font-semibold');
                    el.classList.remove('text-on-surface-variant');
                    if (icon) icon.style.fontVariationSettings = "'FILL' 1";
                } else {
                    el.classList.remove('text-primary-container', 'font-semibold');
                    el.classList.add('text-on-surface-variant');
                    if (icon) icon.style.fontVariationSettings = "'FILL' 0";
                }
            }
        });
    </script>
</x-layouts.auth>
