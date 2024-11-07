@props([
    'name',
    'checked' => false,
    'options'
])

@foreach ($options as $value => $text)
    <div class="form-check">
        <input 
            type="radio" 
            name="{{$name}}"  
            value="{{ $value }}" 
            id="status_value"  
            @checked(old($name , $checked ) == $value)
            {{
                $attributes->class([
                    'form-check-input',
                    'is-invalid' => $errors->has($name)
                ])
            }}
        >

        <label for="status_active" class="form-check-label">{{$text}}</label>
    </div>
@endforeach

@error($name)
<div class="invalid-feedback">
    {{$message}}
</div>
@enderror