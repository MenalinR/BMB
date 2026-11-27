@extends('layouts.admin')

@php
    $editing = $product->exists;
    $selectedCategory = old('category_id', $product->category_id);
    $field = fn ($name) => $errors->has($name) ? 'field has-error' : 'field';
@endphp

@section('title', $editing ? "Edit {$product->name}" : 'Add item')

@section('content')
    <div class="admin-head">
        <div>
            <a href="{{ route('admin.products.index', ['category' => $product->category_id]) }}" class="btn-link">
                <i class="fas fa-arrow-left"></i> Back to items
            </a>
            <h1 style="margin-top:8px">{{ $editing ? "Edit {$product->name}" : 'Add an item' }}</h1>
        </div>
        @if ($editing)
            <a href="{{ $product->category->url() }}" target="_blank" class="btn btn-sm btn-outline">
                <i class="fas fa-eye"></i> See it on the website
            </a>
        @endif
    </div>

    <form method="POST" enctype="multipart/form-data" class="form-card" id="product-form"
          action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="form-grid">
            <div>
                <div class="{{ $field('category_id') }}">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Choose a category…</option>
                        @foreach ($categories as $type => $group)
                            <optgroup label="{{ \App\Models\Category::TYPES[$type] ?? $type }}">
                                @foreach ($group as $category)
                                    <option value="{{ $category->id }}" data-type="{{ $category->type }}"
                                        @selected($selectedCategory == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('category_id') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="{{ $field('name') }}">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required maxlength="255"
                           placeholder="e.g. Acoustic guitar, Cotton saree, Cashew nuts 500g">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="{{ $field('description') }}">
                    <label for="description">Description <span class="muted">(optional)</span></label>
                    <textarea name="description" id="description" maxlength="2000"
                              placeholder="Size, colour, condition, what is included…">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="{{ $field('price') }}">
                        <label for="price">Price <span class="muted">(optional)</span></label>
                        <div class="input-prefix">
                            <span>Rs.</span>
                            <input type="number" name="price" id="price" min="0" step="0.01" inputmode="decimal"
                                   value="{{ old('price', $product->price !== null ? (float) $product->price : '') }}" placeholder="Leave empty for “Ask for price”">
                        </div>
                        @error('price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="{{ $field('price_unit') }}">
                        <label for="price_unit">Charged <span class="muted">(optional)</span></label>
                        <input type="text" name="price_unit" id="price_unit" maxlength="50"
                               value="{{ old('price_unit', $product->price_unit) }}" placeholder="e.g. per day">
                        <div class="unit-chips" id="unit-chips"
                             data-rent='["per day","per hour","per week","per month","per event","per km"]'
                             data-sale='["each","per kg","per 100g","per pack","per set"]'></div>
                        @error('price_unit') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="field">
                        <span class="label">Status</span>
                        <label class="check">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $product->is_available))>
                            <span id="available-label">Available</span>
                        </label>
                        <span class="hint" id="available-hint">Untick when it is booked (rentals) or sold out (shop).</span>
                    </div>

                    <div class="{{ $field('sort_order') }}">
                        <label for="sort_order">Position <span class="muted">(optional)</span></label>
                        <input type="number" name="sort_order" id="sort_order" min="0" max="9999"
                               value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                        <span class="hint">Lower numbers are shown first.</span>
                    </div>
                </div>
            </div>

            <div>
                <div class="{{ $field('photo') }}">
                    <span class="label">Photo</span>
                    <div class="photo-box" id="photo-box">
                        @if ($product->image)
                            <img src="{{ $product->imageUrl() }}" alt="" id="photo-preview">
                        @else
                            <div id="photo-empty"><i class="fas fa-camera"></i>No photo yet</div>
                        @endif
                    </div>
                    <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp">
                    <span class="hint" id="photo-hint">JPG, PNG or WebP. Large photos are shrunk automatically.</span>
                    @error('photo') <span class="error">{{ $message }}</span> @enderror

                    @if ($product->image)
                        <label class="check" style="margin-top:8px">
                            <input type="checkbox" name="remove_photo" value="1" id="remove_photo">
                            Remove the current photo
                        </label>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-accent" id="save-btn">
                <i class="fas fa-floppy-disk"></i> {{ $editing ? 'Save changes' : 'Add item' }}
            </button>
            <a href="{{ route('admin.products.index', ['category' => $product->category_id]) }}" class="btn-link">Cancel</a>
        </div>
    </form>

    @if ($editing)
        <div class="danger-zone">
            <p><strong>Delete this item.</strong> It will be removed from the website straight away.</p>
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                  onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete item</button>
            </form>
        </div>
    @endif
@endsection

@push('scripts')
<script>
(function () {
    // Price unit suggestions that match the chosen category (rentals vs shop).
    const category = document.getElementById('category_id');
    const chips = document.getElementById('unit-chips');
    const unit = document.getElementById('price_unit');
    const availableLabel = document.getElementById('available-label');

    function renderChips() {
        const type = category.selectedOptions[0]?.dataset.type || 'sale';
        const units = JSON.parse(chips.dataset[type === 'rent' ? 'rent' : 'sale']);
        chips.innerHTML = '';
        units.forEach(function (u) {
            const b = document.createElement('button');
            b.type = 'button';
            b.textContent = u;
            b.addEventListener('click', function () { unit.value = u; unit.focus(); });
            chips.appendChild(b);
        });
        unit.placeholder = type === 'rent' ? 'e.g. per day' : 'e.g. each';
        availableLabel.textContent = type === 'rent' ? 'Available to rent' : 'In stock';
    }
    category.addEventListener('change', renderChips);
    renderChips();

    // Photo preview, and shrink big photos in the browser before upload
    // so phone photos never go over the server's upload limit.
    const input = document.getElementById('photo');
    const box = document.getElementById('photo-box');
    const hint = document.getElementById('photo-hint');
    const save = document.getElementById('save-btn');
    const MAX_SIDE = 1600;
    const MAX_BYTES = 1.5 * 1024 * 1024;

    function showPreview(file) {
        const url = URL.createObjectURL(file);
        box.innerHTML = '';
        const img = document.createElement('img');
        img.src = url;
        img.alt = '';
        box.appendChild(img);
        const remove = document.getElementById('remove_photo');
        if (remove) remove.checked = false;
    }

    function loadImage(file) {
        return new Promise(function (resolve, reject) {
            const img = new Image();
            img.onload = function () { resolve(img); };
            img.onerror = reject;
            img.src = URL.createObjectURL(file);
        });
    }

    input.addEventListener('change', async function () {
        const file = input.files[0];
        if (!file) return;
        showPreview(file);

        try {
            const img = await loadImage(file);
            const scale = Math.min(1, MAX_SIDE / Math.max(img.naturalWidth, img.naturalHeight));
            if (scale === 1 && file.size <= MAX_BYTES) {
                hint.textContent = 'Photo ready. Click Save to upload it.';
                return;
            }

            save.disabled = true;
            hint.textContent = 'Shrinking photo…';
            const canvas = document.createElement('canvas');
            canvas.width = Math.round(img.naturalWidth * scale);
            canvas.height = Math.round(img.naturalHeight * scale);
            canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);

            const blob = await new Promise(function (r) { canvas.toBlob(r, 'image/jpeg', 0.85); });
            const name = file.name.replace(/\.[^.]+$/, '') + '.jpg';
            const dt = new DataTransfer();
            dt.items.add(new File([blob], name, { type: 'image/jpeg' }));
            input.files = dt.files;
            hint.textContent = 'Photo ready (' + Math.round(blob.size / 1024) + ' KB). Click Save to upload it.';
        } catch (e) {
            hint.textContent = 'Could not read this photo. Please try a JPG or PNG.';
        } finally {
            save.disabled = false;
        }
    });
})();
</script>
@endpush
