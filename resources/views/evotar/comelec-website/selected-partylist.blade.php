<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>

            <div class="mx-auto  px-4 md:px-12">
                <div class="flex flex-col lg:flex-row">
                    <!-- Main Content -->
                    <div class="w-full lg:w-3/4 p-4 md:px-0 pt-16 mr-6 md:mb-10">
                        <div class="container mx-auto ">
                            <h1 class="text-[16px] font-semibold mb-4">
                                Members of Yanong Agila
                            </h1>
                            <div class="flex flex-col sm:flex-row mb-4">
                                <input
                                    class="text-[12px] border border-gray-300 p-2 rounded mb-2 sm:mb-0 sm:mr-2 w-full sm:w-1/3 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter candidate name"
                                    type="text"/>
                                <select class="text-[12px] border border-gray-300 p-2 rounded w-full sm:w-auto transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option class="text-gray-500" disabled selected>Select organization</option>
                                    <option>TSC</option>
                                    <option>SITS</option>
                                    <option>SABES</option>
                                    <option>AFSET</option>
                                    <option>OFEE</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <!-- Candidate Card -->
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">PRESIDENT</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>


                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">VP PRESIDENT FOR INTERNAL AFFAIR</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">VP PRESIDENT FOR EXTERNAL AFFAIR</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">GENERAL SECRETARY</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">GENERAL TREASURER</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">GENERAL AUDITOR</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">Position</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                                <div class="bg-white p-2 rounded-lg shadow relative">
                                    <p class="text-[11px] text-gray-500 h-8">
                                        Running for
                                        <span class="font-semibold text-red-500">Position</span>
                                    </p>
                                    <img alt="Portrait of Juan Dela Cruz" class="w-full h-auto rounded mt-2" height="100" src="https://storage.googleapis.com/a1aa/image/QTlv41RAMB0CE8sJoYHgAGShDQoKl_9Vaks0JjFiQUk.jpg" width="100"/>
                                    <p class="mt-2 font-semibold text-[12px]">JUAN DELA CRUZ</p>
                                    <p class="text-[11px] text-gray-500">Yanong Agila</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar -->
                    <div class="w-full md:w-1/3 lg:w-1/4 p-2 mb-10 md:py-20">


                        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
                            <h1 class="text-base  font-bold mb-4">
                                Partylist
                            </h1>

                            <div class="space-y-4">
                                <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                    <div>
                                        <p class="text-[12px] ">
                                            Yanong Agila
                                        </p>
                                        <p class="text-[10px] text-gray-500">
                                            11 Members
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                    <div>
                                        <p class="text-[12px] ">
                                            Yanong Agila
                                        </p>
                                        <p class="text-[10px] text-gray-500">
                                            11 Members
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded">
                                    <div>
                                        <p class="text-[12px] ">
                                            Yanong Agila
                                        </p>
                                        <p class="text-[10px] text-gray-500">
                                            11 Members
                                        </p>
                                    </div>
                                </div>
                            </div>
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


