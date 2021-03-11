<div class="field {{ $class ?? '' }}">
    <input type="hidden"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ $value }}"
           class="input"
    />
    <span class="error-post error-{{ $name }}">{{ $error }}</span>
</div>
