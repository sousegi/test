@props(['collection'])

@if($collection->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $collection->links() }}
    </div>
@endif
