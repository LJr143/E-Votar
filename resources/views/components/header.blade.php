<!-- Header -->
<style>

    .icon {
        width: 38px;
        margin-right: 10px;
        border-radius: 60px;
    }
    .relative {
        position: relative;
    }

    .absolute {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-60%);
        pointer-events: none;
    }

</style>
<div class="flex w-full">
    <div class="flex relative w-1/2 ">
        <x-input type="text" placeholder="Search here" class="w-full h-[25px] pl-2 text-gray-500 text-[12px] py-4 px-4 rounded"></x-input>
        <svg class="absolute right-2 top-1/2 transform -translate-y-1/2" width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.25 0C2.795 0 0 2.795 0 6.25c0 3.455 2.795 6.25 6.25 6.25 1.482 0 2.84-.5 3.93-1.34l3.54 3.54c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41l-3.54-3.54C12.75 8.09 13.25 6.73 13.25 6.25 13.25 2.795 10.455 0 6.25 0zm0 11.25c-2.75 0-5-2.25-5-5s2.25-5 5-5 5 2.25 5 5-2.25 5-5 5z" fill="#757575"/>
        </svg>
    </div>
    <div class="flex w-1/2">
        <div class="flex px-6 ml-10 w-1/2 ">
            <img class="icon" src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" alt="usep_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/usg_logo.png') }}" alt="usg_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/tsc_logo.png') }}" alt="tsc_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" alt="tsc_comelec_logo">
        </div>
        <div class="flex justify-end relative w-1/2 px-4">
            <div class="border-[1px] border-gray-800 rounded-full">
                <img class="h-[35px] rounded-full" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="usep_logo">
            </div>
            <div class="ml-2">
                <h3 class="text-gray-900 text-[12px] tracking-tight uppercase font-semibold">{{auth()->user()->first_name}} {{auth()->user()->middle_initial}}. {{auth()->user()->last_name}}</h3>
                <p class="text-gray-500 text-[10px] capitalize">{{ auth()->user()->getRoleNames()->join(', ') }}</p>
            </div>
            <div class="flex justify-center items-center px-4">
                <svg width="11" height="5" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.3137 0.155061C11.1257 -0.0328917 10.8316 -0.0499784 10.6244 0.103801L10.565 0.155061L5.99816 4.72165L1.43134 0.155062C1.24338 -0.0328913 0.949267 -0.0499779 0.742012 0.103802L0.682634 0.155062C0.494681 0.343014 0.477595 0.63713 0.631374 0.844385L0.682634 0.903763L5.62381 5.84494C5.81176 6.03289 6.10588 6.04998 6.31313 5.8962L6.37251 5.84494L11.3137 0.903762C11.5204 0.697014 11.5204 0.361809 11.3137 0.155061Z" fill="#808080" fill-opacity="0.55"/>
                </svg>
            </div>
        </div>
    </div>
</div>
