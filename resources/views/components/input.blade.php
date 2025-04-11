@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300   text-black px-4 focus:border-black  focus:ring-black  rounded-md shadow-sm']) !!}>
