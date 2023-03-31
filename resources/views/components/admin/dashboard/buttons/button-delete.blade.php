@props(['href'])

<button type="button"
        class="btn btn-sm btn-alt-secondary acms-delete-item"
        data-url="{{ $href }}"
        data-toggle="tooltip"
        data-animation="true"
        data-placement="top"
        title="Remove">
    <em class="fa fa-fw fa-times"></em>
</button>
