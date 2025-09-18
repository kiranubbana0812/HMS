<div class="text-sm text-gray-600 mb-2">
    Showing 
    <strong>{{ $paginator->firstItem() }}</strong> 
    to 
    <strong>{{ $paginator->lastItem() }}</strong> 
    of 
    <strong>{{ $paginator->total() }}</strong> 
    records 
    (Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }})
</div>
