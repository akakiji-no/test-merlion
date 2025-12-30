@php
    $isChecked = in_array($item['id'], $selectedValues);
    $hasChildren = !empty($item['children']);
    $marginLeft = $level * 24;
@endphp

<div class="tree-checkbox-item" style="margin-left: {{ $marginLeft }}px;">
    <div class="form-check">
        <input type="checkbox" 
               class="form-check-input" 
               name="{{ $name }}[]" 
               value="{{ $item['id'] }}"
               id="{{ $name }}_{{ $item['id'] }}"
               @checked($isChecked)>
        <label class="form-check-label" for="{{ $name }}_{{ $item['id'] }}">
            {{ $item['name'] }}
        </label>
    </div>
    
    @if($hasChildren)
        @foreach($item['children'] as $child)
            @include('merlion.fields.partials.tree-checkbox-item', [
                'item' => $child,
                'name' => $name,
                'selectedValues' => $selectedValues,
                'level' => $level + 1
            ])
        @endforeach
    @endif
</div>
