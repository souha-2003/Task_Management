<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">✏️ {{ __('messages.edit_category') }}</h2>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; {{ __('messages.back_to_list') }}
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <!-- Category Name -->
                        <div class="mb-4">
                            <x-input-label for="name" value="{{ __('messages.category_name') }} *" />
                            <x-text-input id="name" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <!-- Category Color -->
                        <div class="mb-4">
                            <x-input-label for="color" value="{{ __('messages.select_category_color') }} *" />
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <input type="color" id="color" name="color" class="form-control form-control-color border shadow-sm" style="width: 80px; height: 45px; cursor: pointer;" value="{{ old('color', $category->color) }}" required>
                                <span class="text-muted small">{{ __('messages.choose_color_hint') }}</span>
                            </div>
                            <x-input-error :messages="$errors->get('color')" />
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-light px-4 fw-semibold border">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                                {{ __('messages.update_category_btn') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
