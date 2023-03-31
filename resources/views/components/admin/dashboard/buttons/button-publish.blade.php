@props(['id', 'href'])

<button type="button"
        class="btn btn-sm btn-alt-secondary js-tooltip-enabled acms-toggle-publish"
        data-toggle="tooltip"
        data-animation="true"
        data-placement="top"
        title="Publish"
        data-id="{{ $id }}"
        data-url="{{ $href }}">
    <em class="fa fa-fw fa-eye"></em>
</button>
