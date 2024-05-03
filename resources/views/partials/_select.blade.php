<label class="select block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <select dusk="multiple-select-{{__($name)}}" class= "{{ $class }}" multiple name="{{ $name }}[]"
        data-hs-select='{
        "placeholder": "{{ $placeholder }}",
        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-300 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-300 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-300 dark:focus:bg-slate-800",
        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"}'>
        <option value="">Kies</option>
        @foreach ($options as $option)
            <option value="{{ $option }}"
                @if (old($name) !== null) {{ in_array($option, old($name)) ? 'selected' : '' }}
                @elseif (isset($chosenGroups))
                    {{ in_array($option, $chosenGroups->pluck('name')->toArray()) ? 'selected' : '' }} @endif>
                {{ $option }}
            </option>
        @endforeach
    </select>

    <div class="absolute top-1/2 end-3 -translate-y-1/2">
        <svg class="flex-shrink-0 size-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="m7 15 5 5 5-5" />
            <path d="m7 9 5-5 5 5" />
        </svg>
    </div>
</div>
<x-error :error="$errors->first($name)" :id="$name" />
