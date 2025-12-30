@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $placeholder = $self->getPlaceholder();
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
    $confirmation = $self->getConfirmation();
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position :attributes="$self->getAttributes('wrapper')">
    <div class="input-group">
        <input {{$attributes->merge(['class' => 'form-control'])}}
               type="password"
               name="{{$name}}"
               id="{{$id}}"
               placeholder="{{$placeholder ?: 'Enter password'}}"
               autocomplete="new-password"
        >
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('{{$id}}')">
            <i class="ti ti-eye" id="{{$id}}_icon"></i>
        </button>
    </div>
</x-merlion::form.field>

@if($confirmation)
<x-merlion::form.field label="{{$label}} Confirmation" id="{{$id}}_confirmation" :$full :$label_position>
    <div class="input-group">
        <input class="form-control"
               type="password"
               name="{{$name}}_confirmation"
               id="{{$id}}_confirmation"
               placeholder="Confirm password"
               autocomplete="new-password"
        >
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('{{$id}}_confirmation')">
            <i class="ti ti-eye" id="{{$id}}_confirmation_icon"></i>
        </button>
    </div>
</x-merlion::form.field>
@endif

@pushonce('scripts')
<script nonce="{{csp_nonce()}}">
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '_icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }
</script>
@endpushonce
