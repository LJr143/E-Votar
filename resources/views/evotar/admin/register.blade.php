<style>
    label {
        font-size: 10px !important;

    }
    input, select   {
        color: black !important;
    }
</style>
<x-guest-layout>
    <div class="flex justify-between items-center align-middle p-3 bg-white sm:flex w-full h-[55px]">
        <div class="flex space-x-4">
            <img class="h-[28px] " src="{{ asset('storage/assets/logo/evotar_red.png') }}" alt="evotar_logo"/>
        </div>
        <div class="flex space-x-2 mr-8">
            <img alt="Logo 1" class=" h-[35px] mx-1 rounded-full"
                 src="{{ asset('storage/assets/logo/usep_logo.jpg') }}"/>
            <img alt="Logo 2" class=" h-[35px] mx-1 rounded-full" src="{{ asset('storage/assets/logo/usg_logo.png') }}">
            <img alt="Logo 3" class=" h-[35px] mx-1 rounded-full"
                 src="{{ asset('storage/assets/logo/tsc_logo.png') }}"/>
            <img alt="Logo 4" class=" h-[35px] mx-1 rounded-full"
                 src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}"/>

        </div>
    </div>
    <div class="bg-white py-0 pt-0 flex justify-center items-center w-full">
        <div class="w-full">

            <!--header logo and form title-->
            <h2 class="text-[30px] text-primary text-black font-semibold text-center ">
                ACCOUNT REGISTRATION<h3
                    class="text-primary font-light text-black mb-3 text-[12px] text-center capitalize ">
                    to start using the university of southeastern philippines tagum unit voting system please create a
                    superadmin account</h3></h2>

            <!--form container-->
            <div class="px-2 h-screen overflow-x-hidden ml-0 w-full flex justify-center ">
                <div>
                    <form action="{{route('admin.register')}}" method="POST" class="">
                        @csrf
                        <div class="w-[977px] bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] p-4">
                            <em class="text-[12px] text-black font-semibold">Personal Information</em>
                            <div class="border mt-2 mb-2 p-4 rounded">
                                <div class="flex gap-4">
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            First Name
                                        </x-label>
                                        <input type="text" name="first_name"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('first_name') border-red-500 @enderror"
                                               placeholder="Enter first name"
                                                value="{{ old('first_name') }}">
                                        @error('first_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Middle Initial
                                        </x-label>
                                        <input type="text" name="middle_initial"
                                               class="h-[28px] text-[12px] w-full min-w-[80px] rounded border border-gray-300 @error('middle_initial') border-red-500 @enderror"
                                               placeholder="M.I"
                                               value="{{ old('middle_initial') }}">
                                        @error('middle_initial')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Last Name
                                        </x-label>
                                        <input type="text" name="last_name"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('last_name') border-red-500 @enderror"
                                               placeholder="Enter last name"
                                               value="{{ old('last_name') }}">
                                        @error('last_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Extension
                                        </x-label>
                                        <input type="text" name="extension"
                                               class="h-[28px] text-[12px] w-full max-w-[150px] rounded border border-gray-300 @error('extension') border-red-500 @enderror"
                                               placeholder="Sr./Jr."
                                               value="{{ old('extension') }}">
                                        @error('extension')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Gender
                                        </x-label>
                                        <select name="gender" id="gender"
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
                                        <input type="date" name="birth_date"
                                               class="h-[28px] text-[12px] w-full min-w-[150px] rounded border border-gray-300 @error('birth_date') border-red-500 @enderror"
                                               value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Email Address
                                        </x-label>
                                        <input type="email" name="email"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('email') border-red-500 @enderror"
                                               placeholder="@usep.edu.ph"
                                               value="{{ old('email') }}"
                                                >
                                        @error('email')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Mobile Number
                                        </x-label>
                                        <input type="text" name="phone_number"
                                               class="h-[28px] text-[12px] w-full min-w-[100px] rounded border border-gray-300 @error('phone_number') border-red-500 @enderror"
                                               placeholder="+63"
                                               value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Year Level
                                        </x-label>
                                        <select name="year_level" id="year_level"
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
                                        <input type="text" name="student_id" id="student_id"
                                               class="h-[28px] text-[12px] w-full min-w-[100px] rounded border border-gray-300 @error('student_id') border-red-500 @enderror"
                                               placeholder="2021-00000"
                                               value="{{ old('student_id') }}">
                                        @error('student_id')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex gap-4 mt-2">
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Campus
                                        </x-label>
                                        <select name="campus" id="campus"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[200px] max-w-[200px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('campus') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your campus</option>

                                        </select>
                                        @error('campus')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            College
                                        </x-label>
                                        <select name="college" id="college"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[240px] max-w-[200px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('college') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your college</option>

                                        </select>
                                        @error('college')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Program
                                        </x-label>
                                        <select name="program" id="program"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[212px] max-w-[212px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program</option>

                                        </select>
                                        @error('program')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Major
                                        </x-label>
                                        <select name="program_major" id="program_major"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full min-w-[212px] max-w-[212px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program_major') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program major</option>

                                        </select>
                                        @error('program_major')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <em class="text-[12px] text-black font-semibold mt-4">Account Information</em>
                            <div class="border mt-2 mb-2 p-4 rounded">
                                <div class="block">
                                    <div class="">
                                        <x-label class="!text-black italic text-[10px]">
                                            Username
                                        </x-label>
                                        <input type="text" name="username"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('username') border-red-500 @enderror"
                                               placeholder="Enter username"
                                               value="{{ old('username') }}">
                                        @error('username')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                        <x-label class="!text-black italic text-[10px]">
                                            Password
                                        </x-label>
                                        <input type="password" name="password"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('password') border-red-500 @enderror"
                                               placeholder="Enter password"
                                               value="{{ old('password') }}">
                                        @error('password')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                        <x-label class="!text-black italic text-[10px]">
                                            Confirm Password
                                        </x-label>
                                        <input type="password" name="confirm_password"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('confirm_password') border-red-500 @enderror"
                                               placeholder="Confirm password"
                                               value="{{ old('confirm_password') }}">
                                        @error('confirm_password')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex justify-end mt-4">
                            <button type="submit"
                                    class="uppercase font-bold bg-gray-900 w-1/5 text-[14px] text-white rounded p-2 hover:bg-gray-800 transition duration-200">
                                Register
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Fetch campuses
            $.get('/campuses', function (data) {
                $.each(data, function (index, campus) {
                    $('#campus').append(new Option(campus.name, campus.id));
                });

                // Set the selected campus if there is an old value
                $('#campus').val('{{ old('campus') }}').change(); // Trigger change to load colleges
            });

            // Fetch colleges when a campus is selected
            $('#campus').change(function () {
                var campusId = $(this).val();
                $('#college').empty().append(new Option('Select your college', '', true, true));
                $('#program').empty().append(new Option('Select program', '', true, true));
                $('#program_major').empty().append(new Option('Select program major', '', true, true));

                $.get('/colleges/' + campusId, function (data) {
                    $.each(data, function (index, college) {
                        $('#college').append(new Option(college.name, college.id));
                    });

                    // Set the selected college if there is an old value
                    $('#college').val('{{ old('college') }}').change(); // Trigger change to load programs
                });
            });

            // Fetch programs when a college is selected
            $('#college').change(function () {
                var collegeId = $(this).val();
                $('#program').empty().append(new Option('Select program', '', true, true));
                $('#program_major').empty().append(new Option('Select program major', '', true, true));

                $.get('/programs/' + collegeId, function (data) {
                    $.each(data, function (index, program) {
                        $('#program').append(new Option(program.name, program.id));
                    });

                    // Set the selected program if there is an old value
                    $('#program').val('{{ old('program') }}').change(); // Trigger change to load majors
                });
            });

            // Fetch majors when a program is selected
            $('#program').change(function () {
                var programId = $(this).val();
                $('#program_major').empty().append(new Option('Select program major', '', true, true));

                $.get('/majors/' + programId, function (data) {
                    $.each(data, function (index, program_major) {
                        $('#program_major').append(new Option(program_major.name, program_major.id));
                    });

                    // Set the selected program major if there is an old value
                    $('#program_major').val('{{ old('program_major') }}');
                });
            });
        });
    </script>
</x-guest-layout>
