<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex items-center justify-center w-full px-4 py-2 bg-orange-500 text-white font-bold rounded-md hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
