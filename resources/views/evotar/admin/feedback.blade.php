<x-app-layout mainClass="flex" page_title="- System Logs">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col w-full sm:w-1/3">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">
                                User Feedback
                            </h1>
                            <p class="text-[11px] text-gray-500">
                                List of feedbacks of USeP E-votar system users
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                    <div class="text-gray-600 text-[11px] mb-2 sm:mb-0">
                        Show 5/1240 results
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-[11px] text-gray-500" for="filter-date">
                            Filter by date:
                        </label>
                        <input class="text-[11px] text-gray-500 bg-gray-200 px-2 py-1 rounded" id="filter-date" type="date"/>
                    </div>
                </div>
                <!-- Review 1 -->
                <div class="bg-white p-4 rounded-lg shadow-md w-full mb-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <img alt="User profile picture" class="w-10 h-10 rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/8ZftqoempjTxwNzFY2x0_yU-4q4m1XKJBH5CioFlY-A.jpg" width="40"/>
                            <div>
                                <div class="font-semibold text-gray-800 text-[12px]">
                                    Arthur Thomas
                                </div>
                                <div class="text-[11px] text-gray-500">
                                    20.03.2024
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star-half-alt text-yellow-500 text-xs">
                            </i>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 text-[12px]">
                        The USeP E-votar system is quite user-friendly and efficient. However, the interface could be more intuitive, and the loading times are sometimes longer than expected.
                    </p>
                </div>
                <!-- Review 2 -->
                <div class="bg-white p-4 rounded-lg shadow-md w-full mb-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <img alt="User profile picture" class="w-10 h-10 rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/8ZftqoempjTxwNzFY2x0_yU-4q4m1XKJBH5CioFlY-A.jpg" width="40"/>
                            <div>
                                <div class="font-semibold text-gray-800 text-[12px]">
                                    Sara
                                </div>
                                <div class="text-[11px] text-gray-500">
                                    04.04.2024
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 text-[12px]">
                        I found the voting process to be seamless and secure. The instructions were clear, and I had no issues casting my vote.
                    </p>
                </div>
                <!-- Review 3 -->
                <div class="bg-white p-4 rounded-lg shadow-md w-full mb-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <img alt="User profile picture" class="w-10 h-10 rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/8ZftqoempjTxwNzFY2x0_yU-4q4m1XKJBH5CioFlY-A.jpg" width="40"/>
                            <div>
                                <div class="font-semibold text-gray-800 text-[12px]">
                                    Katherine Smith
                                </div>
                                <div class="text-[11px] text-gray-500">
                                    24.04.2024
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star text-yellow-500 text-xs">
                            </i>
                            <i class="fas fa-star-half-alt text-yellow-500 text-xs">
                            </i>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-700 text-[12px]">
                        The system works well overall, but I encountered a few glitches during the registration process. Once registered, voting was straightforward.
                    </p>
                </div>
                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <div class="text-[11px] text-gray-500">
                        Page 1 of 248
                    </div>
                    <div class="flex space-x-2">
                        <button class="text-[11px] text-gray-500 bg-gray-200 px-3 py-1 rounded">
                            Previous
                        </button>
                        <button class="text-[11px] text-gray-500 bg-gray-200 px-3 py-1 rounded">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
