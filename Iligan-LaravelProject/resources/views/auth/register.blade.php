<x-guest-layout>
    @section('page-title')
        <h1 class="text-5xl font-extrabold text-white tracking-wide drop-shadow-lg mt-0 mb-0" style="font-family: 'Permanent Marker', cursive;">
            PAWer
        </h1>
    @endsection

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="flex items-center w-full justify-center mb-4">
            <img src="{{ asset('images/Logo.png') }}" alt="Cart Logo" style="width: 150px;">
            <h1 style="padding-left: 10px; font-size: 40px; font-family: 'Arial Black', sans-serif; color: #cc5500; text-shadow: 1px 2px 3px #ffffff;">
                PAWer
            </h1>
        </div>

        <!-- Name Fields (One Line) -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/3">
                <x-input-label for="lname" :value="__('Last Name')" class="text-white" />
                <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus />
                <x-input-error :messages="$errors->get('lname')" class="mt-2" />
            </div>
            <div class="w-full md:w-1/3">
                <x-input-label for="fname" :value="__('First Name')" class="text-white" />
                <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required />
                <x-input-error :messages="$errors->get('fname')" class="mt-2" />
            </div>
            <div class="w-full md:w-1/3">
                <x-input-label for="mname" :value="__('Middle Name')" class="text-white" />
                <x-text-input id="mname" class="block mt-1 w-full" type="text" name="mname" :value="old('mname')" />
                <x-input-error :messages="$errors->get('mname')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" class="text-white" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="09XXXXXXXXX" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Region & Province (One Line) -->
        <div class="mt-4 flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2">
                <x-input-label for="region" :value="__('Region')" class="text-white" />
                <select id="region" name="region" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#cc5500] focus:ring focus:ring-[#cc5500]/50">
                    <option value="">Select Region</option>
                </select>
            </div>

            <div class="w-full md:w-1/2">
                <x-input-label for="province" :value="__('Province')" class="text-white" />
                <select id="province" name="province" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#cc5500] focus:ring focus:ring-[#cc5500]/50">
                    <option value="">Select Province</option>
                </select>
            </div>
        </div>

        <!-- City & Barangay (One Line) -->
        <div class="mt-4 flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2">
                <x-input-label for="city" :value="__('City/Municipality')" class="text-white" />
                <select id="city" name="city" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#cc5500] focus:ring focus:ring-[#cc5500]/50">
                    <option value="">Select City/Municipality</option>
                </select>
            </div>

            <div class="w-full md:w-1/2">
                <x-input-label for="barangay" :value="__('Barangay')" class="text-white" />
                <select id="barangay" name="barangay" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#cc5500] focus:ring focus:ring-[#cc5500]/50">
                    <option value="">Select Barangay</option>
                </select>
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-white hover:text-[#cc5500] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="border border-white ms-3 !bg-[#cc5500] hover:!bg-gray-500 !focus:outline-none !focus:ring-2 !focus:ring-offset-2 focus:!ring-[#cc5500]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <div class="text-center my-4">
        <hr class="my-2">
        <span class="text-center font-bold text-white">Or</span>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('google-auth') }}"
            class="inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-white bg-[#cc5500] hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#cc5500]">
                
                <!-- Google Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                    class="w-5 h-5 mr-2 fill-current text-white">
                    <path d="M564 325.8C564 467.3 467.1 568 324 568C186.8 568 76 457.2 76 320C76 182.8 186.8 72 324 72C390.8 72 447 96.5 490.3 136.9L422.8 201.8C334.5 116.6 170.3 180.6 170.3 320C170.3 406.5 239.4 476.6 324 476.6C422.2 476.6 459 406.2 464.8 369.7L324 369.7L324 284.4L560.1 284.4C562.4 297.1 564 309.3 564 325.8z"/>
                </svg>

                <span>Sign in with Google</span>
            </a>
        </div>
    </div>


    {{-- PSGC API SCRIPT --}}
    <script>
        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');

        // Fetch regions
        fetch('https://psgc.gitlab.io/api/regions/')
            .then(res => res.json())
            .then(data => {
                data.forEach(region => {
                    regionSelect.innerHTML += `<option value="${region.code}">${region.name}</option>`;
                });
            });

        // Fetch provinces
        regionSelect.addEventListener('change', () => {
            provinceSelect.innerHTML = '<option value="">Select Province</option>';
            citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            fetch(`https://psgc.gitlab.io/api/regions/${regionSelect.value}/provinces/`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(province => {
                        provinceSelect.innerHTML += `<option value="${province.code}">${province.name}</option>`;
                    });
                });
        });

        // Fetch cities
        provinceSelect.addEventListener('change', () => {
            citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            fetch(`https://psgc.gitlab.io/api/provinces/${provinceSelect.value}/cities-municipalities/`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.code}">${city.name}</option>`;
                    });
                });
        });

        // Fetch barangays
        citySelect.addEventListener('change', () => {
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${citySelect.value}/barangays/`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(brgy => {
                        barangaySelect.innerHTML += `<option value="${brgy.name}">${brgy.name}</option>`;
                    });
                });
        });
    </script>
</x-guest-layout>
