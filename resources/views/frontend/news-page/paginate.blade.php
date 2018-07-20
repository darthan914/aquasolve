<?php //dd($elements); ?>
@if ($paginator->hasPages())
    <ul class="pagination-custom">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" style="display: none;">
                <div id="midle">
                    <span>
                        <img src="{{ asset('amadeo/images-base/chevron-left.png') }}">
                    </span>
                </div>
            </li>
        @else
            <li class="pagination-control">
                <div id="midle">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <img src="{{ asset('amadeo/images-base/chevron-left.png') }}">
                    </a>
                </div>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled three-dots">
                    <div id="midle">
                        <span>
                            {{ $element }}
                        </span>
                    </div>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination-paginate active">
                            <div id="midle">
                                <span>
                                    {{ $page }}
                                </span>
                            </div>
                        </li>
                    @else
                        <li class="pagination-paginate">
                            <div id="midle">
                                <a href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pagination-control">
                <div id="midle">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <img src="{{ asset('amadeo/images-base/chevron-right.png') }}">
                    </a>
                </div>
            </li>
        @else
            <li class="disabled" style="display: none;">
                <div id="midle">
                    <span>
                        <img src="{{ asset('amadeo/images-base/chevron-right.png') }}">
                    </span>
                </div>
            </li>
        @endif
    </ul>
@endif