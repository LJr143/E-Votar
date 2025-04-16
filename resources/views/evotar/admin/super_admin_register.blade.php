<style>
    label {
        font-size: 10px !important;

    }
    input, select   {
        color: black !important;
    }
    .shadow-line {
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); /* Creates a subtle shadow */
        width: 100%;  /* Ensures it spans the full width */
        height: 2px;  /* Adjusts thickness if needed */
        background-color: transparent; /* Makes the line itself invisible */
        margin: 6px 0; /* Adds spacing around the shadow */

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
            <div class="mb-5 shadow-line"></div>
            <!--header logo and form title-->
            <h2 class="text-[30px] mt-5 text-primary text-black font-semibold text-center ">
                ACCOUNT REGISTRATION<h3
                    class="text-primary font-light text-black mb-3 text-[12px] text-center capitalize ">
                    to start using the university of southeastern philippines tagum unit voting system please create a
                    superadmin account</h3>
            </h2>


            <!--form container-->
            <div class="px-2 min-h-screen overflow-hidden ml-0 w-full flex justify-center">
            <div>
                    <form action="{{route('admin.register.post.superadmin')}}" method="POST" class="">
                        @csrf
                        <div class="w-full sm:w-[600px] md:w-[800px] lg:w-[1000px] xl:w-[1200px] max-w-[1200px] rounded border-2 border-solid border-gray-300 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] p-4">
                            <em class="text-[12px] text-black font-semibold">
                                <svg width="50" height="40" viewBox="0 0 53 42" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="53" height="42" fill="url(#pattern0_1840_9316)"/>
                                    <defs>
                                        <pattern id="pattern0_1840_9316" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_1840_9316" transform="matrix(0.00825472 0 0 0.0104167 0.103774 0)"/>
                                        </pattern>
                                        <image id="image0_1840_9316" width="96" height="96" xlink:href="data:image/png;base64,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"/>
                                    </defs>
                                </svg>
                                Personal Information</em>
                            <div class="border mt-2 mb-2 p-4 rounded">
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <!-- First Name -->
                                    <div class="flex flex-col flex-grow">
                                        <x-label class="!text-black italic text-[10px]">
                                            First Name
                                        </x-label>
                                        <input type="text" name="first_name"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('first_name') border-red-500 @enderror"
                                               placeholder="Enter first name"
                                               value="{{ old('first_name') }}">
                                        @error('first_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Middle Initial -->
                                    <div class="flex flex-col w-[80px]">
                                        <x-label class="!text-black italic text-[10px]">
                                            Middle Initial
                                        </x-label>
                                        <input type="text" name="middle_initial"
                                               class="px-2 py-0 h-[28px] text-[12px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('middle_initial') border-red-500 @enderror"
                                               placeholder="M.I."
                                               value="{{ old('middle_initial') }}">
                                        @error('middle_initial')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="flex flex-col flex-grow">
                                        <x-label class="!text-black italic text-[10px]">
                                            Last Name
                                        </x-label>
                                        <input type="text" name="last_name"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('last_name') border-red-500 @enderror"
                                               placeholder="Enter last name"
                                               value="{{ old('last_name') }}">
                                        @error('last_name')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Extension -->
                                    <div class="flex flex-col w-[100px]">
                                        <x-label class="!text-black italic text-[10px]">
                                            Extension
                                        </x-label>
                                        <input type="text" name="extension"
                                               class="px-2 py-0 h-[28px] text-[12px] rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('extension') border-red-500 @enderror"
                                               placeholder="Jr./Sr."
                                               value="{{ old('extension') }}">
                                        @error('extension')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="flex flex-wrap gap-4 mt-4">
                                    <!-- Gender -->
                                    <div class="flex flex-col w-[150px]">
                                        <x-label class="!text-black italic text-[10px]">
                                            Gender
                                        </x-label>
                                        <select name="gender" id="gender"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('gender') border-red-500 @enderror">
                                            <option value="" disabled selected>Select gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Birth Date -->
                                    <div class="flex flex-col w-[180px]">
                                        <x-label class="!text-black italic text-[10px]">
                                            Birth Date
                                        </x-label>
                                        <input type="date" name="birth_date"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('birth_date') border-red-500 @enderror"
                                               value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="flex flex-col flex-grow">
                                        <x-label class="!text-black italic text-[10px]">
                                            Email
                                        </x-label>
                                        <input type="email" name="email"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                                               placeholder="@usep.edu.ph"
                                               value="{{ old('email') }}">
                                        @error('email')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Phone Number -->
                                    <div class="flex flex-col w-[180px]">
                                        <x-label class="!text-black italic text-[10px]">
                                            Mobile Number
                                        </x-label>
                                        <input type="text" name="phone_number"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('phone_number') border-red-500 @enderror"
                                               placeholder="Enter phone number"
                                               value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                            </div>


                            <!-- Academic Details Section -->
                            <em class="text-[12px] text-black font-semibold mt-8">
                                <svg width="44" height="34" viewBox="0 0 44 34" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="44" height="34" fill="url(#pattern0_1840_7109)"/>
                                    <defs>
                                        <pattern id="pattern0_1840_7109" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_1840_7109" transform="matrix(0.00804924 0 0 0.0104167 0.113636 0)"/>
                                        </pattern>
                                        <image id="image0_1840_7109" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAEZElEQVR4nO2cS4gcRRjHR42KelpQMT4ugngQBTWigo+LR19RxtMi7G79fz29OIcJGsFXH1TwqgdFEKM55KAnieATRWI8xKvRkzHkYNBgILIhKBtGPrcCQV1neumpfuz3g4Jmp6fqe9W/eoqt7vUcx3Ecx3Ecx3Ecx3Ecp4H0+/3zQgg3sMZuST8CPwN7gaeBu/r9/gV129kZ5ufnL7GgxuDulXQcGE9oK5K+lvQK8ECe53N1+9EaFhcXr7SgWfAsiMAfUwR8UluVdFDSm1mWPW4zqG4/mywn40Rt88nWBuVknKh1T7ZmJCfjRK1dspVQTlbPDkye59cmTHRzZCuhnKyUlYYm27Zh2lxl/X/PzoOtk61UctJLRKqCqszg1k3ZksxKtnpV0RQ5SUVVslWZQU2WkybLVmWDt0lOmiRblQ0m6YikPZKeGAwGN9sUrazzjmAxsdhYjGKsjtRtk+M4Th2EEK6OTww7Jb0BfAz8AByOi9Wfkk7btaSjwPeSPgV2Ac8Bj2RZdl0Va431YX1JehR4Po7xWRzzaLThdLTJbDscP/sIeB14ynwxn3pNxByUdFs09EPg16p+SUo6AXwi6QXg9qIozp1kj91j9wJF/O6JCu35xXyU9CSwrbaHkdFodFGWZQ9Jehs4VpWDTBeAd4A+cPEZe+za/ibp3SoLYIp2zGIg6UGLyUyDXhTFligr7wMnEzo5Xqf9HuVkV7yu254V4L0Qwv0Wq0qDL2kUtbFuJ8ctabbWjSpLQAMcGrex1ZmAM3tD9otwp0kXcMvy8vIVcdviHGt5ns9lWXYVcGcI4THgJeADST9VHYzYp/X9oq0XIYQ7bOx/2mM2mq1nPcXtiZtxq41NQHyMOxADeE8VC1Ke53PAw5JeA77bQNDtO6/aw0IVe1Xmk6R7Jb0s6dvoc70JkPR5CEHApb0Zk+f5NcAQ+OJ/nLbPhnbvrO1ZWFi4zPaqLQa1JaCyAUqy6ezZdA6XxBOAJyAp+AzoeMWVxCUIT0BS8BnQ8YoriUsQnoCk4DOg4xVXEpcgPAFJwWdAxyuuJC5BeAKSgs+AjldcSVyC8AQkBZ8BHa+4krgE4QlICj4DOl5xJXEJwhOQFHwGdLziSuIShCcgKfgM6HjFlcQlCE/ApArZOhgMrreThZLus2OoIYTtdh1CuNWOkdq/e6eqOBvLxrSxow3bzaZo27Zo69ZU9lQ2wHA4vDCEcHd8gcVuO7RR5pio1s7p7pf0FrDDTs4A52/UHvtu7GOH9SnpmzLvAoq2H4inL/9+7Y752KgELC0t3STpWUlfAaemda5EOxkPXjwD3DjJHrvH7pX05YxOc54yX83naeyZaQKAQzNwcDyhHWqLPSkS4I31Y+AJoN4C8QTgCdjUEtXzNQBPQN1ViM+A+gOBS1D9waDNa0ATKIpiS/y1Pcnx/f+1feFUwGAwuDy+tXa94O+zezzYM4S1DbYQE/FbbPuyLFvyynccx3Ecx3Ecx3Ecx3F6DeYvquEAdn5yAxoAAAAASUVORK5CYII="/>
                                    </defs>
                                </svg>
                                Academic Details</em>
                            <div class="border mt-2 mb-4 p-4 rounded">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Campus -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Campus
                                        </x-label>
                                        <select name="campus" id="campus"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('campus') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your campus</option>
                                        </select>
                                        @error('campus')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- College -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            College
                                        </x-label>
                                        <select name="college" id="college"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('college') border-red-500 @enderror">
                                            <option value="" disabled selected>Select your college</option>
                                        </select>
                                        @error('college')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Program -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Program
                                        </x-label>
                                        <select name="program" id="program"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program</option>
                                        </select>
                                        @error('program')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Major -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Major
                                        </x-label>
                                        <select name="program_major" id="program_major"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('program_major') border-red-500 @enderror">
                                            <option value="" disabled selected>Select program major</option>
                                        </select>
                                        @error('program_major')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Year Level -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Year Level
                                        </x-label>
                                        <select name="year_level" id="year_level"
                                                class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('year_level') border-red-500 @enderror">
                                            <option value="" disabled selected>Select year level</option>
                                            <option value="1" {{ old('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                                            <option value="2" {{ old('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3" {{ old('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4" {{ old('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                                            <option value="5" {{ old('year_level') == '5' ? 'selected' : '' }}>5th Year</option>
                                        </select>
                                        @error('year_level')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Student ID -->
                                    <div class="flex flex-col">
                                        <x-label class="!text-black italic text-[10px]">
                                            Student ID
                                        </x-label>
                                        <input type="text" name="student_id"
                                               class="px-2 py-0 h-[28px] text-[12px] w-full rounded border border-gray-300 focus:border-blue-500 focus:outline-none @error('student_id') border-red-500 @enderror"
                                               placeholder="2021-00000"
                                               value="{{ old('student_id') }}">
                                        @error('student_id')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>




                            <em class="text-[12px] text-black font-semibold mt-6">
                                <svg width="40" height="40" viewBox="0 0 49 47" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="49" height="47" fill="url(#pattern0_1840_9317)"/>
                                    <defs>
                                        <pattern id="pattern0_1840_9317" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_1840_9317" transform="matrix(0.0099915 0 0 0.0104167 0.0204082 0)"/>
                                        </pattern>
                                        <image id="image0_1840_9317" width="96" height="96" xlink:href="data:image/png;base64,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"/>
                                    </defs>
                                </svg>
                                Account Information</em>
                            <div class="border  mt-2 mb-4 p-4 rounded">
                                <div class="block">
                                    <div class="">
                                        <x-label class="!text-black italic text-[10px] mt-2">
                                            Username
                                        </x-label>
                                        <input type="text" name="username"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('username') border-red-500 @enderror"
                                               placeholder="Enter username"
                                               value="{{ old('username') }}">
                                        @error('username')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror

                                        <x-label class="!text-black italic text-[10px] mt-4">
                                            Password
                                        </x-label>
                                        <input type="password" name="password"
                                               class="h-[28px] text-[12px] w-full min-w-[250px] rounded border border-gray-300 @error('password') border-red-500 @enderror"
                                               placeholder="Enter password"
                                               value="{{ old('password') }}">
                                        @error('password')
                                        <div class="text-red-500 text-[10px] italic mt-1">{{ $message }}</div>
                                        @enderror

                                        <x-label class="!text-black italic text-[10px] mt-4">
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
            $.get('{{ url('/campuses') }}', function (data) {
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

                $.get(`{{ url('/colleges') }}/${campusId}`, function (data) {
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

                $.get(`{{ url('/programs') }}/${collegeId}`, function (data) {
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

                $.get(`{{ url('/majors') }}/${programId}`, function (data) {
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
