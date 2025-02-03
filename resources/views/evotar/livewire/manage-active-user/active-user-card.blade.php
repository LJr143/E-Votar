<div class="w-1/5 bg-white p-6 rounded-lg shadow">
    @if ($userSelected)
        <div class="text-center">
            <p class="text-[11px] font-semibold mb-3">USER INFORMATION</p>
            <p class="text-[11px] font-semibold mb-3">{{ $userSelected->student_id }}</p>
            <div class="relative w-20 h-20 mx-auto mb-4">
                <img class="rounded-full w-full h-full object-cover"
                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}"
                     alt="Profile Picture">
                <span class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <h2 class="text-[14px] font-bold">{{ $userSelected->first_name }} {{ $userSelected->middle_initial }} {{ $userSelected->last_name }}</h2>
            <p class="text-[12px] text-gray-500 mb-2">{{ $userSelected->role }}</p>
            <div class="flex justify-center items-center">
                <button class="flex items-center text-[12px] bg-black text-white px-4 py-2 rounded-md mb-4 hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
                        <path d="M768-90 666-192H192v-92q0-25.78 12.5-47.39T239-366q43-26 91-42t99-21L90-768l51-51 678 678-51 51ZM264-264h330l-95-96h-19q-54 0-106 14t-99 42q-4.95 2.94-7.98 8.24Q264-290.47 264-284v20Z"/>
                    </svg>
                    Block user
                </button>
            </div>
        </div>

        <div class="text-left">
            <h3 class="text-[12px] text-gray-700 font-semibold mb-2">About</h3>
            <div class="flex items-center mb-4">
                <div class="bg-gray-100 p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#434343">
                        <path d="M480-144 216-276v-240L48-600l432-216 432 216v312h-72v-276l-96 48v240L480-144Z"/>
                    </svg>
                </div>
                <span class="text-[12px] ml-4 text-gray-400">{{ $userSelected->program->name }}</span>
            </div>

            <div class="flex items-center mb-6">
                <div class="bg-gray-100 p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#434343">
                        <path d="M168-192q-29.7 0-50.85-21.16Q96-234.32 96-264.04v-432.24Q96-726 117.15-747T168-768h624q29.7 0 50.85 21.16Q864-725.68 864-695.96v432.24Q864-234 842.85-213T792-192H168Zm312-240L168-611v347h624v-347Z"/>
                    </svg>
                </div>
                <span class="text-[12px] ml-5 text-gray-400">{{ $userSelected->email }}</span>
            </div>

            <div class="flex justify-center text-gray-700">
                <div class="w-1/2 text-left pl-4">
                    <h4 class="text-[12px] font-bold">Year Level</h4>
                    <p class="text-[11px]">{{ $userSelected->year_level }} year</p>
                </div>
                <div class="w-1/2 text-center">
                    <h4 class="text-[12px] font-bold">Gender</h4>
                    <p class="text-[11px]">{{ $userSelected->gender }}</p>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-gray-400">Select a user to view details.</p>
    @endif
</div>
