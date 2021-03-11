<div class="field @isset($classWrapper){{ $classWrapper }}@endisset">
    <textarea name="{{ $name }}"
              id="{{ $name }}"
              {{ $required ? 'required' : '' }}
              @if($max)
                  maxlength="{{ $max }}"
              @endif
              autocomplete="off"
              placeholder=""
              aria-label="{{ $placeholder }}{{ $required ? '*' : '' }}"
              class="textarea {{ $class ?? '' }}"
    >{{ $slot }}</textarea>
    <label class="placeholder" for="{{ $name }}">{{ $placeholder }}{{ $required ? '*' : '' }}</label>
    <span class="error-post error-{{ $name }}">{{ $error }}</span>
</div>
