<div class="field {{ $classWrapper ?? '' }}">
    <select class="input select empty {{ $class ?? '' }}"
            name="{{ $name }}"
            id="{{ $name }}"
            aria-label="{{ $placeholder }}{{ $required ? '*' : '' }}"
            {{ $required ? 'required' : '' }}
    >
        <option selected></option>
        @foreach($items as $key => $item)
            @isset($item->id)
                <option value="{{ $item->id }}" {{ isset($selected) && $selected === $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @else
                <option value="{{ $key }}" {{ isset($selected) && $selected === $key ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endisset
        @endforeach
    </select>
    <div class="placeholder">{{ $placeholder }}{{ $required ? '*' : '' }}</div>
    <span class="error-post error-{{ $name }}">{{ $error }}</span>
</div>
