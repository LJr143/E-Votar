<x-app-layout mainClass="flex" page_title="- System Logs">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col w-1/3 ">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Account Settings</h1>
                            <p class="text-[11px] text-gray-500"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div  x-data="formValidation()">
                <div class="bg-white rounded shadow-md p-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/5 mb-4 md:mb-0">
                            <ul class="space-y-0 flex space-x-4 md:space-y-4 md:space-x-0 md:flex-col">
                                <li :class="{ 'font-semibold': tab === 'MyProfile' }" @click="tab = 'MyProfile'" class="text-black cursor-pointer font-semibold" style="font-size: 12px;">
                                    My Profile
                                </li>
                                <li :class="{ 'font-semibold': tab === 'Security' }" @click="tab = 'Security'" class="text-black cursor-pointer" style="font-size: 12px;">
                                    Security
                                </li>
                                <li :class="{ 'font-semibold': tab === 'Developers' }" @click="tab = 'Developers'" class="text-black cursor-pointer" style="font-size: 12px;">
                                    Developers
                                </li>
                            </ul>
                        </div>
                        <div class="w-full md:w-4/5">
                            <div x-show="tab === 'MyProfile'">
                                <h1 class="text-md font-semibold mb-4 text-black" >
                                    Account Settings
                                </h1>
                                <div>
                                    <div class="flex flex-col sm:flex-row items-center bg-white p-6 rounded-lg shadow-md mb-4">
                                        <div class="relative w-16 h-16 rounded-full overflow-hidden bg-gray-300 mb-4 sm:mb-0 mt-2">
                                            <img alt="Profile photo of a person" class="w-full h-full object-cover" height="64" id="photo" src="https://storage.googleapis.com/a1aa/image/CL6TU9Fr4lE0FfkBhUs0oSt8go_YPZ3zgjapXQmYkSo.jpg" width="64"/>
                                            <input accept="image/*" class="hidden" id="photoInput" type="file"/>
                                            <label class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white p-1 rounded-full cursor-pointer" for="photoInput" id="photoLabel">
                                                <i class="fas fa-camera">
                                                </i>
                                            </label>
                                        </div>
                                        <div class="sm:ml-4 text-center sm:text-left">
                                            <h2 class="text-xl font-semibold text-black" style="font-size: 12px;">
                                                Fname MI. Lname
                                            </h2>
                                            <p class="text-black" style="font-size: 11px;">
                                                role
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="bg-white p-6 rounded-lg shadow-md">
                                            <div class="flex justify-between items-center mb-4">
                                                <h2 class="text-lg font-semibold text-black" style="font-size: 12px;">
                                                    Personal Information
                                                </h2>
                                                <button @click="validateProfile" class="text-black hover:text-gray-700" style="font-size: 12px;">
                                                    <i class="fas fa-save">
                                                    </i>
                                                    Update
                                                </button>
                                            </div>
                                            <div class="flex flex-col md:flex-row flex-wrap gap-4">
                                                <div class="flex-1">
                                                    <label class="block text-black whitespace-nowrap" style="font-size: 11px;">
                                                        First Name
                                                    </label>
                                                    <input x-model="firstName" :class="{'border-red-500': errors.firstName}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                    <span x-show="errors.firstName" class="text-red-500 text-xs" x-text="errors.firstName"></span>
                                                </div>
                                                <div class="w-full md:w-1/4">
                                                    <label class="block text-black whitespace-nowrap" style="font-size: 11px;">
                                                        Middle Initial
                                                    </label>
                                                    <input x-model="middleInitial" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-black whitespace-nowrap" style="font-size: 11px;">
                                                        Last Name
                                                    </label>
                                                    <input x-model="lastName" :class="{'border-red-500': errors.lastName}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                    <span x-show="errors.lastName" class="text-red-500 text-xs" x-text="errors.lastName"></span>
                                                </div>
                                                <div class="w-full md:w-20">
                                                    <label class="block text-black whitespace-nowrap" style="font-size: 11px;">
                                                        Extension
                                                    </label>
                                                    <input x-model="extension" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                </div>
                                            </div>
                                            <div class="flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                                                <div class="flex-1">
                                                    <label class="block text-black" style="font-size: 11px;">
                                                        Birthdate
                                                    </label>
                                                    <input x-model="birthdate" :class="{'border-red-500': errors.birthdate}"
                                                           class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black"
                                                           style="font-size: 11px;" type="date"/>
                                                    <span x-show="errors.birthdate" class="text-red-500 text-xs" x-text="errors.birthdate"></span>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-black" style="font-size: 11px;">
                                                        Gender
                                                    </label>
                                                    <select x-model="gender" :class="{'border-red-500': errors.gender}"
                                                            class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black"
                                                            style="font-size: 11px;">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <span x-show="errors.gender" class="text-red-500 text-xs" x-text="errors.gender"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bg-white p-6 rounded-lg shadow-md mt-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h2 class="text-lg font-semibold text-black" style="font-size: 12px;">
                                                Contact Information
                                            </h2>
                                            <button @click="validateContact" class="text-black hover:text-gray-700" style="font-size: 12px;">
                                                <i class="fas fa-save">
                                                </i>
                                                Update
                                            </button>
                                        </div>
                                        <div class="flex flex-col md:flex-row flex-wrap gap-4">
                                            <div class="flex-1">
                                                <label class="block text-black" style="font-size: 11px;">
                                                    Email
                                                </label>
                                                <input x-model="email" :class="{'border-red-500': errors.email}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="email"/>
                                                <span x-show="errors.email" class="text-red-500 text-xs" x-text="errors.email"></span>
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-black" style="font-size: 11px;">
                                                    Phone Number
                                                </label>
                                                <input x-model="phoneNumber" @input="formatPhoneNumber" :class="{'border-red-500': errors.phoneNumber}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                <span x-show="errors.phoneNumber" class="text-red-500 text-xs" x-text="errors.phoneNumber"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div x-show="tab === 'Security'">
                                <h1 class="text-md font-semibold mb-4 text-black">
                                    Security Settings
                                </h1>
                                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                                    <h2 class="text-xl font-semibold mb-4 text-black" style="font-size: 12px;">
                                        Change Password
                                    </h2>
                                    <div class="flex flex-col md:flex-row flex-wrap gap-4">
                                        <div class="flex-1">
                                            <div class="mb-4">
                                                <label class="block text-black" style="font-size: 11px;">
                                                    Username
                                                </label>
                                                <input x-model="username" :class="{'border-red-500': errors.username}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="text"/>
                                                <span x-show="errors.username" class="text-red-500 text-xs" x-text="errors.username"></span>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-black" style="font-size: 11px;">
                                                    Current Password
                                                </label>
                                                <input x-model="currentPassword" :class="{'border-red-500': errors.currentPassword}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="password"/>
                                                <span x-show="errors.currentPassword" class="text-red-500 text-xs" x-text="errors.currentPassword"></span>
                                            </div>
                                            <div class="md:hidden mb-4">
                                                <h3 class="text-lg font-semibold text-black" style="font-size: 12px;">
                                                    Password Instructions
                                                </h3>
                                                <ul class="list-disc list-inside text-black" style="font-size: 11px;">
                                                    <li>Must be at least 8 characters long</li>
                                                    <li>Must contain at least one uppercase letter</li>
                                                    <li>Must contain at least one lowercase letter</li>
                                                    <li>Must contain at least one number</li>
                                                    <li>Must contain at least one special character (e.g., !@#$%^&*)</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-black" style="font-size: 11px;">
                                                    New Password
                                                </label>
                                                <input x-model="newPassword" :class="{'border-red-500': errors.newPassword}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="password"/>
                                                <span x-show="errors.newPassword" class="text-red-500 text-xs" x-text="errors.newPassword"></span>
                                            </div>
                                            <div>
                                                <label class="block text-black" style="font-size: 11px;">
                                                    Confirm New Password
                                                </label>
                                                <input x-model="confirmPassword" :class="{'border-red-500': errors.confirmPassword}" class="w-full mt-1 h-7 text-gray-800 border border-gray-300 rounded p-1 pl-2 focus:ring-black focus:border-black" style="font-size: 11px;" type="password"/>
                                                <span x-show="errors.confirmPassword" class="text-red-500 text-xs" x-text="errors.confirmPassword"></span>
                                            </div>


                                            <div class="flex justify-end mt-6">
                                                <button @click="validateSecurity" class="bg-black text-white hover:bg-gray-700 px-4 py-2 rounded" style="font-size: 12px;">
                                                    <i class="fas fa-save">
                                                    </i>
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex-1 hidden md:block ml-4">
                                            <h3 class="text-lg font-semibold text-black" style="font-size: 12px;">
                                                Password Instructions
                                            </h3>
                                            <ul class="list-disc list-inside text-black" style="font-size: 11px;">
                                                <li>
                                                    Must be at least 8 characters long
                                                </li>
                                                <li>
                                                    Must contain at least one uppercase letter
                                                </li>
                                                <li>
                                                    Must contain at least one lowercase letter
                                                </li>
                                                <li>
                                                    Must contain at least one number
                                                </li>
                                                <li>
                                                    Must contain at least one special character (e.g., !@#$%^&*)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div x-show="tab === 'Developers'">
                                <h1 class="text-md font-semibold mb-4 text-black">
                                    Developers
                                </h1>
                                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                                    <h2 class="text-sm font-semibold mb-4 text-black" >
                                        Capstone Adviser
                                    </h2>

                                    <div>
                                        <div class="flex justify-center">
                                            <div class="w-24 h-24 rounded-full">
                                                <img alt="Profile image placeholder" class="w-full rounded-full" src="{{ asset('storage/assets/profile/capstone-adviser.jpg') }}" />
                                            </div>
                                        </div>
                                        <h2 class="text-xs font-semibold  text-gray-800 mt-4 text-center">Archie A. Cenas</h2>
                                    </div>

                                    <div class="mt-5">
                                        <h3 class="text-sm font-semibold text-black">Developers Information</h3>
                                        <p class="text-xs text-gray-600">Meet the developers of USeP E-Votar System</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                                            <!-- Developer 1 -->
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/raña.jpg') }}"  />
                                                </div>
                                                <h4 class="text-xs font-semibold  text-gray-800 mt-4">Lorjohn M. Raña</h4>
                                                <p class="text-[10px] text-gray-600">Full-stack Developer</p>
                                                <p class="text-[10px] text-gray-600">lorjohn143@gmail.com</p>
                                            </div>
                                            <!-- Developer 2 -->
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/ang.jfif') }}"  />
                                                </div>
                                                <h4 class="text-xs font-semibold  text-gray-800 mt-4">Sweet Frachette L. Ang</h4>
                                                <p class="text-[10px] text-gray-600">Front-end Developer</p>
                                                <p class="text-[10px] text-gray-600">sweetfrachettelaude@gmail.com</p>
                                            </div>
                                            <!-- Developer 3 -->
                                            <div class="text-center">
                                                <div class="w-24 h-24 rounded-full mx-auto">
                                                    <img alt="Developer image placeholder" class="w-full h-full rounded-full" src="{{ asset('storage/assets/profile/vargas.png') }}"  />
                                                </div>
                                                <h4 class="text-xs font-semibold  text-gray-800 mt-4">Kristine Mae L. Vargas</h4>
                                                <p class="text-[10px] text-gray-600">Front-end Developer</p>
                                                <p class="text-[10px] text-gray-600">krstnmvrgs04@gmail.com</p>
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
            function formValidation() {
                return {
                    tab: 'MyProfile',
                    firstName: '',
                    middleInitial: '',
                    lastName: '',
                    extension: '',
                    birthdate: '',
                    gender: '',
                    email: '',
                    phoneNumber: '',
                    username: '',
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                    errors: {},
                    validateProfile() {
                        this.errors = {};
                        if (!this.firstName) {
                            this.errors.firstName = 'First Name is required.';
                        }
                        if (!this.lastName) {
                            this.errors.lastName = 'Last Name is required.';
                        }
                        if (!this.birthdate) {
                            this.errors.birthdate = 'Birthdate is required.';
                        }
                        if (!this.gender) {
                            this.errors.gender = 'Gender is required.';
                        }
                    },
                    validateContact() {
                        this.errors = {};
                        if (!this.email) {
                            this.errors.email = 'Email is required.';
                        }
                        if (!this.phoneNumber) {
                            this.errors.phoneNumber = 'Phone Number is required.';
                        } else if (!/^(\+63|0)?(9\d{9})$/.test(this.phoneNumber)) {
                            this.errors.phoneNumber = 'Invalid Philippine phone number format.';
                        }
                    },
                    validateSecurity() {
                        this.errors = {};
                        if (!this.username) {
                            this.errors.username = 'Username is required.';
                        }
                        if (!this.currentPassword) {
                            this.errors.currentPassword = 'Current Password is required.';
                        }
                        if (!this.newPassword) {
                            this.errors.newPassword = 'New Password is required.';
                        }
                        if (this.newPassword !== this.confirmPassword) {
                            this.errors.confirmPassword = 'Passwords do not match.';
                        }
                    },
                    formatPhoneNumber() {
                        this.phoneNumber = this.phoneNumber.replace(/[^0-9+]/g, '');
                    }
                };
            }
        </script>

    </x-slot>
</x-app-layout>
