{{-- Tabla lista --}}
<div class="overflow-y-auto max-h-full">
    <table class="mt-8 w-full">
        <thead class="text-sm  text-left py-4  border-b border-gray-300">
            <tr class="text-left font-semibold border-collapse">
                {{ $head }}
            </tr>
        </thead>
        <tbody class="text-gray-500 select-none text-xs ">

            {{ $bodytable }}

        </tbody>
    </table>
    {{ $link }}
</div>
