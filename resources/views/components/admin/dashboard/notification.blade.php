@props(['type' => 'success', 'icon' => 'fa fa-check me-1', 'message' => '', 'from' => 'bottom', 'align' => 'center'])

<div class="acms-notify"
     data-type="{{ $type }}"
     data-icon="{{ $icon }}"
     data-message="{{ $message }}"
     data-from="{{ $from }}"
     data-align="{{ $align }}"
></div>
