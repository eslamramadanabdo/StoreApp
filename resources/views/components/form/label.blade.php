
@props([
    'id'    => '',
])

<label 
    for="{{ $id }}" 
    {{
        $attributes->class([
            'is-invalid' => $errors->has($id)
        ])
    }}
    > 
    
    {{ $slot }} 
</label>


