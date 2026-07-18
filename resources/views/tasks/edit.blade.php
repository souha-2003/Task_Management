<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0 text-dark">✏️ Edit Task</h2>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-3 fw-semibold">
                    &larr; Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <x-input-label for="title" value="Title *" />
                            <x-text-input id="title" type="text" name="title" :value="old('title', $task->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <x-input-label for="description" value="Description *" />
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" />
                        </div>

                        <!-- Note -->
                        <div class="mb-4">
                            <x-input-label for="note" value="Note (Optional)" />
                            <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="3">{{ old('note', $task->note) }}</textarea>
                            <x-input-error :messages="$errors->get('note')" />
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-light px-4 fw-semibold border">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-warning text-dark px-4 fw-semibold shadow-sm">
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
