<div class="absolute bottom-0 end-0 m-6"
     role="alert">
    <div class="toast-{{ $type }} flex p-4">
        <span class="font-bold">
            {{ __('toast/toast_types.' . $type) }} -
        </span>
        &nbsp;{{ $message }}
    </div>
</div>


