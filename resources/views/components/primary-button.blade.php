<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-[' . (config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton ?? 'green')   . '] hover:bg-opacity-75 font-semibold justify-center px-3 py-2 rounded-md cursor-pointer text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
