<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main >
            <div class="relative">
                <img alt="Background image related to voting, such as a ballot box or voting booth in black and white" class="w-full h-72 object-cover" height="300" src="https://storage.googleapis.com/a1aa/image/vScQEub-a5zB0tNl331wQZ2I2BJ-Zpjid1P3ineWGUc.jpg" width="1920"/>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">
                        Contact Us
                    </h1>
                    <nav class="mt-2">
                        <a class="text-white text-xs" href="#">
                            Home
                        </a>
                        <span class="mx-2 text-xs text-white">
                    &gt;
                </span>
                        <a class="text-white text-xs" href="#">
                            Contact Us
                        </a>
                    </nav>
                </div>
            </div>
            <div class="py-12">
                <h2 class="text-xl font-bold text-center mb-4 text-black">
                    We Value Your Questions—Get in Touch!
                </h2>
                <p class="text-center text-gray-600 mb-8 text-[12px]">
                    Have a question or feedback? We’re here to help! Just send us a message, and we’ll get back to you as soon as possible!
                </p>
                <div class="container mx-auto p-6 flex flex-col lg:flex-row justify-between items-start lg:items-start">
                    <div class="w-full lg:px-100 lg:w-1/2 mb-6 lg:ml-20 lg:mb-0 lg:pl-6 text-center lg:text-left">
                        <h1 class="text-lg font-bold mb-6" >Contact Information</h1>
                        <div class="mb-4 flex flex-col lg:flex-row items-center lg:items-start">
                            <svg
                                class="mr-4 w-7 h-7 text-black"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 2C8.13 2 5 5.13 5 9c0 3.87 7 11 7 11s7-7.13 7-11c0-3.87-3.13-7-7-7z"
                                />
                                <circle cx="12" cy="9" r="2" />
                            </svg>
                            <div>
                                <h2 class="text-xl font-semibold" style="font-size: 14px;">Address</h2>
                                <p style="font-size: 12px;">403, Port Washington Road, Canada.</p>
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col lg:flex-row items-center lg:items-start">
                            <svg class="mr-4 w-7 h-7 text-black"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z"/>
                            </svg>
                            <div>
                                <h2 class="text-xl font-semibold" style="font-size: 14px;">Phone</h2>
                                <p style="font-size: 12px;">+1 800-525-54-589</p>
                            </div>
                        </div>
                        <div class="mb-4 flex flex-col lg:flex-row items-center lg:items-start">
                            <svg class="mr-4 w-7 h-7 text-black"
                                 xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/>
                            </svg>
                            <div>
                                <h2 class="text-xl font-semibold" style="font-size: 14px;">Email Us</h2>
                                <p style="font-size: 12px;">info@wdesignkit.com</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <hr class="border-t border-gray-300 mb-2 w-3/4 mx-auto lg:mx-0">
                            <h2 class="text-xl font-semibold mb-2" style="font-size: 14px;">Follow Us :</h2>
                            <div class="flex justify-center lg:justify-start space-x-4">
                                <a href="#" class="text-black text-2xl"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="text-black text-2xl"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="text-black text-2xl"><i class="fab fa-xing"></i></a>
                                <a href="#" class="text-black text-2xl"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 bg-gray-100 p-4 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold mb-6" style="font-size: 18px;">Leave Us Your Info.</h2>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-[12px] font-medium text-gray-700 mb-1">Your Name</label>
                                <input type="text" id="name" placeholder="Your Name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" style="font-size: 12px;">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" placeholder="Email Address" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" style="font-size: 12px;">
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                <textarea id="comment" placeholder="Comment" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" style="font-size: 12px;"></textarea>
                            </div>
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" id="privacy" class="mr-2 w-4 h-4">
                                <label for="privacy" class="text-black" style="font-size: 11px;">You agree to our friendly <a href="#" class="text-black underline">privacy policy</a>.</label>
                            </div>
                            <button type="submit" class="w-full bg-black text-white p-3 rounded-lg font-semibold hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black mt-6" style="font-size: 12px;">Send Message <i class="fas fa-arrow-right ml-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </main>



    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>

</x-custom-layout>


