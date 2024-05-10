@props(['error'])

@error($error)
    <p class="text-red-500 text-xs mt-0">{{ $message }}</p>
@enderror