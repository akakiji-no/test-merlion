@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $treeData = $self->getTreeData();
    $selectedValues = $self->getValue() ?? [];
    
    if(isset($errors) && $errors->has($name)) {
       $attributes = $attributes->merge(['class' => 'is-invalid']);
    }
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position :attributes="$self->getAttributes('wrapper')">
    <div class="tree-checkbox-container border rounded p-3" id="tree_{{$id}}" style="max-height: 300px; overflow-y: auto;">
        @foreach($treeData as $item)
            @include('merlion.fields.partials.tree-checkbox-item', [
                'item' => $item,
                'name' => $name,
                'selectedValues' => $selectedValues,
                'level' => 0
            ])
        @endforeach
    </div>
</x-merlion::form.field>

@pushonce('scripts')
<script nonce="{{csp_nonce()}}">
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tree-checkbox-container').forEach(function(container) {
        container.addEventListener('change', function(e) {
            if (e.target.type !== 'checkbox') return;
            
            const checkbox = e.target;
            const item = checkbox.closest('.tree-checkbox-item');
            
            // 选中/取消子级
            const childCheckboxes = item.querySelectorAll(':scope > .tree-checkbox-item .form-check-input');
            childCheckboxes.forEach(function(child) {
                child.checked = checkbox.checked;
                child.indeterminate = false;
            });
            
            // 更新父级状态
            updateParentState(item.parentElement);
        });
    });
    
    function updateParentState(parent) {
        if (!parent || !parent.classList.contains('tree-checkbox-item')) {
            parent = parent?.closest('.tree-checkbox-item');
        }
        if (!parent) return;
        
        const parentCheckbox = parent.querySelector(':scope > .form-check > .form-check-input');
        if (!parentCheckbox) return;
        
        const childItems = parent.querySelectorAll(':scope > .tree-checkbox-item');
        if (childItems.length === 0) return;
        
        const childCheckboxes = Array.from(childItems).map(item => 
            item.querySelector(':scope > .form-check > .form-check-input')
        ).filter(Boolean);
        
        const checkedCount = childCheckboxes.filter(cb => cb.checked).length;
        const indeterminateCount = childCheckboxes.filter(cb => cb.indeterminate).length;
        
        if (checkedCount === 0 && indeterminateCount === 0) {
            parentCheckbox.checked = false;
            parentCheckbox.indeterminate = false;
        } else if (checkedCount === childCheckboxes.length) {
            parentCheckbox.checked = true;
            parentCheckbox.indeterminate = false;
        } else {
            parentCheckbox.checked = false;
            parentCheckbox.indeterminate = true;
        }
        
        // 递归更新上级
        updateParentState(parent.parentElement);
    }
    
    // 初始化父级状态
    document.querySelectorAll('.tree-checkbox-container').forEach(function(container) {
        const topItems = container.querySelectorAll(':scope > .tree-checkbox-item');
        topItems.forEach(function(item) {
            initParentState(item);
        });
    });
    
    function initParentState(item) {
        const childItems = item.querySelectorAll(':scope > .tree-checkbox-item');
        childItems.forEach(child => initParentState(child));
        
        if (childItems.length === 0) return;
        
        const parentCheckbox = item.querySelector(':scope > .form-check > .form-check-input');
        const childCheckboxes = Array.from(childItems).map(i => 
            i.querySelector(':scope > .form-check > .form-check-input')
        ).filter(Boolean);
        
        const checkedCount = childCheckboxes.filter(cb => cb.checked).length;
        
        if (checkedCount > 0 && checkedCount < childCheckboxes.length) {
            parentCheckbox.indeterminate = true;
        }
    }
});
</script>
@endpushonce
