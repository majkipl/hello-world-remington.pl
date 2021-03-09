<div class="field file-uploads field-uploads  {{ $class ?? '' }}">
    <div class="row row-form">
        <div class="col-12 col-md-6">
            <div class="info">
                {{ $slot }}
            </div>
            <div class="uploads uploads-d-none">
                <input type="file"
                       name="{{ $name }}"
                       id="{{ $name }}"
                       {{ $required ? 'required' : '' }}
                       class="upload-image upload-file file"/>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex flex-row justify-content-center align-items-center">
            <div class="thumbs hidden">
                <img alt="thumbs" id="{{ $name }}_thumb"/>
            </div>
            <button class="button file-button button-uploads" type="button">Wybierz plik</button>
        </div>
        <div class="col-12">
            <div class="error-post error-{{ $name }}">{{ $error }}</div>
        </div>
    </div>
</div>
