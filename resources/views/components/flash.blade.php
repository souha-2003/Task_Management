@props(['type' => 'success', 'message'])

<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 4000)"
     x-show="show"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="alert alert-{{ $type }} alert-dismissible fade show shadow-sm border-0" 
     role="alert">
    {{ $message }}
    <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
</div>
