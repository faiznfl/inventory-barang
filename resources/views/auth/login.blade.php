<x-layouts.auth title="Sign In | Fixoria Sales">
    <!-- Identity Header -->
    <div class="flex flex-col items-center text-center gap-2">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
            </div>
        </div>
        <h1 class="font-display-lg text-display-lg text-on-surface">Welcome Back</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Enter your credentials to access your account</p>
    </div>

    <!-- Error Feedback Area -->
    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-error-bg rounded-lg border border-error/10" id="error-alert">
        <span class="material-symbols-outlined text-error-text text-sm">error</span>
        <span class="font-body-md text-body-md text-error-text">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Form Content -->
    <form class="flex flex-col gap-5" id="signin-form" method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Field -->
        <div class="flex flex-col gap-1.5">
            <label class="font-label-sm text-label-sm text-label" for="email">Email Address</label>
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline transition-colors group-focus-within:text-primary-container">mail</span>
                <input class="w-full h-10 pl-10 pr-4 rounded-lg border border-border bg-white text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" id="email" name="email" placeholder="name@company.com" required type="email" value="{{ old('email') }}">
            </div>
        </div>

        <!-- Password Field -->
        <div class="flex flex-col gap-1.5">
            <div class="flex justify-between items-center">
                <label class="font-label-sm text-label-sm text-label" for="password">Password</label>
                <a class="font-label-sm text-label-sm text-primary-container hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
            </div>
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline transition-colors group-focus-within:text-primary-container">lock</span>
                <input class="w-full h-10 pl-10 pr-10 rounded-lg border border-border bg-white text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" id="password" name="password" placeholder="••••••••" required type="password">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" id="toggle-password">
                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                </button>
            </div>
        </div>

        <!-- Primary Action -->
        <button class="w-full h-11 bg-primary-container text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary transition-all shadow-lg shadow-primary-container/20 active:scale-[0.98] mt-2 flex items-center justify-center gap-2" type="submit">
            Sign In
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </form>

    <!-- Bottom Link -->
    <div class="pt-2 text-center">
        <p class="font-body-md text-body-md text-on-surface-variant">
            Don't have an account? <a class="text-primary-container font-semibold hover:underline" href="#">Contact Admin</a>
        </p>
    </div>

    <!-- Micro-interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggle-password');
            const passInput = document.getElementById('password');

            if (toggleBtn && passInput) {
                toggleBtn.addEventListener('click', () => {
                    const isPass = passInput.type === 'password';
                    passInput.type = isPass ? 'text' : 'password';
                    const icon = toggleBtn.querySelector('span');
                    if (icon) {
                        icon.innerText = isPass ? 'visibility' : 'visibility_off';
                    }
                });
            }
        });
    </script>
</x-layouts.auth>
