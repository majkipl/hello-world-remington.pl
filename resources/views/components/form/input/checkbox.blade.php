<div class="field {{ $classWrapper ?? '' }}">
    <input type="checkbox"
           name="{{ $name }}"
           id="{{ $name }}"
           class="input-checkbox checkbox"
        {{ $required ? 'required' : '' }}/>
    <label for="{{ $name }}" class="label-checkbox {{ $class ?? '' }}">
        <span>{{ $required ? '*' : '' }}{{ $slot }}</span>
    </label>
    <span class="error-post error-{{ $name }}">{{ $error }}</span>
</div>
