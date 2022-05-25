@if ($paginator->hasPages())
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex flex-wrap py-2 mr-3">
        @if (!($paginator->onFirstPage()))
        <a href="{{$paginator->url(1)}}" class="btn btn-icon btn-sm btn-light mr-2 my-1">
            <i class="ki ki-bold-double-arrow-back icon-xs"></i>
        </a>
        <a href="{{$paginator->previousPageUrl()}}" class="btn btn-icon btn-sm btn-light mr-2 my-1">
            <i class="ki ki-bold-arrow-back icon-xs"></i>
        </a>
        <a href="{{$paginator->previousPageUrl()}}" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">
            {{($paginator->currentPage())-1}}
        </a>
        @endif
        <button type="button" class="btn btn-icon btn-sm border-0 btn-light btn-hover-primary active mr-2 my-1">
            {{$paginator->currentPage()}}
        </button>
        @if ($paginator->hasMorePages())
        <a href="{{$paginator->nextPageUrl()}}" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">
            {{($paginator->currentPage())+1}}
        </a>
        <a href="{{$paginator->nextPageUrl()}}" class="btn btn-icon btn-sm btn-light mr-2 my-1">
            <i class="ki ki-bold-arrow-next icon-xs"></i>
        </a>
        <a href="{{$paginator->url($paginator->lastPage())}}" class="btn btn-icon btn-sm btn-light mr-2 my-1">
            <i class="ki ki-bold-double-arrow-next icon-xs"></i>
        </a>
        @endif
    </div>
    <div class="d-flex align-items-center py-3">
        <span class="text-muted">
            {!! __('Mostrando') !!}
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('a') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            {!! __('de') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('resultados') !!}
        </span>
    </div>
</div>
@endif