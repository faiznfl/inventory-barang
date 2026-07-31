<x-layouts.auth title="Check Your Email | Fixoria Sales">
    <!-- Success Icon Container -->
    <div class="flex flex-col items-center text-center gap-2">
        <div class="w-16 h-16 bg-gradient-to-br from-primary-container to-primary rounded-2xl flex items-center justify-center mb-2 shadow-lg shadow-primary-container/20 transform hover:scale-105 transition-transform duration-300">
            <span class="material-symbols-outlined text-on-primary text-[36px]" style="font-variation-settings: 'FILL' 1;">
                mark_email_read
            </span>
        </div>
        <!-- Heading -->
        <h1 class="font-display-lg text-display-lg text-on-surface">
            Check Your Email
        </h1>
        <!-- Body Text -->
        <p class="font-body-md text-body-md text-on-surface-variant px-2">
            We've sent a password reset link to your email address. Please follow the instructions in the email to reset your password.
        </p>
    </div>

    <!-- Actions Container -->
    <div class="flex flex-col gap-4">
        <!-- Primary Action -->
        <a class="w-full h-11 bg-primary-container text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary transition-all shadow-lg shadow-primary-container/20 active:scale-[0.98] flex items-center justify-center gap-2" href="mailto:">
            <span class="material-symbols-outlined text-[20px]">open_in_new</span>
            Open Email App
        </a>

        <!-- Resend Email Link -->
        <p class="font-label-sm text-label-sm text-label text-center">
            Didn't receive the email? Check your spam folder or 
            <button class="text-primary-container font-semibold hover:underline ml-1 focus:outline-none" id="resend-email-btn" type="button">Resend Email</button>
        </p>

        <!-- Divider -->
        <div class="relative my-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-border"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-surface px-2 text-outline font-label-sm tracking-wider">Or</span>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center">
            <a class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant hover:text-primary-container transition-colors group" href="{{ route('login') }}">
                <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
                Back to Sign In
            </a>
        </div>
    </div>

    <!-- Micro-interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resendBtn = document.getElementById('resend-email-btn');
            if (resendBtn) {
                resendBtn.addEventListener('click', function() {
                    const originalText = this.textContent;
                    this.textContent = 'Sending...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        this.textContent = 'Email Sent!';
                        this.classList.remove('text-primary-container');
                        this.classList.add('text-emerald-600');
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('text-emerald-600');
                            this.classList.add('text-primary-container');
                            this.disabled = false;
                        }, 3000);
                    }, 1200);
                });
            }
        });
    </script>
</x-layouts.auth>
