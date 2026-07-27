<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 col-12 mb-3 mb-md-0">
            <h2 class="fw-bold mb-0 text-dark">🏷️ {{ __('messages.categories') }}</h2>
        </div>
        @can('manage categories')
        <div class="col-md-6 col-12 text-md-end text-start">
            <a href="{{ route('categories.create') }}" class="btn btn-primary px-4 fw-semibold shadow-sm">
                ➕ {{ __('messages.create_category') }}
            </a>
        </div>
        @endcan
    </div>

    <!-- Categories List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($categories->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">{{ __('messages.no_categories') }}</h5>
                    @can('manage categories')
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">{{ __('Create Your First Category') }}</a>
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="py-3 px-4">{{ __('messages.category_name') }}</th>
                                <th scope="col" class="py-3">{{ __('messages.color') }}</th>
                                <th scope="col" class="py-3 text-center">{{ __('messages.tasks_count') }}</th>
                                <th scope="col" class="py-3 text-center px-4">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2 text-capitalize" style="font-size: 0.85rem; background-color: {{ $category->color }}1a; color: {{ $category->color }}; border: 1px solid {{ $category->color }}33;">
                                            {{ $category->name }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-semibold text-secondary">
                                        {{ $category->tasks->count() }}
                                    </td>
                                    <td class="text-center px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-info btn-sm px-3 fw-semibold">
                                                {{ __('messages.view') }}
                                            </a>
                                            @can('manage categories')
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-warning btn-sm px-3 fw-semibold">
                                                {{ __('messages.edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-semibold">
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
