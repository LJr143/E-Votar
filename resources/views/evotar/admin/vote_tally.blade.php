<x-app-layout mainClass="flex" page_title="- Election Result">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col ">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Vote Tally</h1>
                            <p class="text-[11px] text-gray-500">Vote Tally </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-start space-y-4 w-full px-4">
                <div class="flex justify-start items-center border-b-2 border-gray-200 text-[11px] w-full">
                    <div class="px-4 py-2 border-b-4 border-black font-semibold text-black">
                        Student and Local Council Election
                    </div>
                    <div class="px-4 py-2 text-gray-500">
                        Student Council Election
                    </div>
                    <div class="px-4 py-2 text-gray-500">
                        Local Council Election
                    </div>
                    <div class="px-4 py-2 text-gray-500">
                        Special Election
                    </div>
                </div>

                <div class=" w-full" x-data="{ tab: 'per-position' }">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-500 text-[11px]">
                         View as:
                        </span>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden text-[11px] w-auto">
                            <div :class="{ 'bg-black text-white font-bold': tab === 'per-position', 'text-gray-800': tab !== 'per-position' }" @click="tab = 'per-position'" class="px-4 py-2 cursor-pointer">
                                Per Position
                            </div>
                            <div :class="{ 'bg-black text-white font-bold': tab === 'graphical', 'text-gray-800': tab !== 'graphical' }" @click="tab = 'graphical'" class="px-4 py-2 cursor-pointer">
                                Graphical
                            </div>
                            <div :class="{ 'bg-black text-white font-bold': tab === 'tabulated', 'text-gray-800': tab !== 'tabulated' }" @click="tab = 'tabulated'" class="px-4 py-2 cursor-pointer">
                                Tabulated
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 w-full">
                        <div x-show="tab === 'per-position'">
                            <div class="bg-white shadow-md rounded p-6">

                                <div class="flex justify-between items-center mb-4">
                                    <h2 class=" font-bold text-black text-[12px]">Tagum Student Council</h2>
                                    <select class="border border-gray-300 rounded p-2 text-black text-[11px]">
                                        <option value="tsc">TSC</option>
                                        <option value="bsit">BSIT</option>
                                        <option value="bsabe">BSABE</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-white shadow-md rounded-lg border border-black">
                                        <div class="bg-black p-4 rounded-t-lg">
                                            <h2 class="text-[12px] font-semibold text-white">
                                                President
                                            </h2>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-around items-center mb-4">
                                                <div class="text-center">
                                                    <img alt="Portrait of Hamisi Mtengeti" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/3ZI3Zo335N20-WsLcMyi120yqITv7o4XiZ9Ji_zaBFo.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Hamisi Mtengeti
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        9 Vote(s)
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <img alt="Abstain option" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/Zkw6G75T-ZexAltCPKCkd_i2JYLbT3lre5rz6ujJw-4.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Abstain
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        5 Vote(s)
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-center font-semibold mb-4 text-sm text-black">
                                                    Vote Tally
                                                </h3>
                                                <canvas class="w-full h-16" id="presidentChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white shadow-md rounded-lg border border-black">
                                        <div class="bg-black p-4 rounded-t-lg">
                                            <h2 class="text-[12px] font-semibold text-white">
                                                Internal Vice President
                                            </h2>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-around items-center mb-4">
                                                <div class="text-center">
                                                    <img alt="Portrait of Henry Kasembe" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/R-ruC38gFy0tP8ZKCz9jxwm2FrDdfk1_LypKjzpxBmE.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Henry Kasembe
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        24 Vote(s)
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <img alt="Abstain option" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/Zkw6G75T-ZexAltCPKCkd_i2JYLbT3lre5rz6ujJw-4.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Abstain
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        3 Vote(s)
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-center font-semibold mb-4 text-sm text-black">
                                                    Vote Tally
                                                </h3>
                                                <canvas class="w-full h-24" id="internalVicePresidentChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white shadow-md rounded-lg border border-black">
                                        <div class="bg-black p-4 rounded-t-lg">
                                            <h2 class="text-[12px] font-semibold text-white">
                                                External Vice President
                                            </h2>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-around items-center mb-4">
                                                <div class="text-center">
                                                    <img alt="Portrait of Lisa Henry" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/pOscw8unxPl16ptgQsug2Vd6v844Tbh30QCKkEgsRxw.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Lisa Henry
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        11 Vote(s)
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <img alt="Abstain option" class="rounded-full mx-auto mb-2" height="80" src="https://storage.googleapis.com/a1aa/image/Zkw6G75T-ZexAltCPKCkd_i2JYLbT3lre5rz6ujJw-4.jpg" width="80"/>
                                                    <p class="font-semibold text-[12px] text-black">
                                                        Abstain
                                                    </p>
                                                    <p class="text-gray-600 text-[11px]">
                                                        7 Vote(s)
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-center font-semibold mb-4 text-sm text-black">
                                                    Vote Tally
                                                </h3>
                                                <canvas class="w-full h-24" id="externalVicePresidentChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-2">
                                <canvas id="presidentChart"></canvas>
                                <canvas id="internalVicePresidentChart"></canvas>
                                <canvas id="externalVicePresidentChart"></canvas>
                            </div>
                        </div>
                    </div>


                    <div  x-show="tab === 'graphical'">

                        <div class="bg-white p-4 rounded-lg shadow-lg w-full ">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold text-black" style="font-size: 14px;">Tagum Student Council</h2>
                                <select class="border border-gray-300 rounded p-2 text-black" style="font-size: 12px;">
                                    <option value="tsc">TSC</option>
                                    <option value="bsit">BSIT</option>
                                    <option value="bsabe">BSABE</option>
                                </select>
                            </div>
                            <div class="flex justify-around mb-4">
                                <div class="text-center">
                                    <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Voters</h4>
                                    <p class="text-lg text-black" style="font-size: 12px;">7200</p>
                                </div>
                                <div class="border-l border-gray-300 mx-4"></div>
                                <div class="text-center">
                                    <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Voted</h4>
                                    <p class="text-lg text-black" style="font-size: 12px;">4900</p>
                                </div>
                                <div class="border-l border-gray-300 mx-4"></div>
                                <div class="text-center">
                                    <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Did Not Vote</h4>
                                    <p class="text-lg text-black" style="font-size: 12px;">2300</p>
                                </div>
                            </div>
                            <div class="relative h-96">
                                <canvas id="myChart" class="absolute top-0 left-0 w-full h-full"></canvas>
                            </div>
                        </div>
                        <div><canvas id="myChart"></canvas></div>
                    </div>


                    <div  x-show="tab === 'tabulated'">
                        <div class="bg-white shadow-md rounded p-6">
                            <div class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">

                                <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                                    <div class="flex space-x-2">
                                        <button class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <mask id="mask0_782_22521" style="mask-type:alpha"
                                                      maskUnits="userSpaceOnUse"
                                                      x="0" y="0" width="24" height="24">
                                                    <rect width="24" height="24" fill="#D9D9D9"/>
                                                </mask>
                                                <g mask="url(#mask0_782_22521)">
                                                    <path
                                                        d="M8.30826 20.4998C7.81115 20.4998 7.38559 20.3228 7.03159 19.9688C6.67757 19.6148 6.50056 19.1893 6.50056 18.6921V16.4998H4.59674C4.09962 16.4998 3.67406 16.3228 3.32006 15.9688C2.96606 15.6148 2.78906 15.1893 2.78906 14.6921V10.8075C2.78906 10.0992 3.03105 9.50548 3.51501 9.02632C3.99898 8.54717 4.59031 8.30759 5.28901 8.30759H18.7121C19.4204 8.30759 20.0141 8.54717 20.4933 9.02632C20.9724 9.50548 21.212 10.0992 21.212 10.8075V14.6921C21.212 15.1893 21.035 15.6148 20.681 15.9688C20.327 16.3228 19.9015 16.4998 19.4043 16.4998H17.5005V18.6921C17.5005 19.1893 17.3235 19.6148 16.9695 19.9688C16.6155 20.3228 16.1899 20.4998 15.6928 20.4998H8.30826ZM4.59674 14.9999H6.50056C6.5134 14.514 6.69493 14.0976 7.04516 13.7508C7.3954 13.404 7.81643 13.2306 8.30826 13.2306H15.6928C16.1846 13.2306 16.6057 13.404 16.9559 13.7508C17.3061 14.0976 17.4877 14.514 17.5005 14.9999H19.4043C19.4941 14.9999 19.5678 14.971 19.6255 14.9133C19.6832 14.8556 19.7121 14.7819 19.7121 14.6921V10.8075C19.7121 10.5242 19.6162 10.2867 19.4246 10.095C19.2329 9.90338 18.9954 9.80754 18.7121 9.80754H5.28901C5.00568 9.80754 4.76818 9.90338 4.57651 10.095C4.38485 10.2867 4.28901 10.5242 4.28901 10.8075V14.6921C4.28901 14.7819 4.31786 14.8556 4.37556 14.9133C4.43326 14.971 4.50699 14.9999 4.59674 14.9999ZM16.0005 8.30759V5.61529C16.0005 5.52554 15.9717 5.45182 15.914 5.39412C15.8563 5.33643 15.7826 5.30759 15.6928 5.30759H8.30826C8.21851 5.30759 8.14479 5.33643 8.08709 5.39412C8.02939 5.45182 8.00054 5.52554 8.00054 5.61529V8.30759H6.50056V5.61529C6.50056 5.11819 6.67757 4.69263 7.03159 4.33862C7.38559 3.98462 7.81115 3.80762 8.30826 3.80762H15.6928C16.1899 3.80762 16.6155 3.98462 16.9695 4.33862C17.3235 4.69263 17.5005 5.11819 17.5005 5.61529V8.30759H16.0005ZM17.8082 12.3075C18.0915 12.3075 18.329 12.2117 18.5207 12.02C18.7124 11.8284 18.8082 11.5909 18.8082 11.3075C18.8082 11.0242 18.7124 10.7867 18.5207 10.595C18.329 10.4034 18.0915 10.3075 17.8082 10.3075C17.5249 10.3075 17.2874 10.4034 17.0957 10.595C16.904 10.7867 16.8082 11.0242 16.8082 11.3075C16.8082 11.5909 16.904 11.8284 17.0957 12.02C17.2874 12.2117 17.5249 12.3075 17.8082 12.3075ZM16.0005 18.6921V15.0383C16.0005 14.9486 15.9717 14.8749 15.914 14.8172C15.8563 14.7595 15.7826 14.7306 15.6928 14.7306H8.30826C8.21851 14.7306 8.14479 14.7595 8.08709 14.8172C8.02939 14.8749 8.00054 14.9486 8.00054 15.0383V18.6921C8.00054 18.7819 8.02939 18.8556 8.08709 18.9133C8.14479 18.971 8.21851 18.9999 8.30826 18.9999H15.6928C15.7826 18.9999 15.8563 18.971 15.914 18.9133C15.9717 18.8556 16.0005 18.7819 16.0005 18.6921Z"
                                                        fill="#000000"/>
                                                </g>
                                            </svg>
                                        </button>
                                        <button class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">
                                            <svg width="12" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1.25605V5.18007C11 5.71212 11 5.97814 11.109 6.18136C11.2049 6.36011 11.3578 6.50544 11.546 6.59652C11.7599 6.70007 12.0399 6.70007 12.6 6.70007H16.7305M6 13.35L9 16.2M9 16.2L12 13.35M9 16.2L9 10.5M11 1H5.8C4.11984 1 3.27976 1 2.63803 1.31063C2.07354 1.58387 1.6146 2.01987 1.32698 2.55613C1 3.16578 1 3.96385 1 5.56V15.44C1 17.0361 1 17.8342 1.32698 18.4439C1.6146 18.9801 2.07354 19.4161 2.63803 19.6894C3.27976 20 4.11984 20 5.8 20H12.2C13.8802 20 14.7202 20 15.362 19.6894C15.9265 19.4161 16.3854 18.9801 16.673 18.4439C17 17.8342 17 17.0362 17 15.44V6.7L11 1Z" stroke="#000000" stroke-width="1.8625" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <button class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none" onclick="toggleFilter()">
                                            <svg width="14" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.5 1.5H1.5L9.5 10.96V17.5L13.5 19.5V10.96L21.5 1.5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:justify-center  w-full md:w-auto mt-2">
                                        <div class="relative sm:w-[250px] mb-4">
                                            <input type="text" placeholder="Search..." aria-label="Search" class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full">
                                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>



                                <div class="overflow-x-auto mt-4 min-h-[350px]">
                                    <table class="min-w-full ">
                                        <thead>
                                        <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                            <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-black" x-model="selectAll" @click="checkboxes.forEach(checkbox => checkbox.checked = $event.target.checked)">
                                            </th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Candidate</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Position</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Partylist</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Program</th>
                                            <th class="py-3 px-6 text-left border-b border-gray-300">Abstain Count</th>
                                            <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300">Vote Tally</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black text-[12px] font-light">
                                        <tr class="border-b border-gray-100 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">Brooklyn Simmons</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">President</td>
                                            <td class="py-3 px-6 text-left">Yanong Agila</td>
                                            <td class="py-3 px-6 text-left">Bachelor of Science in Information Technology</td>
                                            <td class="py-3 px-6 text-left">17 votes</td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-bold">57 votes</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
