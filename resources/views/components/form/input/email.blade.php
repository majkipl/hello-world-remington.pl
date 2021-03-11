<div class="field {{ $classWrapper ?? '' }}">
    <input type="email"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ $value }}"
           aria-label="{{ $placeholder }}{{ $required ? '*' : '' }}"
           placeholder=""
           {{ $required ? 'required' : '' }}
           @if($max)
               maxlength="{{ $max }}"
           @endif
           class="input {{ $class ?? '' }}"
           autocomplete="off"/>
    <label class="placeholder" for="{{ $name }}">{{ $placeholder }}{{ $required ? '*' : '' }}</label>
    <span class="error-post error-{{ $name }}">{{ $error }}</span>
</div>
