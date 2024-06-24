<button {{ $attributes->merge(['type' => 'button', 'class' => 'font-semibold px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm  text-gray-700  shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
