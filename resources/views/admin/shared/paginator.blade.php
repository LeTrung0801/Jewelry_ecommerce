<?php
    $total = $paginator->total();
    $last = $paginator->lastPage();
    $current = $paginator->currentPage();
    $isFirst = '';
    $isLast = '';

    if($current == 1) {
        $isFirst = 'disabled';
    }

    if($current == $last) {
        $isLast = 'disabled';
    }

    $eachSide = 1;
    $leftCurrent = $current - $eachSide;
    if($leftCurrent < 1) {
        $leftCurrent = 1;
    }
    $rightCurrent = $current + $eachSide;
    if($rightCurrent > $last) {
        $rightCurrent = $last;
    }
?>
<div class="card-tools">
    <ul class="pagination pagination-sm float-right m-0" role="navigation">
        <!-- First Page -->
        <li class="page-item {{$isFirst}}" aria-label="« First">
            <a class="page-link" href="{{$paginator->url(1)}}" aria-hidden="true">«</a>
        </li>
        <!-- Prev Page -->
        <li class="page-item {{$isFirst}}" aria-label="‹ Previous">
            <a class="page-link" href="{{$paginator->previousPageUrl()}}" aria-hidden="true">‹</a>
        </li>
        <!-- Prev Page -->
        @if($leftCurrent > 1)
            <li class="page-item" aria-label="Previous">
                <a class="page-link" href="{{$paginator->previousPageUrl()}}" aria-hidden="true">...</a>
            </li>
        @endif
        <!-- Number Pages -->
        @for($i=$leftCurrent;$i<=$rightCurrent;$i++)
            <li class="page-item {{$i==$current?'active':''}}" aria-label="{{'Page '.$i}}">
                <a class="page-link" href="{{$paginator->url($i)}}" aria-hidden="true">{{$i}}</a>
            </li>
        @endfor
        <!-- Next Page -->
        @if($rightCurrent < $last)
            <li class="page-item" aria-label="Next">
                <a class="page-link" href="{{$paginator->nextPageUrl()}}" aria-hidden="true">...</a>
            </li>
        @endif
        <!-- Next Page -->
        <li class="page-item {{$isLast}}">
            <a class="page-link" href="{{$paginator->nextPageUrl()}}" rel="next" aria-label="Next ›">›</a>
        </li>
        <!-- Last Page -->
        <li class="page-item {{$isLast}}">
            <a class="page-link" href="{{$paginator->url($last)}}" rel="next" aria-label="Last »">»</a>
        </li>
    </ul>
</div>
