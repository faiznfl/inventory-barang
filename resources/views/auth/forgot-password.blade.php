<x-layouts.auth title="Forgot Password | Fixoria Sales">
    <!-- Header Section -->
    <div class="text-center mb-2">
        <div class="flex items-center justify-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lock_reset</span>
            </div>
        </div>
        <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Forgot Password?</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Enter the email address associated with your account and we'll send you a link to reset your password.
        </p>
    </div>

    <!-- Form -->
    <form class="flex flex-col gap-5" id="forgot-password-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <!-- Email Input Group -->
        <div class="flex flex-col gap-1.5">
            <label class="font-label-sm text-label-sm text-label" for="email">Email Address</label>
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline transition-colors group-focus-within:text-primary-container">mail</span>
                <input class="w-full h-10 pl-10 pr-4 rounded-lg border border-border bg-white text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" id="email" name="email" placeholder="name@company.com" required type="email" value="{{ old('email') }}">
            </div>
        </div>

        <!-- Submit Button -->
        <button class="w-full h-11 bg-primary-container text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary transition-all shadow-lg shadow-primary-container/20 active:scale-[0.98] mt-2 flex items-center justify-center gap-2 group" type="submit">
            Send Reset Link
            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
        </button>
    </form>

    <!-- Success State -->
    @if(session('status'))
    <div class="text-center py-2 space-y-4" id="success-message">
        <div class="w-12 h-12 bg-secondary-container text-primary rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <h2 class="font-display-lg text-display-lg text-on-surface">Check your email</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            {{ session('status') }}
        </p>
        <a class="font-label-sm text-label-sm text-primary hover:underline inline-block" href="{{ route('password.request') }}">
            Didn't receive the email? Try again
        </a>
    </div>
    @endif

    <!-- Divider -->
    <div class="relative my-2" id="form-divider">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-border"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase">
            <span class="bg-surface px-2 text-outline font-label-sm tracking-wider">Or</span>
        </div>
    </div>

    <!-- Footer Links -->
    <div class="text-center">
        <a class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant hover:text-primary-container transition-colors group" href="{{ route('login') }}">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
            Back to Sign In
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('forgot-password-form');
            if (form) {
                form.addEventListener('submit', () => {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Sending...';
                    }
                });
            }
        });
    </script>
</x-layouts.auth>
