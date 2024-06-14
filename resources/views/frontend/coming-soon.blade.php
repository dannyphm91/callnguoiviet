@extends('frontend.layouts.blank')

@section('content')
    <div class="coming-soon w-full min-h-screen h-auto relative">
        <div class="w-full h-full flex justify-center pt-32 relative z-50">
            <div class="text-center">
                <a href="/home">
                    <img src="{{ asset('frontend/images/dark-logo.png') }}" alt=""
                        class="mx-auto mb-8" />
                </a>
                <h2
                    class="text-2xl md:text-[64px] max-w-[748px] mb-8 line-clamp-2 md:leading-[72px] text-gray-900 font-semibold font-display">
                    Coming soon! We are almost ready to launch.
                </h2>
                <div class="flex justify-center items-center gap-4 md:gap-6 mb-8">
                    <div class="inline-flex flex-col justify-center">
                        <div id="days"
                            class="md:w-[88px] md:h-[88px] h-16 w-16 inline-flex justify-center items-center text-primary-500 md:text-[40px] text-2xl md:leading-[48px] bg-primary-50 rounded-lg mb-2 border-2 border-primary-100">
                            0
                        </div>
                        <h3 class="text-base text-gray-500">DAYS</h3>
                    </div>
                    <div class="inline-flex flex-col justify-center">
                        <div id="hours"
                            class="md:w-[88px] md:h-[88px] h-16 w-16 inline-flex justify-center items-center text-primary-500 md:text-[40px] text-2xl md:leading-[48px] bg-primary-50 rounded-lg mb-2 border-2 border-primary-100">
                            0
                        </div>
                        <h3 class="text-base text-gray-500">HOURS</h3>
                    </div>
                    <div class="inline-flex flex-col justify-center">
                        <div id="minutes"
                            class="md:w-[88px] md:h-[88px] h-16 w-16 inline-flex justify-center items-center text-primary-500 md:text-[40px] text-2xl md:leading-[48px] bg-primary-50 rounded-lg mb-2 border-2 border-primary-100">
                            0
                        </div>
                        <h3 class="text-base text-gray-500">MINS</h3>
                    </div>
                    <div class="inline-flex flex-col justify-center">
                        <div id="seconds"
                            class="md:w-[88px] md:h-[88px] h-16 w-16 inline-flex justify-center items-center text-primary-500 md:text-[40px] text-2xl md:leading-[48px] bg-primary-50 rounded-lg mb-2 border-2 border-primary-100">
                            0
                        </div>
                        <h3 class="text-base text-gray-500">SECS</h3>
                    </div>
                </div>
                <div
                    class="py-[18px] px-6 border border-gray-100 bg-white rounded-[10px] shadow-[0px_8px_24px_rgba(23,30,21,0.04)] inline-flex sm:flex-nowrap flex-wrap justify-center gap-3 items-center">
                    <p class="sm:w-auto w-full font-medium text-base">Follow Us:</p>
                    <a href="#"
                        class="w-11 h-11 text-primary-700 hover:text-white bg-primary-50 inline-flex justify-center items-center rounded hover:bg-primary-500 transition-all duration-300">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="#"
                        class="w-11 h-11 text-primary-700 hover:text-white bg-primary-50 inline-flex justify-center items-center rounded hover:bg-primary-500 transition-all duration-300">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#"
                        class="w-11 h-11 text-primary-700 hover:text-white bg-primary-50 inline-flex justify-center items-center rounded hover:bg-primary-500 transition-all duration-300">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#"
                        class="w-11 h-11 text-primary-700 hover:text-white bg-primary-50 inline-flex justify-center items-center rounded hover:bg-primary-500 transition-all duration-300">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </a>
                    <a href="#"
                        class="w-11 h-11 text-primary-700 hover:text-white bg-primary-50 inline-flex justify-center items-center rounded hover:bg-primary-500 transition-all duration-300">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                </div>
            </div>

            <p
                class="absolute bottom-8 text-center bg-white inline-flex py-2 px-4 rounded-md text-base text-gray-500 text-opacity-90">
                All content © 2023-Current Adriver and respective copyright holders.
            </p>
        </div>
        <img src="{{ asset('frontend/images/coming-soon-left.png') }}" alt=""
            class="absolute top-0 left-0 hidden xl:block z-30" />
        <img src="{{ asset('frontend/images/coming-soon-right.png') }}" alt=""
            class="absolute top-0 right-0 hidden xl:block z-30" />
    </div>
@endsection
@push('js')
    <script>
        const targetDate = new Date('2024-02-25T00:00:00Z');

        function updateCountdown() {
            const now = new Date();
            const timeDifference = targetDate - now;

            // Calculate days, hours, minutes, and seconds
            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            // Update the countdown elements
            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);

        // Initial call to display the countdown immediately
        updateCountdown();
    </script>
@endpush

<style>
    .coming-soon {
        background: linear-gradient(180deg,
                #ffffff 43.23%,
                rgba(255, 255, 255, 0.88) 83.85%,
                rgba(255, 255, 255, 0.46) 100%),
            url("{{ asset('frontend/images/coming-soon-bg.png') }}");
    }
</style>
