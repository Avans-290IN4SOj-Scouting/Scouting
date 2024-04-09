@props(['division'])

<div class="w-full lg:w-1/{{$division}} h-1/{{$division}} lg:h-auto">
    <p class=" sm:text-[30px] md:text-2xl lg:text-xl  text-center h-full">
        {{$slot}}
    </p>
</div>