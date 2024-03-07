<head>
    <title></title>
    @vite(['resources/js/toast.js'])
</head>

<div class="absolute bottom-0 end-0 m-6"
     role="alert">
    <div id="toast" class="toast-{{ $type }} flex p-4">
        <span class="font-bold">
            {{ __('toast/toast_types.' . $type) }} -
        </span>
        &nbsp;{{ $message }}
    </div>
</div>
