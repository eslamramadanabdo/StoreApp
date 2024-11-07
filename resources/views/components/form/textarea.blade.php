@props([
    'name' ,
    'value'  => '',
    'label'  => false
])


@if($label)
    <label  for="{{ $attributes->get('id') ?? $name }}" > {{ $label }}</label>
@endif


<textarea 
    name="{{ $name }}" 
    id="{{ $attributes->get('id') ?? $name }}"
    {{ $attributes->class([ 
        'form-control', 
        'is-invalid' => $errors->has($name) ])
    }} >{{ old($name , $value) }}</textarea>

@error($name)
    <div class="invalid-feedback">
      {{$message}}
    </div>
@enderror