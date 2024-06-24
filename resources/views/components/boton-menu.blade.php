<button {{ $attributes->merge(['type' => 'button', 'class' => 'font-semibold px-3 w-full  py-2 static ' . ($slot == 'Eliminar' ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-white border-b hover:bg-gray-100 text-gray-700') . ' font-semibold text-sm border-gray-200']) }}>
    {{ $slot }}
</button>
