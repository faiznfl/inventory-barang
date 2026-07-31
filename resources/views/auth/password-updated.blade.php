<x-layouts.auth title="Password Updated | Fixoria Sales">
    <!-- Success Icon -->
    <div class="flex flex-col items-center text-center gap-2">
        <div class="mb-4 flex justify-center">
            <div class="relative">
                <div class="w-20 h-20 bg-primary-container flex items-center justify-center rounded-full shadow-lg shadow-primary-container/20">
                    <span class="material-symbols-outlined text-white text-4xl" style="font-variation-settings: 'wght' 700;">check</span>
                </div>
                <!-- Pulses -->
                <div class="absolute inset-0 rounded-full bg-primary-container opacity-20 animate-ping"></div>
            </div>
        </div>
        <!-- Content -->
        <h1 class="font-display-lg text-display-lg text-on-surface">
            Password Updated!
        </h1>
        <p class="font-body-md text-body-md text-on-surface-variant px-2">
            Your password has been successfully reset. You can now use your new password to sign in to your account.
        </p>
    </div>

    <!-- Action -->
    <div class="flex flex-col gap-4">
        <a class="w-full h-11 bg-primary-container text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary transition-all shadow-lg shadow-primary-container/20 active:scale-[0.98] flex items-center justify-center gap-2" href="{{ route('login') }}">
            Sign In Now
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>

        <!-- Redirect note -->
        <p class="font-label-sm text-label-sm text-outline text-center">
            Automatic redirect to login in <span id="timer">10</span>s
        </p>
    </div>

    <!-- Micro-interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timerElement = document.getElementById('timer');
            let timeLeft = 10;

            const countdown = setInterval(() => {
                timeLeft--;
                if (timerElement) timerElement.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    window.location.href = "{{ route('login') }}";
                }
            }, 1000);

            // Confetti Blast Effect
            function createConfetti() {
                const colors = ['#5b46e2', '#4226ca', '#c6bfff', '#dfd9ff'];
                for (let i = 0; i < 40; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'fixed w-2 h-2 rounded-xs pointer-events-none z-50';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = '50%';
                    confetti.style.top = '40%';
                    
                    const angle = Math.random() * Math.PI * 2;
                    const velocity = 4 + Math.random() * 8;
                    const vx = Math.cos(angle) * velocity;
                    let vy = Math.sin(angle) * velocity;
                    
                    document.body.appendChild(confetti);

                    let x = window.innerWidth / 2;
                    let y = window.innerHeight * 0.4;
                    let gravity = 0.25;

                    const moveConfetti = () => {
                        x += vx;
                        y += vy + gravity;
                        vy += gravity;
                        confetti.style.transform = `translate(${x - window.innerWidth/2}px, ${y - window.innerHeight*0.4}px) rotate(${x}deg)`;
                        
                        if (y < window.innerHeight) {
                            requestAnimationFrame(moveConfetti);
                        } else {
                            confetti.remove();
                        }
                    };
                    requestAnimationFrame(moveConfetti);
                }
            }

            setTimeout(createConfetti, 200);
        });
    </script>
</x-layouts.auth>
