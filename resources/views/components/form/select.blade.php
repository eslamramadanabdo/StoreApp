@props([
    'name',
    'select' => '',
    'options'
])




<select 
    name="{{$name}}"
   {{
        $attributes->class([
            'form-control',
            'form-select',
            'is-invalid' => $errors->has($name)
        ])
   }}
>

   @foreach($options as $value => $text)
    <option value="{{$value}}"  @selected($value == $select) >{{$text}}</option>
   @endforeach

</select>

{{-- <x-form-validation-feedback  :name="$name" /> --}}