<label for="{{ $name }}" class="sr-only">{{ $label }}</label>
<select id="{{ $name }}" name="{{ $name }}"
        class="filter w-fit border py-3 px-4 pe-9 block border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
    <option selected value="{{ null }}">{{ $placeholder }}</option>
    @foreach($options as $option)
        <option value="{{ $option }}">{{ $option }}</option>
    @endforeach
</select>
