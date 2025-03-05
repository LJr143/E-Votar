<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <form>
            <div class="max-w-full mx-auto py-12 px-4 sm:px-6 lg:px-10">
                <div class="p-10 rounded-lg flex flex-col lg:flex-row w-full">
                    <div class="lg:w-1/2 mb-8 lg:mb-0">
                        <h2 class="text-3xl font-bold mb-4 text-lg">Our Frequently Asked Questions</h2>
                        <p class="text-gray-600 text-xs">Have a question? Find answers to common queries about our online voting system.</p>
                    </div>
                    <div class="lg:w-1/2 space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">How do I register to vote online?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                To register to vote online, visit our registration page, fill out the required information, and submit the form. You will receive a confirmation email once your registration is complete.
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">Is my vote secure?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                Yes, our online voting system uses advanced encryption and security measures to ensure that your vote is secure and confidential.
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">Can I change my vote after submitting?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                No, once you have submitted your vote, it cannot be changed. Please review your choices carefully before submitting.
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">What if I encounter technical issues while voting?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                If you encounter any technical issues while voting, please contact our support team immediately for assistance. We are here to help ensure your vote is counted.
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">How do I know my vote was counted?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                After submitting your vote, you will receive a confirmation message indicating that your vote has been successfully recorded.
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ open: false }">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <h3 class="font-semibold text-xs">What devices can I use to vote online?</h3>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                            </div>
                            <div x-show="open" class="accordion-content text-gray-600 mt-2 text-[11px]">
                                You can vote online using any device with internet access, including smartphones, tablets, laptops, and desktop computers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>



    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>

</x-custom-layout>
