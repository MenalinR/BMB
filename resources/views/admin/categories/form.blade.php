@extends('layouts.admin')

@php
    $editing = $category->exists;
    $field = fn ($name) => $errors->has($name) ? 'field has-error' : 'field';
    $selectedIcon = old('icon', $category->icon ?? 'fa-box');
@endphp

@section('title', $editing ? "Edit {$category->name}" : 'Add category')

@section('content')
    <div class="admin-head">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="btn-link"><i class="fas fa-arrow-left"></i> Back to categories</a>
            <h1 style="margin-top:8px">{{ $editing ? "Edit {$category->name}" : 'Add a category' }}</h1>
        </div>
    </div>

    <form method="POST" class="form-card"
          action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="form-row">
            <div class="{{ $field('name') }}">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required maxlength="100"
                       placeholder="e.g. Shoes, Sound systems">
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="{{ $field('type') }}">
                <label for="type">Shown in</label>
                <select name="type" id="type" required>
                    @foreach (\App\Models\Category::TYPES as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $category->type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="{{ $field('description') }}">
            <label for="description">Short description <span class="muted">(optional)</span></label>
            <input type="text" name="description" id="description" maxlength="500"
                   value="{{ old('description', $category->description) }}" placeholder="One sentence shown under the name">
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="{{ $field('slug') }}">
                <label for="slug">Web address <span class="muted">(optional)</span></label>
                <input type="text" name="slug" id="slug" maxlength="100" value="{{ old('slug', $category->slug) }}"
                       placeholder="Made from the name if left empty">
                <span class="hint">Letters, numbers and dashes only. Changing it breaks links people have already shared.</span>
                @error('slug') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="{{ $field('sort_order') }}">
                <label for="sort_order">Position <span class="muted">(optional)</span></label>
                <input type="number" name="sort_order" id="sort_order" min="0" max="9999"
                       value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                <span class="hint">Lower numbers are shown first.</span>
            </div>
        </div>

        <div class="{{ $field('icon') }}">
            <span class="label">Icon</span>
            <div class="icon-picker">
                @foreach (\App\Models\Category::ICONS as $icon => $label)
                    <span>
                        <input type="radio" name="icon" id="icon-{{ $icon }}" value="{{ $icon }}" @checked($selectedIcon === $icon)>
                        <label for="icon-{{ $icon }}"><i class="fas {{ $icon }}"></i>{{ $label }}</label>
                    </span>
                @endforeach
            </div>
            @error('icon') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-accent">
                <i class="fas fa-floppy-disk"></i> {{ $editing ? 'Save changes' : 'Add category' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn-link">Cancel</a>
        </div>
    </form>

    @if ($editing)
        @php $count = $category->products()->count(); @endphp
        <div class="danger-zone">
            <p>
                <strong>Delete this category.</strong>
                @if ($count)
                    Its {{ $count }} {{ Str::plural('item', $count) }} will be deleted too.
                @else
                    It has no items.
                @endif
            </p>
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                  onsubmit="return confirm('Delete {{ addslashes($category->name) }}{{ $count ? " and its {$count} items" : '' }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete category</button>
            </form>
        </div>
    @endif
@endsection
