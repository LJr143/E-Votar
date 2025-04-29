<div x-data="{ open: false }" x-cloak @voter-updated.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
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
            class="bg-white p-6 rounded shadow-md w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto"
        >

            <div class="mb-4 border-b border-gray-300 pb-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <h2 class="text-sm font-bold text-left">Edit Voter</h2>
                        <span class="
                        @if($user->account_status == 'Active')
                                bg-green-100 text-green-600
                            @elseif($user->account_status == 'Deactivated')
                               bg-red-100 text-red-600
                            @elseif($user->account_status == 'Pending Verification')
                                bg-yellow-100 text-yellow-600
                            @endif text-[10px] text-left font-medium px-2 py-1 rounded">
                            @if($user->account_status == 'Active')
                                This Account is Active
                            @elseif($user->account_status == 'Deactivated')
                                This Account is Deactivated
                            @elseif($user->account_status == 'Pending Verification')
                                This Needs further Verification
                            @endif
                        </span>
                    </div>
                    <!-- Close Button (X) -->
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-[10px] text-gray-500 italic text-left">
                    To edit a voter please fill out the required information.
                </p>
            </div>


            <form wire:submit.prevent="editVoter">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <x-label class="text-left text-xs font-semibold block mb-1">First Name</x-label>
                            <input type="text" name="first_name" wire:model="first_name"
                                   class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('first_name') border-red-500 @enderror"
                                   placeholder="First Name" >
                            @error('first_name')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <x-label class="text-left text-xs font-semibold block mb-1">Middle Initial</x-label>
                            <input type="text" name="middle_initial" wire:model="middle_initial"
                                   class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('middle_initial') border-red-500 @enderror"
                                   placeholder="MI" >
                            @error('middle_initial')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <x-label class="text-left text-xs font-semibold block mb-1">Last Name</x-label>
                            <input type="text" name="last_name" wire:model="last_name"
                                   class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('last_name') border-red-500 @enderror"
                                   placeholder="Last Name" >
                            @error('last_name')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-1">
                            <x-label class="text-left text-xs font-semibold block mb-1">Extension</x-label>
                            <input type="text" name="extension" wire:model="extension"
                                   class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('extension') border-red-500 @enderror"
                                   placeholder="Extension" >
                            @error('extension')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Birth Date</x-label>
                        <input type="date" name="birth_date" wire:model="birth_date"
                               class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Gender</x-label>
                        <div class="relative mt-1">
                            <select name="gender" id="gender" wire:model="gender"
                                    class="block appearance-none border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('gender') border-red-500 @enderror">
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
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Email Address</x-label>
                        <input type="email" name="email" wire:model="email"
                               class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('email') border-red-500 @enderror"
                               placeholder="@usep.edu.ph" >
                        @error('email')
                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Mobile Number</x-label>
                        <input type="text" name="phone_number" wire:model="phone_number"
                               class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('phone_number') border-red-500 @enderror"
                               placeholder="+63">
                        @error('phone_number')
                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Campus</x-label>
                        <div class="relative mt-1">
                            <select name="campus" id="campus" wire:model.live="campus_id"
                                    class="border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('campus') border-red-500 @enderror">
                                <option value="" selected>Select your campus</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                            @error('campus')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">College</x-label>
                        <div class="relative mt-1">
                            <select name="college" id="college" wire:model.live="college_id"
                                    class="border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('college') border-red-500 @enderror">
                                <option value=""selected>Select your college</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}">{{ $college->name }}</option>
                                @endforeach
                            </select>
                            @error('college')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Program</x-label>
                        <div class="relative mt-1">
                            <select name="program" id="program" wire:model.live="program_id"
                                    class="border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('program') border-red-500 @enderror">
                                <option value=""  selected>Select program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                            @error('program')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Major</x-label>
                        <div class="relative mt-1">
                            <select name="program_major" id="program_major" wire:model="program_major_id"
                                    class="border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('program_major') border-red-500 @enderror">
                                <option value=""  selected>Select program major</option>
                                @foreach($programMajors as $programMajor)
                                    <option value="{{ $programMajor->id }}">{{ $programMajor->name }}</option>
                                @endforeach
                            </select>
                            @error('program_major')
                            <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Student ID</x-label>
                        <input type="text" name="student_id" id="student_id" wire:model="student_id"
                               class="border border-gray-300 text-xs rounded px-4 py-2 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('student_id') border-red-500 @enderror"
                               placeholder="2021-00000" >
                        @error('student_id')
                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label class="text-left text-xs font-semibold block mb-1">Year Level</x-label>
                        <div class="relative mt-1">
                            <select name="year_level" id="year_level" wire:model="year_level"
                                    class="border border-gray-300 text-xs rounded px-2 py-0 w-full focus:ring-black focus:border-black h-[28px] text-[12px] @error('year_level') border-red-500 @enderror">
                                <option value="" disabled selected>Select year level</option>
                                <option value="1st Year">1st year</option>
                                <option value="2nd Year">2nd year</option>
                                <option value="3rd Year">3rd year</option>
                                <option value="4th Year">4th year</option>
                                <option value="5th Year">5th year</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-2 sm:mt-4 pt-3 flex flex-col md:flex-row  w-full justify-end items-center">
                    <div class="flex space-x-2 justify-end w-full md:w-auto">
                        <button type="button"
                                class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
            <div class=" w-full flex justify-start mt-[-25px]">
                @if($user->account_status == 'Active')
                   <div class="flex justify-between space-x-2">
                       <livewire:account-status-management.deactivation :user_id="$user->id"/>
                       <livewire:account-status-management.update-facial-data :user_id="$user->id"/>
                   </div>
                @elseif($user->account_status == 'Deactivated')
                    <livewire:account-status-management.activation :user_id="$user->id"/>
                @elseif($user->account_status == 'Pending Verification')
                    <livewire:account-status-management.pending-verification :user_id="$user->id"/>
                @endif
            </div>
        </div>
    </div>
</div>
