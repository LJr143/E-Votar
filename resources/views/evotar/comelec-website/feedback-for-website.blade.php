<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="relative">
                <img alt="Background image related to voting, such as a ballot box or voting booth in black and white" class="w-full h-72 object-cover" height="300" src="https://storage.googleapis.com/a1aa/image/black-and-white-voting.jpg" width="1920"/>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">
                        User Feedback
                    </h1>
                    <nav class="mt-2">
                        <a class="text-white text-xs" href="#">
                            Home
                        </a>
                        <span class="mx-2 text-xs text-white">
                          &gt;
                         </span>
                        <a class="text-white text-xs" href="#">
                            Feedback
                        </a>
                    </nav>
                </div>
            </div>
            <div class="py-12">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center mb-4 text-black">
                        We Value Your Feedback
                    </h2>
                    <p class="text-center text-gray-600 mb-8 text-sm">
                        Please provide your feedback on our online voting system. Your input helps us improve and serve you better.
                    </p>
                    <div class="flex flex-col lg:flex-row justify-center items-start lg:space-x-12">
                        <div class="lg:w-1/3 mb-8 lg:mb-0">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold mb-2 text-black">
                                    <i class="fas fa-map-marker-alt mr-2">
                                    </i>
                                    Address
                                </h3>
                                <p class="text-xs text-black">
                                    Apokon, Tagum City, Davao del Norte
                                </p>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-lg font-bold mb-2 text-black">
                                    <i class="fas fa-phone-alt mr-2">
                                    </i>
                                    Phone
                                </h3>
                                <p class="text-xs text-black">
                                    Mobile: (+63) 910-2546-6789
                                    <br/>
                                    Hotline: (+63) 910-2546-6789
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold mb-2 text-black">
                                    <i class="fas fa-clock mr-2">
                                    </i>
                                    Working Time
                                </h3>
                                <p class="text-xs text-black">
                                    Monday-Friday: 9:00 - 22:00
                                    <br/>
                                    Saturday-Sunday: 9:00 - 20:00
                                </p>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <form class="space-y-4 w-full">
                                <div>
                                    <label class="block text-gray-700 text-xs" for="name">
                                        Your Name
                                    </label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm" id="name" placeholder="Alice" type="text" required/>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-xs" for="email">
                                        Email Address
                                    </label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm" id="email" placeholder="alice@gmail.com" type="email" required/>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-xs" for="subject">
                                        Subject
                                    </label>
                                    <input class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm" id="subject" placeholder="This is optional" type="text"/>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-xs" for="message">
                                        Feedback
                                    </label>
                                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm" id="message" placeholder="Hi! I'd like to provide feedback on..." rows="4" required></textarea>
                                </div>
                                <div>
                                    <button class="w-full px-4 py-2 bg-black text-white rounded-md text-sm" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>



    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>

</x-custom-layout>


