<div x-data="{ open: false }" x-cloak @voter-edited.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
        <svg width="14" height="18" viewBox="0 0 17 17" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1.49997 15.5H2.7615L12.9981 5.2634L11.7366 4.00188L1.49997 14.2385V15.5ZM0.90385 17C0.647767 17 0.433108 16.9133 0.259875 16.7401C0.0866248 16.5668 0 16.3522 0 16.0961V14.3635C0 14.1196 0.0467999 13.8871 0.1404 13.6661C0.233983 13.4451 0.362825 13.2526 0.526925 13.0885L13.1904 0.430775C13.3416 0.293426 13.5086 0.187292 13.6913 0.112375C13.874 0.0374582 14.0656 0 14.2661 0C14.4666 0 14.6608 0.0355838 14.8488 0.10675C15.0368 0.1779 15.2032 0.291034 15.348 0.44615L16.5692 1.68268C16.7243 1.82754 16.8349 1.99424 16.9009 2.18278C16.9669 2.37129 17 2.55981 17 2.74833C17 2.94941 16.9656 3.14131 16.8969 3.32403C16.8283 3.50676 16.719 3.67373 16.5692 3.82495L3.91147 16.473C3.74738 16.6371 3.55483 16.766 3.33383 16.8596C3.11281 16.9532 2.88037 17 2.6365 17H0.90385ZM12.3563 4.6437L11.7366 4.00188L12.9981 5.2634L12.3563 4.6437Z"
                fill="#35353A"/>
        </svg>

    </button>
    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-2/3"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Edit Voter</h2>
                    <p class="text-[10px] text-gray-500 italic">To edit a voter please fill out the required
                        information.</p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="editVoter">
                <div class="relative">
                    <div class="flex space-x-4">
                        <div class="w-full text-left">

                            <em class="text-[12px] text-black text-left font-semibold">Personal Information</em>
                            <div class="border mt-2 mb-2 p-4 rounded">
                                <div class="flex gap-4">
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            First Name
                                        </x-label>
                                        <input type="text" name="first_name" wire:model="first_name"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('first_name') border-red-500 @enderror"
                                               placeholder="Enter first name">
                                        @error('first_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Middle Initial
                                        </x-label>
                                        <input type="text" name="middle_initial" wire:model="middle_initial"
                                               class="h-[28px] text-[12px] w-full min-w-[80px] rounded border border-gray-300 @error('middle_initial') border-red-500 @enderror"
                                               placeholder="M.I">
                                        @error('middle_initial')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Last Name
                                        </x-label>
                                        <input type="text" name="last_name" wire:model="last_name"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('last_name') border-red-500 @enderror"
                                               placeholder="Enter last name">
                                        @error('last_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Extension
                                        </x-label>
                                        <input type="text" name="extension" wire:model="extension"
                                               class="h-[28px] text-[12px] w-full max-w-[150px] rounded border border-gray-300 @error('extension') border-red-500 @enderror"
                                               placeholder="Sr./Jr.">
                                        @error('extension')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Gender
                                        </x-label>
                                        <select name="gender" id="gender" wire:model="gender"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[150px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('gender') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="non-binary">Non-binary</option>
                                            <option value="prefer-not-to-say">Prefer not to say</option>
                                        </select>
                                        @error('gender')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex gap-4 mt-2">
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Birth Date
                                        </x-label>
                                        <input type="date" name="birth_date" wire:model="birth_date"
                                               class="h-[28px] text-[12px] w-full min-w-[150px] rounded border border-gray-300 @error('birth_date') border-red-500 @enderror">
                                        @error('birth_date')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Email Address
                                        </x-label>
                                        <input type="email" name="email" wire:model="email"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('email') border-red-500 @enderror"
                                               placeholder="@usep.edu.ph">
                                        @error('email')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Mobile Number
                                        </x-label>
                                        <input type="text" name="phone_number" wire:model="phone_number"
                                               class="h-[28px] text-[12px] w-full min-w-[100px] rounded border border-gray-300 @error('phone_number') border-red-500 @enderror"
                                               placeholder="+63">
                                        @error('phone_number')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Year Level
                                        </x-label>
                                        <select name="year_level" id="year_level" wire:model="year_level"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[150px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('year_level') border-red-500 @enderror">
                                            <option value="" disabled selected>Select year level</option>
                                            <option value="1st">1st year</option>
                                            <option value="2nd">2nd year</option>
                                            <option value="3rd">3rd year</option>
                                            <option value="4th">4th year</option>
                                        </select>
                                        @error('year_level')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Student ID
                                        </x-label>
                                        <input type="text" name="student_id" id="student_id" wire:model="student_id"
                                               class="h-[28px] text-[12px] w-full min-w-[100px] rounded border border-gray-300 @error('student_id') border-red-500 @enderror"
                                               placeholder="2021-00000">
                                        @error('student_id')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex gap-4 mt-2">
                                    <!-- Campus Dropdown -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">Campus</x-label>
                                        <select name="campus" id="campus" wire:model.live="campus_id"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[200px] max-w-[200px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('campus') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your campus</option>
                                            @foreach($campuses as $campus)
                                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('campus')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- College Dropdown -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">College</x-label>
                                        <select name="college" id="college" wire:model.live="college_id"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[240px] max-w-[200px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('college') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your college</option>
                                            @foreach($colleges as $college)
                                                <option value="{{ $college->id }}">{{ $college->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('college')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Program Dropdown -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">Program</x-label>
                                        <select name="program" id="program" wire:model.live="program_id"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[212px] max-w-[212px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('program')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Program Major Dropdown -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">Major</x-label>
                                        <select name="program_major" id="program_major" wire:model="program_major_id"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[212px] max-w-[212px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program_major') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program major</option>
                                            @foreach($programMajors as $programMajor)
                                                <option value="{{ $programMajor->id }}">{{ $programMajor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('program_major')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 relative w-full">
                                <p class="text-[12px] text-left font-semibold my-2">Account Status</p>
                                <div class="flex justify-start">
                                    <div class="flex-1 text-left mb-3">
                                        <p class="text-green-500">This Account is Active</p>
                                    </div>

                                    <button class="p-2 text-red-500 rounded">
                                        <p>Deactivate Account</p>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="mt-6 pt-3 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center">
                            Save User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
