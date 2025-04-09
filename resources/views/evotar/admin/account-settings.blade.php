<x-app-layout mainClass="flex" headerClass="" page_title="- Account Settings">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main" class="px-6 mt-2">
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e0;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a0aec0;
            }

            /* Soft shadows */
            .soft-shadow {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            /* Horizontal tabs scroll */
            .horizontal-tabs {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none; /* Firefox */
            }

            .horizontal-tabs::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Edge */
            }

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .container-custom {
                    width: 95%;
                    padding: 0.5rem;
                }
            }

            @media (min-width: 641px) and (max-width: 768px) {
                .container-custom {
                    width: 90%;
                    padding: 0.5rem;
                }
            }

            @media (min-width: 769px) {
                .container-custom {
                    width: 100%;
                    padding: 0.5rem;
                }
            }
        </style>

        <div x-data="accountSettings()" class="min-h-screen p-2 sm:p-3 md:p-6">
            <div class="container-custom mx-auto" >
                <!-- Header with Back Button -->
                <div class="mx-auto flex w-full">
                    <!-- Left Section -->
                    <div class="flex flex-col w-full">
                        <!-- Header Section -->
                        <div class="flex flex-row justify-between items-start mb-4">
                            <div class="text-left">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Account Settings</h1>
                                <p class="text-[11px] text-gray-500"></p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Horizontal Tabs for Mobile -->
                <div class="lg:hidden mb-4">
                    <div class="bg-white rounded-xl overflow-hidden soft-shadow border border-gray-100">
                        <div class="horizontal-tabs flex">
                            <template x-for="(tab, index) in tabs" :key="index">
                                <button
                                    @click="activeTab = tab.id"
                                    :class="{
                                    'flex flex-col items-center justify-center py-3 px-4 transition-colors border-b-2 flex-1 min-w-[80px]': true,
                                    'text-gray-700 border-gray-600 font-medium': activeTab === tab.id,
                                    'text-gray-500 border-transparent hover:bg-[#f7f9fc]/50': activeTab !== tab.id
                                }"
                                >
                                    <span x-html="tab.icon" class="w-5 h-5 mb-1"></span>
                                    <span class="text-xs" x-text="tab.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Main Content with Sidebar -->
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Desktop Sidebar Navigation -->
                    <div class="hidden lg:block w-full md:w-64 shrink-0">
                        <div class="bg-white rounded-xl overflow-hidden soft-shadow border border-gray-100 sticky top-4">
                            <nav class="flex flex-col">
                                <template x-for="(tab, index) in tabs" :key="index">
                                    <button
                                        @click="activeTab = tab.id"
                                        :class="{
                                        'flex items-center gap-3 p-4 transition-colors border-l-4': true,
                                        'bg-gray-100 text-gray-700 border-black font-medium': activeTab === tab.id,
                                        'text-gray-500 border-transparent hover:bg-gray-100/50 hover:border-gray-200': activeTab !== tab.id
                                    }"
                                    >
                                        <span x-html="tab.icon" class="w-5 h-5"></span>
                                        <span class="text-sm" x-text="tab.label"></span>
                                    </button>
                                </template>
                            </nav>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="flex-1">
                        <!-- Profile Tab -->
                        <div x-show="activeTab === 'profile'" class="bg-white rounded-xl overflow-hidden soft-shadow border border-gray-100">
                            <div class="bg-[#121212] h-16 md:h-20"></div>

                            <div class="flex flex-col items-center">
                                <!-- Centered Profile Picture with camera icon overlay -->
                                <div class="relative -mt-12 md:-mt-16 mb-6">
                                    <div class="h-20 w-20 sm:h-24 sm:w-24 md:h-32 md:w-32 rounded-full border-4 border-white shadow-sm bg-gray-100 flex items-center justify-center overflow-hidden">
                                        <img
                                            x-bind:src="profileImage || 'https://i.pravatar.cc/300'"
                                            alt="Profile picture"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>

                                    <!-- Camera Icon Overlay -->
                                    <label for="profile-upload" class="absolute bottom-0 right-0 h-7 w-7 sm:h-8 sm:w-8 md:h-9 md:w-9 bg-black bg-opacity-70 rounded-full flex items-center justify-center cursor-pointer border-2 border-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="sm:w-[16px] sm:h-[16px] md:w-[18px] md:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                            <circle cx="12" cy="13" r="4"></circle>
                                        </svg>
                                        <input
                                            id="profile-upload"
                                            type="file"
                                            accept="image/*"
                                            class="hidden"
                                            @change="handleProfileImageUpload"
                                        />
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400 -mt-4 mb-4 px-2 text-center">Click on the camera icon to change your profile picture</p>
                            </div>

                            <div class="px-3 sm:px-4 md:px-8 pb-6">
                                <div class="space-y-4 sm:space-y-6">
                                    <h2 class="text-sm sm:text-base font-semibold text-gray-700">Personal Information</h2>

                                    <!-- Name Fields - Responsive grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 sm:gap-4">
                                        <div class="sm:col-span-5 space-y-1">
                                            <label for="firstName" class="text-xs font-medium text-gray-600">First Name <span class="text-red-400">*</span></label>
                                            <input
                                                id="firstName"
                                                type="text"
                                                x-model="firstName"
                                                required
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                :class="{'border-red-200': formErrors.firstName}"
                                            />
                                            <p x-show="formErrors.firstName" class="text-xs text-red-400">First name is required</p>
                                        </div>
                                        <div class="sm:col-span-2 space-y-1">
                                            <label for="middleInitial" class="text-xs font-medium text-gray-600">Middle Initial</label>
                                            <input
                                                id="middleInitial"
                                                type="text"
                                                x-model="middleInitial"
                                                maxlength="1"
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                            />
                                        </div>
                                        <div class="sm:col-span-3 space-y-1">
                                            <label for="lastName" class="text-xs font-medium text-gray-600">Last Name <span class="text-red-400">*</span></label>
                                            <input
                                                id="lastName"
                                                type="text"
                                                x-model="lastName"
                                                required
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                :class="{'border-red-200': formErrors.lastName}"
                                            />
                                            <p x-show="formErrors.lastName" class="text-xs text-red-400">Last name is required</p>
                                        </div>
                                        <div class="sm:col-span-2 space-y-1">
                                            <label for="suffix" class="text-xs font-medium text-gray-600">Suffix</label>
                                            <select
                                                id="suffix"
                                                x-model="suffix"
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23718096%22 strokeWidth=%222%22 strokeLinecap=%22round%22 strokeLinejoin=%22round%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center;"
                                            >
                                                <option value="none">None</option>
                                                <option value="jr">Jr.</option>
                                                <option value="sr">Sr.</option>
                                                <option value="ii">II</option>
                                                <option value="iii">III</option>
                                                <option value="iv">IV</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Birthdate and Gender - Responsive grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div class="space-y-1">
                                            <label for="birthdate" class="text-xs font-medium text-gray-600">Birthdate <span class="text-red-400">*</span></label>
                                            <input
                                                id="birthdate"
                                                type="date"
                                                x-model="birthdate"
                                                required
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                :class="{'border-red-200': formErrors.birthdate}"
                                            />
                                            <p x-show="formErrors.birthdate" class="text-xs text-red-400">Birthdate is required</p>
                                        </div>

                                        <div class="space-y-1">
                                            <label for="gender" class="text-xs font-medium text-gray-600">Gender <span class="text-red-400">*</span></label>
                                            <select
                                                id="gender"
                                                x-model="gender"
                                                required
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                :class="{'border-red-200': formErrors.gender}"
                                                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23718096%22 strokeWidth=%222%22 strokeLinecap=%22round%22 strokeLinejoin=%22round%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center;"
                                            >
                                                <option value="">Select gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="non-binary">Non-binary</option>
                                                <option value="other">Other</option>
                                                <option value="prefer-not">Prefer not to say</option>
                                            </select>
                                            <p x-show="formErrors.gender" class="text-xs text-red-400">Gender is required</p>
                                        </div>
                                    </div>

                                    <h2 class="text-sm sm:text-base font-semibold text-gray-700 pt-2">Contact Information</h2>

                                    <!-- Contact Information - Responsive grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <div class="space-y-1">
                                            <label for="email" class="text-xs font-medium text-gray-600">Email Address <span class="text-red-400">*</span></label>
                                            <input
                                                id="email"
                                                type="email"
                                                x-model="email"
                                                required
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                                :class="{'border-red-200': formErrors.email}"
                                            />
                                            <p x-show="formErrors.email" class="text-xs text-red-400">Valid email is required</p>
                                        </div>

                                        <div class="space-y-1">
                                            <label for="phone" class="text-xs font-medium text-gray-600">Phone Number <span class="text-red-400">*</span></label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs">+63</span>
                                                <input
                                                    id="phone"
                                                    type="tel"
                                                    x-model="phone"
                                                    required
                                                    placeholder="9XX XXX XXXX"
                                                    class="w-full h-8 pl-10 pr-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs bg-gray-50"
                                                    :class="{'border-red-200': formErrors.phone}"
                                                />
                                            </div>
                                            <p x-show="formErrors.phone" class="text-xs text-red-400">Valid Philippine phone number is required</p>
                                        </div>
                                    </div>

                                    <div class="flex justify-end pt-2">
                                        <button
                                            @click="saveProfile()"
                                            :disabled="!canSaveProfile || saveStatus !== 'idle'"
                                            :class="{
                                            'px-4 sm:px-6 py-2 rounded-lg text-xs font-medium transition-colors shadow-sm': true,
                                            'bg-black hover:bg-gray-700 text-white': canSaveProfile,
                                            'bg-gray-100 text-gray-400 cursor-not-allowed': !canSaveProfile
                                        }"
                                        >
                                            <span x-show="saveStatus === 'idle'">Save Changes</span>
                                            <span x-show="saveStatus === 'saving'">Saving...</span>
                                            <span x-show="saveStatus === 'success'" class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Saved
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Tab -->
                        <div x-show="activeTab === 'security'" class="bg-white rounded-xl overflow-hidden soft-shadow border border-gray-100">
                            <div class="p-3 sm:p-4 md:p-6">
                                <h2 class="text-sm sm:text-base font-semibold mb-4 sm:mb-6 text-gray-700">Account & Security</h2>

                                <!-- Username moved to security tab with reduced width -->
                                <div class="max-w-md space-y-4">
                                    <div class="space-y-1">
                                        <label for="username" class="text-xs font-medium text-gray-600">Username</label>
                                        <input
                                            id="username"
                                            type="text"
                                            x-model="username"
                                            class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <label for="currentPassword" class="text-xs font-medium text-gray-600">Current Password</label>
                                        <input
                                            id="currentPassword"
                                            type="password"
                                            x-model="currentPassword"
                                            class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                        />
                                    </div>

                                    <div class="p-3 sm:p-4 lg:p-6 rounded-xl bg-gray-100 border border-gray-100 space-y-4 sm:space-y-5">
                                        <div>
                                            <h3 class="font-medium mb-2 text-sm text-gray-700">Password Requirements</h3>
                                            <p class="text-xs text-gray-400 mb-3">
                                                Your password must meet the following requirements:
                                            </p>

                                            <ul class="space-y-2">
                                                <template x-for="(req, index) in passwordRequirements" :key="index">
                                                    <li class="flex items-center gap-2">
                                                    <span x-show="req.met" class="text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    </span>
                                                        <span x-show="!req.met" class="text-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </span>
                                                        <span
                                                            class="text-xs"
                                                            :class="req.met ? 'text-gray-700' : 'text-gray-400'"
                                                            x-text="req.label"
                                                        ></span>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex justify-between">
                                                <label for="newPassword" class="text-xs font-medium text-gray-600">New Password</label>
                                                <span
                                                    class="text-xs font-medium"
                                                    :style="strengthInfo.color === 'gray' ? 'color: #a0aec0' : `color: ${strengthInfo.color}`"
                                                    x-text="strengthInfo.label"
                                                ></span>
                                            </div>
                                            <input
                                                id="newPassword"
                                                type="password"
                                                x-model="newPassword"
                                                @input="checkPasswordStrength()"
                                                class="w-full h-8 px-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs"
                                            />
                                            <div class="w-full h-1 rounded-full bg-gray-100 mt-1">
                                                <div
                                                    class="h-1 rounded-full transition-all duration-300"
                                                    :style="`width: ${passwordStrength}%; background-color: ${strengthInfo.color}`"
                                                ></div>
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <div class="flex justify-between">
                                                <label for="confirmPassword" class="text-xs font-medium text-gray-600">Confirm New Password</label>
                                                <template x-if="confirmPassword">
                                                <span
                                                    class="text-xs font-medium"
                                                    :class="passwordsMatch ? 'text-green-500' : 'text-red-400'"
                                                    x-text="passwordsMatch ? 'Passwords match' : 'Passwords don\'t match'"
                                                ></span>
                                                </template>
                                            </div>
                                            <input
                                                id="confirmPassword"
                                                type="password"
                                                x-model="confirmPassword"
                                                @input="checkPasswordMatch()"
                                                :class="{
                                                'w-full h-8 px-3 border rounded-lg focus:outline-none focus:border-black focus:ring-black text-xs bg-gray-50': true,
                                                'border-red-200': confirmPassword && !passwordsMatch,
                                                'border-gray-200': !confirmPassword || passwordsMatch
                                            }"
                                            />
                                        </div>
                                    </div>

                                    <!-- Only show error message when there's an issue -->
                                    <div x-show="newPassword.length > 0 && !passwordRequirementsMet" class="flex items-start gap-2 text-xs text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="mt-0.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        <p>Please ensure your password meets all requirements and both passwords match.</p>
                                    </div>

                                    <div class="pt-2">
                                        <button
                                            @click="updatePassword()"
                                            :disabled="!canUpdatePassword"
                                            :class="{
                                            'px-4 sm:px-6 py-2 rounded-lg text-xs font-medium transition-colors shadow-sm': true,
                                            'bg-black hover:bg-gray-700 text-white': canUpdatePassword,
                                            'bg-gray-100 text-gray-400 cursor-not-allowed': !canUpdatePassword
                                        }"
                                        >
                                            <span x-show="saveStatus === 'idle'">Update Password</span>
                                            <span x-show="saveStatus === 'saving'">Updating...</span>
                                            <span x-show="saveStatus === 'success'" class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            Updated
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Developer Tab -->
                        <div x-show="activeTab === 'developer'" class="bg-white rounded-xl overflow-hidden soft-shadow border border-gray-100">
                            <div class="p-3 sm:p-4 md:p-6">
                                <h2 class="text-sm sm:text-base font-semibold mb-4 text-gray-700">System Information</h2>
                                <div class="space-y-4 sm:space-y-6">

                                    <!-- Capstone Adviser in a separate div -->
                                    <div class="p-3 sm:p-4 md:p-6">
                                        <h2 class="text-sm font-semibold mb-4 text-black">
                                            Capstone Adviser
                                        </h2>

                                        <div class="flex flex-col items-center text-center p-3 rounded-lg hover:bg-white transition-colors max-w-xs mx-auto">
                                            <div>
                                                <div class="flex justify-center">
                                                    <div class="w-24 h-24 rounded-full">
                                                        <img alt="Profile image placeholder" class="w-full rounded-full" src="{{ asset('storage/assets/profile/capstone-adviser.jpg') }}"/>
                                                    </div>
                                                </div>
                                                <h2 class="text-[12px] font-semibold text-gray-800 mt-4 text-center">Archie A. Cenas</h2>
                                                <p class="text-[11px] text-gray-600">Capstone Adviser</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Development Team in a separate div -->
                                    <div class="p-3 sm:p-4 md:p-6">
                                        <h3 class="text-sm font-semibold text-black">Developers Information</h3>
                                        <p class="text-xs text-gray-600 mb-5">Meet the developers of USeP E-Votar System</p>

                                        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/raña.jpg') }}"/>
                                                </div>
                                                <h4 class="text-[12px] font-semibold text-gray-800 mt-4">Lorjohn M. Raña</h4>
                                                <p class="text-[11px] text-gray-600">Full-stack Developer</p>
                                                <p class="text-[11px] text-gray-600">lorjohn143@gmail.com</p>
                                            </div>
                                            <!-- Developer 2 -->
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/ang.jfif') }}"/>
                                                </div>
                                                <h4 class="text-[12px] font-semibold text-gray-800 mt-4">Sweet Frachette L. Ang</h4>
                                                <p class="text-[11px] text-gray-600">Front-end Developer</p>
                                                <p class="text-[11px] text-gray-600">sweetfrachettelaude@gmail.com</p>
                                            </div>
                                            <!-- Developer 3 -->
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/vargas.png') }}"/>
                                                </div>
                                                <h4 class="text-[12px] font-semibold text-gray-800 mt-4">Kristine Mae L. Vargas</h4>
                                                <p class="text-[11px] text-gray-600">Front-end Developer</p>
                                                <p class="text-[11px] text-gray-600">krstnmvrgs04@gmail.com</p>
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
            function accountSettings() {
                return {
                    activeTab: 'profile',
                    saveStatus: 'idle',
                    profileImage: null,

                    // Profile data
                    firstName: 'John',
                    middleInitial: 'A',
                    lastName: 'Doe',
                    suffix: 'none',
                    birthdate: '1990-01-01',
                    gender: 'male',
                    email: 'john.doe@usep.edu.ph',
                    phone: '9171234567',
                    username: 'johndoe',

                    // Form validation
                    formErrors: {
                        firstName: false,
                        lastName: false,
                        birthdate: false,
                        gender: false,
                        email: false,
                        phone: false
                    },

                    // Password state
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                    passwordStrength: 0,
                    passwordsMatch: false,
                    canUpdatePassword: false,

                    // Password requirements
                    passwordRequirements: [
                        { id: 'length', label: 'At least 8 characters long', met: false },
                        { id: 'uppercase', label: 'At least one uppercase letter (A-Z)', met: false },
                        { id: 'lowercase', label: 'At least one lowercase letter (a-z)', met: false },
                        { id: 'number', label: 'At least one number (0-9)', met: false },
                        { id: 'special', label: 'At least one special character (!@#$%^&*)', met: false }
                    ],

                    // Tabs
                    tabs: [
                        { id: 'profile', label: 'My Profile', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>' },
                        { id: 'security', label: 'Security', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>' },
                        { id: 'developer', label: 'Developer', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>' }
                    ],

                    // Get strength info
                    get strengthInfo() {
                        if (this.passwordStrength === 0) return { label: 'No password', color: 'gray' };
                        if (this.passwordStrength <= 20) return { label: 'Very weak', color: '#f87171' };
                        if (this.passwordStrength <= 40) return { label: 'Weak', color: '#fb923c' };
                        if (this.passwordStrength <= 60) return { label: 'Medium', color: '#facc15' };
                        if (this.passwordStrength <= 80) return { label: 'Strong', color: '#4ade80' };
                        return { label: 'Very strong', color: '#22c55e' };
                    },

                    // Check if all password requirements are met
                    get passwordRequirementsMet() {
                        return this.passwordRequirements.every(req => req.met);
                    },

                    // Handle profile image upload
                    handleProfileImageUpload(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.profileImage = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    // Check if profile can be saved
                    get canSaveProfile() {
                        return this.firstName.trim() !== '' &&
                            this.lastName.trim() !== '' &&
                            this.birthdate !== '' &&
                            this.gender !== '' &&
                            this.email.trim() !== '' &&
                            this.phone.trim() !== '' &&
                            this.validateEmail(this.email) &&
                            this.validatePhone(this.phone);
                    },

                    // Validate email format
                    validateEmail(email) {
                        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        return re.test(email);
                    },

                    // Validate Philippine phone number
                    validatePhone(phone) {
                        // Philippine mobile number format validation (9XX XXX XXXX)
                        const re = /^9\d{2}[ ]?\d{3}[ ]?\d{4}$/;
                        return re.test(phone);
                    },

                    // Validate form fields
                    validateForm() {
                        this.formErrors.firstName = this.firstName.trim() === '';
                        this.formErrors.lastName = this.lastName.trim() === '';
                        this.formErrors.birthdate = this.birthdate === '';
                        this.formErrors.gender = this.gender === '';
                        this.formErrors.email = !this.validateEmail(this.email);
                        this.formErrors.phone = !this.validatePhone(this.phone);

                        return !Object.values(this.formErrors).some(error => error === true);
                    },

                    // Check password strength
                    checkPasswordStrength() {
                        // Update requirements
                        this.passwordRequirements[0].met = this.newPassword.length >= 8;
                        this.passwordRequirements[1].met = /[A-Z]/.test(this.newPassword);
                        this.passwordRequirements[2].met = /[a-z]/.test(this.newPassword);
                        this.passwordRequirements[3].met = /[0-9]/.test(this.newPassword);
                        this.passwordRequirements[4].met = /[^A-Za-z0-9]/.test(this.newPassword);

                        // Calculate strength
                        const metCount = this.passwordRequirements.filter(req => req.met).length;
                        this.passwordStrength = metCount * 20;

                        this.checkPasswordMatch();
                        this.updateCanSave();
                    },

                    // Check if passwords match
                    checkPasswordMatch() {
                        this.passwordsMatch = this.newPassword === this.confirmPassword && this.newPassword !== '' && this.confirmPassword !== '';
                        this.updateCanSave();
                    },

                    // Update can save state
                    updateCanSave() {
                        // Check if username is filled, all password requirements are met, and passwords match
                        this.canUpdatePassword =
                            this.username.trim() !== '' &&
                            this.currentPassword.trim() !== '' &&
                            this.newPassword.trim() !== '' &&
                            this.confirmPassword.trim() !== '' &&
                            this.passwordRequirementsMet &&
                            this.passwordsMatch;
                    },

                    // Save profile
                    saveProfile() {
                        if (!this.validateForm()) return;

                        this.saveStatus = 'saving';
                        setTimeout(() => {
                            this.saveStatus = 'success';
                            setTimeout(() => this.saveStatus = 'idle', 2000);
                        }, 1000);
                    },

                    // Update password
                    updatePassword() {
                        if (!this.canUpdatePassword) return;

                        this.saveStatus = 'saving';
                        setTimeout(() => {
                            this.saveStatus = 'success';
                            setTimeout(() => {
                                this.saveStatus = 'idle';
                                this.currentPassword = '';
                                this.newPassword = '';
                                this.confirmPassword = '';
                                this.passwordStrength = 0;
                                this.passwordsMatch = false;
                                this.passwordRequirements.forEach(req => req.met = false);
                            }, 2000);
                        }, 1000);
                    },


                }
            }
        </script>
    </x-slot>
</x-app-layout>



