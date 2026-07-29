<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger px-4 py-2 fw-semibold']) }}>
    {{ $slot }}
</button>
