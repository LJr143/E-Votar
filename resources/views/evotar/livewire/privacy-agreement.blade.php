<div wire:key="e-votar-privacy" wire:ignore.self>
    <div x-data="{ open: $wire.entangle('showModal') }"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[9999] overflow-y-auto p-4 flex items-center justify-center"
         style="background-color: rgba(0,0,0,0.7); backdrop-filter: blur(5px)"
         x-cloak>

        <!-- Card Container -->
        <div class="bg-white/90 backdrop-blur-lg rounded shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden border border-white/20 flex flex-col z-[9999]">

            <!-- Gradient Header -->
            <div class="bg-gradient-to-r from-red-800 to-red-600 p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" alt="E-Votar" class="h-10 w-10 rounded-full">
                        <img src="{{ asset('storage/assets/icon/evotar_v_logo.png') }}" alt="USeP" class="h-5 w-8 rounded-full">
                    </div>
                    <div>
                        <h1 class="text-[16px] font-bold text-white">E-Votar Data Privacy Statement</h1>
                        <p class="text-red-100 font-light">Secure Digital Voting System</p>
                    </div>
                </div>
                <div class="bg-white/20 px-3 py-1 rounded-full text-xs font-medium text-white">
                    v1.0
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="overflow-y-auto flex-grow p-6">
                <!-- Intro Card -->
                <div class="bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100/50 mb-8 shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-red-100 p-3 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[16px] font-bold text-gray-800 mb-2">Your Vote, Your Privacy</h2>
                            <p class="text-gray-700">
                                The E-Votar system complies with <span class="font-semibold text-red-600">USeP COMELEC CBL</span> and
                                <span class="font-semibold text-red-600">RA 10173</span>. We employ military-grade encryption,
                                facial biometrics, and steganography to protect your data and voting integrity.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Data Collection Section -->
                <section class="mb-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm">1</span>
                        Data We Collect
                    </h3>

                    <div class="grid md:grid-cols-2 gap-5">
                        <!-- Identity Card -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800">Identity Verification</h4>
                            </div>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Full legal name (as registered in USeP records)</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>USeP ID number</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Facial biometric data (for verification)</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Academic Card -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800">Academic Information</h4>
                            </div>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Campus affiliation</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>College/department</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Degree program</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Year level</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Security Section -->
                <section class="mb-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm">2</span>
                        Our Security Measures
                    </h3>

                    <div class="grid md:grid-cols-3 gap-5">
                        <!-- Encryption -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 group hover:border-red-400 transition-colors">
                            <div class="bg-red-600/10 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Multi-Layer Encryption</h4>
                            <p class="text-gray-600 text-sm">
                                AES-256 encrypted passwords and steganography-protected votes ensure ballot secrecy and system integrity.
                            </p>
                        </div>

                        <!-- Biometrics -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 group hover:border-red-400 transition-colors">
                            <div class="bg-red-600/10 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Facial Biometrics</h4>
                            <p class="text-gray-600 text-sm">
                                Liveness detection and facial matching prevent impersonation while maintaining voter anonymity.
                            </p>
                        </div>

                        <!-- Monitoring -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 group hover:border-red-400 transition-colors">
                            <div class="bg-red-600/10 p-3 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Active Monitoring</h4>
                            <p class="text-gray-600 text-sm">
                                IP address tracking with automated cleanup ensures auditability while protecting voter privacy.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Compliance Section -->
                <section class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm">3</span>
                        Compliance & Governance
                    </h3>

                    <div class="bg-white border border-gray-200 rounded-xl p-5">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/2 md:pr-5 mb-5 md:mb-0">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    USeP COMELEC Oversight
                                </h4>
                                <p class="text-gray-700 text-sm">
                                    All election processes are conducted under the supervision of the University Commission on Elections, following their Constitution and By-Laws (CBL) for fair and transparent student elections.
                                </p>
                            </div>
                            <div class="md:w-1/2 md:pl-5 md:border-l border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Data Privacy Compliance
                                </h4>
                                <p class="text-gray-700 text-sm">
                                    Operates under USeP Data Privacy Office supervision, complying with NPC Circulars and RA 10173. All administrators undergo mandatory privacy training and sign confidentiality agreements.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <div class="bg-gradient-to-r from-red-800/5 to-red-600/5 px-6 py-4 border-t border-gray-200/50 flex flex-col sm:flex-row justify-between items-center">
                <div class="text-center sm:text-left mb-3 sm:mb-0">
                    <p class="text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        System version 1.0 • Updated {{ now()->format('m/d/Y') }}
                    </p>
                </div>
                <button wire:click="agree"
                        type="button"
                        class="relative overflow-hidden group inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-150">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        I Understand & Agree
                    </span>
                    <span class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-900 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-0"></span>
                </button>
            </div>
        </div>
    </div>
</div>
