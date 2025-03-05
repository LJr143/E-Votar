<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="bg-gray-600 flex items-center justify-center p-10">
                <h1 class="text-white text-xl sm:text-3xl font-bold text-center">Elections</h1>
            </div>

            <div class="container mx-auto p-4">
                <p class="text-gray-600 text-left mb-8 text-[11px]">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div>
                            <h2 class="text-[12px] font-bold text-gray-800">Tagum Student Council and Local Council Election 2025</h2>
                            <p class="text-gray-600 text-[11px]">🏫 Campus: Main Campus</p>
                            <p class="text-gray-600 text-[11px]">⏰ Election period: March 1, 2025 - March 1, 2026</p>
                            <p class="text-gray-600 text-[11px]">👥 Candidates: 10</p>
                        </div>
                        <button class="bg-black text-white px-4 py-2 rounded-lg text-[11px] mt-4">View Candidates</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div>
                            <h2 class="text-[12px] font-bold text-gray-800">Tagum Student Council and Local Council Election 2025</h2>
                            <p class="text-gray-600 text-[11px]">🏫 Campus: Main Campus</p>
                            <p class="text-gray-600 text-[11px]">⏰ Election period: March 1, 2025 - March 1, 2026</p>
                            <p class="text-gray-600 text-[11px]">👥 Candidates: 8</p>
                        </div>
                        <button class="bg-black text-white px-4 py-2 rounded-lg text-[11px] mt-4">View Candidates</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div>
                            <h2 class="text-[12px] font-bold text-gray-800">Tagum Student Council and Local Council Election 2025</h2>
                            <p class="text-gray-600 text-[11px]">🏫 Campus: Main Campus</p>
                            <p class="text-gray-600 text-[11px]">⏰ Election period: March 1, 2025 - March 1, 2026</p>
                            <p class="text-gray-600 text-[11px]">👥 Candidates: 12</p>
                        </div>
                        <button class="bg-black text-white px-4 py-2 rounded-lg text-[11px] mt-4">View Candidates</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div>
                            <h2 class="text-[12px] font-bold text-gray-800">Tagum Student Council and Local Council Election 2025</h2>
                            <p class="text-gray-600 text-[11px]">🏫 Campus: Main Campus</p>
                            <p class="text-gray-600 text-[11px]">⏰ Election period: March 1, 2025 - March 1, 2026</p>
                            <p class="text-gray-600 text-[11px]">👥 Candidates: 15</p>
                        </div>
                        <button class="bg-black text-white px-4 py-2 rounded-lg text-[11px] mt-4">View Candidates</button>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div>
                            <h2 class="text-[12px] font-bold text-gray-800">Tagum Student Council and Local Council Election 2025</h2>
                            <p class="text-gray-600 text-[11px]">🏫 Campus: Main Campus</p>
                            <p class="text-gray-600 text-[11px]">⏰ Election period: March 1, 2025 - March 1, 2026</p>
                            <p class="text-gray-600 text-[11px]">👥 Candidates: 9</p>
                        </div>
                        <button class="bg-black text-white px-4 py-2 rounded-lg text-[11px] mt-4">View Candidates</button>
                    </div>
                </div>



                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <nav class="flex items-center space-x-1">
                        <a class="px-3 py-1 bg-black text-white rounded-md text-[11px]" href="#">1</a>
                        <a class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-[11px]" href="#">2</a>
                        <a class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-[11px]" href="#">3</a>
                        <a class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-[11px]" href="#">4</a>
                        <a class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-[11px]" href="#"><i class="fas fa-chevron-right"></i></a>
                    </nav>
                </div>
            </div>



        </main>



    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>

</x-custom-layout>


