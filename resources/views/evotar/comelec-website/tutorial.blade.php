<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }

            /* Custom animations */
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                    transform: scale(1);
                }
                50% {
                    opacity: 0.9;
                    transform: scale(1.05);
                }
            }

            .animate-fade-in {
                animation: fadeIn 1s ease-in-out;
            }

            .animate-slide-up {
                animation: slideUp 0.8s ease-out forwards;
                opacity: 0;
            }

            .animate-pulse {
                animation: pulse 2s infinite;
            }

            .animation-delay-200 {
                animation-delay: 0.2s;
            }

            .animation-delay-400 {
                animation-delay: 0.4s;
            }

            .animation-delay-600 {
                animation-delay: 0.6s;
            }

            .animation-delay-800 {
                animation-delay: 0.8s;
            }

            .animation-delay-1000 {
                animation-delay: 1s;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }

            /* Reveal on scroll */
            .reveal {
                position: relative;
                opacity: 0;
                transition: all 0.8s ease;
            }

            .reveal.active {
                opacity: 1;
            }

            .reveal.from-bottom {
                transform: translateY(40px);
            }

            .reveal.from-bottom.active {
                transform: translateY(0);
            }

            .reveal.from-left {
                transform: translateX(-40px);
            }

            .reveal.from-left.active {
                transform: translateX(0);
            }

            .reveal.from-right {
                transform: translateX(40px);
            }

            .reveal.from-right.active {
                transform: translateX(0);
            }

            /* Image hover effect */
            .img-container {
                overflow: hidden;
            }

            .img-container img {
                transition: transform 0.5s ease;
            }

            .img-container:hover img {
                transform: scale(1.03);
            }

            /* Step number animation */
            .step-number {
                position: relative;
                overflow: hidden;
            }

            .step-number::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                transform: translateX(-100%);
                animation: shimmer 2s infinite;
            }

            @keyframes shimmer {
                100% {
                    transform: translateX(100%);
                }
            }
        </style>

        <body class="bg-white">
        <div x-data="{
    activeStep: 0,
    steps: [
      'Select an Available Election',
      'View Election Details',
      'Select Tagum Student Council Candidates',
      'Select Local Council Candidates',
      'Review and Confirm Your Votes',
      'Vote Verification and Receipt'
    ],
    isVisible: function(index) {
      return this.activeStep === index;
    },
    nextStep: function() {
      if (this.activeStep < 5) this.activeStep++;
    },
    prevStep: function() {
      if (this.activeStep > 0) this.activeStep--;
    }
  }" class="min-h-screen">
            <div class="container mx-auto px-4 py-10 max-w-[75%]">


                <div class="grid gap-10">
                    <div class="text-center space-y-3 animate-fade-in">
                        <h1 class="text-[20px] font-bold tracking-tight text-black">Student Election Voting Guide</h1>
                        <p class="text-[14px] text-gray-600 max-w-2xl mx-auto">
                            Follow this step-by-step tutorial to cast your vote in the student council election
                        </p>
                    </div>

                    <div class="border-none shadow-xl overflow-hidden bg-white backdrop-blur-sm">
                        <div class="bg-black text-white rounded-t-xl pb-10 p-6">
                            <h2 class="text-[20px] font-bold text-center">How to Vote</h2>
                            <p class="text-[12px] text-gray-300 text-center mt-2">
                                Your complete guide to the student election voting process
                            </p>
                        </div>
                        <div class="pt-0 px-0">
                            <div class="relative -mt-6 px-6 md:px-8">
                                <div class="grid gap-8">
                                    <div class="grid gap-8 relative">
                                        <div class="absolute left-[39px] top-[72px] bottom-0 w-1 bg-black hidden md:block"></div>

                                        <!-- Step 1 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    1
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                1
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Select an Available Election</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        After logging in, you will be directed to the available elections page. Here you can view
                                                        all elections where you are eligible to participate.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step1.png') }}"
                                                             alt="Available Elections Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                Click on an election card to view its details and participate
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 2 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-200 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    2
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                2
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">View Election Details</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        On the election details page, you'll see information about the election including a
                                                        countdown timer showing when the election ends.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step2.png') }}"
                                                             alt="Election Details Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                Click the "Vote Now" button when you're ready to proceed
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 3 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-400 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    3
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                3
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Select Tagum Student Council Candidates</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        You'll be directed to the Tagum Student Council voting page.
                                                        Here, you can select candidates for each position by clicking the left or right arrows to navigate through the available candidates.
                                                        To cast your vote, make your chosen candidate's card appear first. If you prefer to abstain, simply leave the abstain card as the first to appear.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step3.png') }}"
                                                             alt="Tagum Student Council Voting Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                After selecting tagum student council candidates, click the "Proceed to Local Council Election" button to continue.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 4 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-600 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    4
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                4
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Select Local Council Candidates</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        After selecting your Tagum Student Council candidates, you'll be directed to the Local Council voting page.
                                                        Use the same arrow navigation to browse through the candidates. To vote, simply select your candidate and make their card appear first.
                                                        If you prefer to abstain, leave the abstain card as the first to appear.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step4.png') }}"
                                                             alt="Local Council Voting Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                After selecting candidates, click the "Submit Vote" button to see a summary of your vote.
                                                                Otherwise, you can always go back and correct your choices—just click the "Back to Student Council" button.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 5 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-800 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    5
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                5
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Review and Confirm Your Votes</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        A summary of your selected candidates will be displayed. Review your choices carefully
                                                        before confirming your vote.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step5.png') }}"
                                                             alt="Vote Summary Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                Click "Confirm" to finalize your vote or "Cancel" to make changes
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 6 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-1000 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    6
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                6
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Vote Submitted SuccessfulLy</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        After confirming, you'll see a verification page with an option to download your vote
                                                        receipt. This serves as proof of your participation in the election.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step6.png') }}"
                                                             alt="Vote Verification Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                "Click 'Download Image Receipt' to save your receipt, then 'Okay' to go back to the dashboard or 'Verify Your Vote' to proceed with verifying your selection using the saved receipt."
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Step 7 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-1000 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    7
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                7
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Verify Your Vote</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        To complete the verification process, please upload the image receipt you downloaded after submitting your vote.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step7.png') }}"
                                                             alt="Vote Verification Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                Click "Verify Vote" to complete the verification process.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Step 8 -->
                                        <div class="grid md:grid-cols-[80px_1fr] gap-6 items-start relative animate-slide-up animation-delay-1000 reveal from-bottom">
                                            <div class="bg-black p-4 rounded-2xl flex items-center justify-center shadow-lg hidden md:flex">
                                                <div class="h-12 w-12 rounded-full bg-white/20 text-white flex items-center justify-center text-[20px] font-bold step-number">
                                                    8
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                                <div class="p-6">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="bg-black p-3 rounded-xl flex items-center justify-center shadow-md md:hidden">
                                                            <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center text-[14px] font-bold">
                                                                8
                                                            </div>
                                                        </div>
                                                        <h3 class="text-[14px] font-bold">Viewing Verification Results</h3>
                                                    </div>
                                                    <p class="text-[12px] text-gray-600 mb-6">
                                                        After uploading the receipt and clicking "Verify Vote," the system will process the file to verify your vote. If the receipt is valid, your selected candidates will be displayed along with a confirmation message indicating a successful match.
                                                        If the receipt is invalid or doesn't match any record, an error message will appear. You can either re-upload a correct receipt or choose "Back to Dashboard" to return to the main page.
                                                    </p>
                                                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 transition-all duration-300 hover:shadow-lg group-hover:scale-[1.02] img-container">
                                                        <img src="{{ asset('storage/assets/image/step8.png') }}"
                                                             alt="Vote Verification Screen"
                                                             class="w-full object-contain">
                                                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                                                            <p class="text-[11px] text-gray-500">
                                                                If the receipt is valid, your selected candidates will be displayed. If it's invalid, you can try re-uploading the correct receipt or return to the dashboard.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Reveal elements on scroll
            function reveal() {
                var reveals = document.querySelectorAll(".reveal");

                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 150;

                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    } else {
                        reveals[i].classList.remove("active");
                    }
                }
            }

            window.addEventListener("scroll", reveal);

            // Initial check to reveal elements in viewport on page load
            document.addEventListener("DOMContentLoaded", function() {
                reveal();

                // Add hover effect to step numbers
                const stepNumbers = document.querySelectorAll('.step-number');
                stepNumbers.forEach(step => {
                    step.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.1)';
                        this.style.transition = 'transform 0.3s ease';
                    });

                    step.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });

                // Add parallax effect to images on mouse move
                const imgContainers = document.querySelectorAll('.img-container');
                imgContainers.forEach(container => {
                    container.addEventListener('mousemove', function(e) {
                        const img = this.querySelector('img');
                        const rect = this.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const xPercent = (x / rect.width - 0.5) * 2; // -1 to 1
                        const yPercent = (y / rect.height - 0.5) * 2; // -1 to 1

                        img.style.transform = `scale(1.03) translate(${xPercent * 5}px, ${yPercent * 5}px)`;
                    });

                    container.addEventListener('mouseleave', function() {
                        const img = this.querySelector('img');
                        img.style.transform = 'scale(1)';
                    });
                });
            });
        </script>
        </body>
    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>




</x-custom-layout>


