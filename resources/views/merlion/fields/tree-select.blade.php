@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $value = $self->getValue();
    $options = $self->getOptions();
    $placeholder = $self->getPlaceholder();
    
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position :attributes="$self->getAttributes('wrapper')">
    <select {{$attributes->merge(['class' => 'form-select'])}}
            name="{{$name}}"
            id="{{$id}}">
        <option value="">{{$placeholder}}</option>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{$optionValue}}" @selected($value == $optionValue)>
                {{$optionLabel}}
            </option>
        @endforeach
    </select>
</x-merlion::form.field>

@pushonce('scripts')
<script nonce="{{csp_nonce()}}">
document.addEventListener('DOMContentLoaded', function() {
    const treeSelects = document.querySelectorAll('[data-tree-select]');
    treeSelects.forEach(function(select) {
        // 可扩展：添加搜索、展开/折叠等功能
    });
});
</script>
@endpushonce
