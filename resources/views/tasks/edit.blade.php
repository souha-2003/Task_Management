<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">✏️ {{ __('messages.edit_task') }}</h2>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; {{ __('messages.back_to_list') }}
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <x-input-label for="title" value="{{ __('messages.task_title') }} *" />
                            <x-text-input id="title" type="text" name="title" :value="old('title', $task->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <x-input-label for="description" value="{{ __('messages.task_description') }} *" />
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" />
                        </div>

                        <!-- Note -->
                        <div class="mb-4">
                            <x-input-label for="note" value="{{ __('messages.note') }} ({{ __('messages.optional') }})" />
                            <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="2">{{ old('note', $task->note) }}</textarea>
                            <x-input-error :messages="$errors->get('note')" />
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <x-input-label value="{{ __('messages.categories') }}" />
                            
                            <!-- حاوية الفئات المختارة كـ Badges في الأعلى -->
                            <div id="selected-categories-badges" class="d-flex flex-wrap gap-2 my-2 p-2 border rounded bg-light min-height-badges">
                                <span class="text-muted small py-1" id="no-categories-placeholder">{{ app()->getLocale() == 'ar' ? 'لم يتم اختيار أي تصنيف بعد' : 'No categories selected' }}</span>
                            </div>

                            <!-- قائمة منسدلة لاختيار الفئات -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="categoriesDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                    <span>🏷️ {{ __('messages.select_categories') }}</span>
                                </button>
                                <ul class="dropdown-menu w-100 p-2 shadow-sm" aria-labelledby="categoriesDropdown" style="max-height: 250px; overflow-y: auto;">
                                    @foreach ($categories as $category)
                                        <li class="dropdown-item rounded py-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" data-name="{{ $category->name }}" data-color="{{ $category->color }}" class="form-check-input category-checkbox" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || (!is_array(old('categories')) && $task->categories->contains($category->id)) ? 'checked' : '' }}>
                                                <label class="form-check-label w-100 cursor-pointer ms-2" for="category_{{ $category->id }}">
                                                    <span class="badge" style="background-color: {{ $category->color }}22; color: {{ $category->color }}; border: 1px solid {{ $category->color }}44;">
                                                        {{ $category->name }}
                                                    </span>
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <x-input-error :messages="$errors->get('categories')" />
                        </div>

                        <style>
                            .min-height-badges {
                                min-height: 48px;
                                align-items: center;
                            }
                            .cursor-pointer {
                                cursor: pointer;
                            }
                        </style>

                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const checkboxes = document.querySelectorAll('.category-checkbox');
                            const badgesContainer = document.getElementById('selected-categories-badges');
                            const placeholder = document.getElementById('no-categories-placeholder');

                            function updateBadges() {
                                badgesContainer.querySelectorAll('.selected-badge').forEach(badge => badge.remove());
                                let selectedCount = 0;

                                checkboxes.forEach(checkbox => {
                                    if (checkbox.checked) {
                                        selectedCount++;
                                        const name = checkbox.getAttribute('data-name');
                                        const color = checkbox.getAttribute('data-color');
                                        const id = checkbox.value;

                                        const badge = document.createElement('span');
                                        badge.className = 'badge selected-badge d-flex align-items-center gap-2 py-2 px-3';
                                        badge.style.backgroundColor = `${color}22`;
                                        badge.style.color = color;
                                        badge.style.border = `1px solid ${color}44`;
                                        badge.style.fontSize = '0.85rem';
                                        badge.innerHTML = `
                                            🏷️ ${name} 
                                            <span class="remove-badge-btn text-danger cursor-pointer fw-bold ms-1" style="font-size: 0.95rem; line-height: 1;" data-id="${id}">&times;</span>
                                        `;
                                        badgesContainer.appendChild(badge);
                                    }
                                });

                                if (selectedCount > 0) {
                                    placeholder.style.display = 'none';
                                } else {
                                    placeholder.style.display = 'block';
                                }
                            }

                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', updateBadges);
                            });

                            badgesContainer.addEventListener('click', function (e) {
                                if (e.target.classList.contains('remove-badge-btn')) {
                                    const id = e.target.getAttribute('data-id');
                                    const checkbox = document.getElementById(`category_${id}`);
                                    if (checkbox) {
                                        checkbox.checked = false;
                                        updateBadges();
                                    }
                                }
                            });

                            updateBadges();
                        });
                        </script>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-light px-4 fw-semibold border">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-warning text-dark px-4 fw-semibold shadow-sm">
                                {{ __('messages.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
