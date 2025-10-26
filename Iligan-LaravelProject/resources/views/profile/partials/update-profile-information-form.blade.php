<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
 
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mt-4 flex flex-col md:flex-row gap-4 w-full">
            <div class="flex-1">
                <x-input-label for="fname" :value="__('First Name')" />
                <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" :value="old('fname', $user->fname ?? '')" required autofocus autocomplete="fname" />
                <x-input-error class="mt-2" :messages="$errors->get('fname')" />
            </div>
            <div class="flex-1">
                <x-input-label for="mname" :value="__('Middle Name')" />
                <x-text-input id="mname" name="mname" type="text" class="mt-1 block w-full" :value="old('mname', $user->mname ?? '')" required autofocus autocomplete="mname" />
                <x-input-error class="mt-2" :messages="$errors->get('mname')" />
            </div>
            <div class="flex-1">
                <x-input-label for="lname" :value="__('Last Name')" />
                <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" :value="old('lname', $user->lname ?? '')" required autofocus autocomplete="lname" />
                <x-input-error class="mt-2" :messages="$errors->get('lname')" />
            </div>
        </div>

        <div class="mt-4 flex flex-col md:flex-row gap-4 w-full">
            <div class="flex-2">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '')" required autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div class="flex-1">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if (! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Address Section using PSGC -->
        <div>
            <x-input-label :value="__('Address')" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
                <div>
                    <x-input-label for="region" :value="__('Region')" />
                    <select id="region" name="region" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Region</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="province" :value="__('Province')" />
                    <select id="province" name="province" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Province</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="city" :value="__('City / Municipality')" />
                    <select id="city" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select City / Municipality</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="barangay" :value="__('Barangay')" />
                    <select id="barangay" name="barangay" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Barangay</option>
                    </select>
                </div>
            </div>

            <input type="hidden" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- Profile Photo -->
        <div class="mt-6">
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            <div class="flex items-center gap-4 mt-2">
                @if ($user->profile_photo)
                    <img id="photo-preview" src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover border">
                @else
                    <div id="photo-preview" class="w-24 h-24 rounded-full bg-gray-200 border flex items-center justify-center text-gray-500">
                        <i class="fa fa-user text-3xl"></i>
                    </div>
                @endif

                <div>
                    <input id="profile_photo" name="profile_photo" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none" accept="image/*">
                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                </div>
            </div>
        </div>

        <script>
            document.getElementById('profile_photo').addEventListener('change', function (e) {
                const file = e.target.files[0];
                const preview = document.getElementById('photo-preview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        if (preview.tagName === 'IMG') {
                            preview.src = event.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className = 'w-24 h-24 rounded-full object-cover border';
                            preview.replaceWith(img);
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-orange-500 hover:bg-orange-600">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- PSGC Address JS (unchanged, just make sure hidden address updates) -->
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const regionSelect = document.getElementById('region');
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const barangaySelect = document.getElementById('barangay');
            const addressInput = document.getElementById('address');

            const regions = await fetch('https://psgc.gitlab.io/api/regions/').then(res => res.json());
            regions.forEach(r => {
                const option = document.createElement('option');
                option.value = r.code;
                option.text = r.name;
                regionSelect.appendChild(option);
            });

            const updateAddress = () => {
                const region = regionSelect.options[regionSelect.selectedIndex]?.text || '';
                const province = provinceSelect.options[provinceSelect.selectedIndex]?.text || '';
                const city = citySelect.options[citySelect.selectedIndex]?.text || '';
                const barangay = barangaySelect.options[barangaySelect.selectedIndex]?.text || '';
                addressInput.value = [barangay, city, province, region].filter(Boolean).join(', ');
            };

            [regionSelect, provinceSelect, citySelect, barangaySelect].forEach(el => el.addEventListener('change', updateAddress));

            regionSelect.addEventListener('change', async function() {
                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                citySelect.innerHTML = '<option value="">Select City / Municipality</option>';
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                if (!this.value) return;
                const provinces = await fetch(`https://psgc.gitlab.io/api/regions/${this.value}/provinces/`).then(res => res.json());
                provinces.forEach(p => provinceSelect.appendChild(new Option(p.name, p.code)));
            });

            provinceSelect.addEventListener('change', async function() {
                citySelect.innerHTML = '<option value="">Select City / Municipality</option>';
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                if (!this.value) return;
                const cities = await fetch(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`).then(res => res.json());
                cities.forEach(c => citySelect.appendChild(new Option(c.name, c.code)));
            });

            citySelect.addEventListener('change', async function() {
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                if (!this.value) return;
                const barangays = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`).then(res => res.json());
                barangays.forEach(b => barangaySelect.appendChild(new Option(b.name, b.name)));
            });
        });
    </script>
</section>
