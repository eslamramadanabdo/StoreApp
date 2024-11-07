@props([
    'name' ,
    'type'   => 'text',
    'value'  => '',
    'label'  => false
])


@if($label)
<label for="{{ $attributes->get('id') ?? $name }}"> {{ $label }}</label>
@endif


<input  type="{{ $type  }}" 
        name="{{ $name }}" 
        value="{{ old($name , $value) }}"

        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
    >

@error($name)
    <div class="invalid-feedback">
      {{$message}}
    </div>
@enderror