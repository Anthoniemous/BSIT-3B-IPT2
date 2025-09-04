<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("On going pa ang pag build ani nga side kay walay internet sa laboratory so wala koy mahimo kung maghulat ug mahulog ang uwak nga naa sa yuta!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
