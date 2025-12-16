@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination-custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item-custom disabled">
                    <span class="page-link-custom">‹ Prev</span>
                </li>
            @else
                <li class="page-item-custom">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link-custom" rel="prev">‹ Prev</a>
                </li>
            @endif

            {{-- Pagination Numbers --}}
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($start + 4, $paginator->lastPage());
                $start = max($end - 4, 1);
            @endphp

            {{-- First Page --}}
            @if ($start > 1)
                <li class="page-item-custom">
                    <a href="{{ $paginator->url(1) }}" class="page-link-custom">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item-custom disabled">
                        <span class="page-link-custom">...</span>
                    </li>
                @endif
            @endif

            {{-- Page Numbers --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <li class="page-item-custom active">
                        <span class="page-link-custom">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item-custom">
                        <a href="{{ $paginator->url($i) }}" class="page-link-custom">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($end < $paginator->lastPage())
                @if ($end < $paginator->lastPage() - 1)
                    <li class="page-item-custom disabled">
                        <span class="page-link-custom">...</span>
                    </li>
                @endif
                <li class="page-item-custom">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link-custom">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item-custom">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link-custom" rel="next">Next ›</a>
                </li>
            @else
                <li class="page-item-custom disabled">
                    <span class="page-link-custom">Next ›</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-custom {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-item-custom {
            display: inline-block;
        }

        .page-link-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 38px;
            padding: 8px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: white;
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .page-link-custom:hover {
            background: #fff5f5;
            border-color: #E31E24;
            color: #E31E24;
            transform: translateY(-1px);
        }

        .page-item-custom.active .page-link-custom {
            background: #E31E24;
            border-color: #E31E24;
            color: white;
            cursor: default;
        }

        .page-item-custom.active .page-link-custom:hover {
            transform: none;
        }

        .page-item-custom.disabled .page-link-custom {
            background: #f8f9fa;
            border-color: #e5e7eb;
            color: #d1d5db;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .page-item-custom.disabled .page-link-custom:hover {
            background: #f8f9fa;
            border-color: #e5e7eb;
            color: #d1d5db;
            transform: none;
        }

        /* Dark Mode */
        body.dark-mode .page-link-custom {
            background: #353535;
            border-color: #404040;
            color: #d1d5db;
        }

        body.dark-mode .page-link-custom:hover {
            background: #4a1a1c;
            border-color: #E31E24;
            color: #ff6b6f;
        }

        body.dark-mode .page-item-custom.active .page-link-custom {
            background: #E31E24;
            border-color: #E31E24;
            color: white;
        }

        body.dark-mode .page-item-custom.disabled .page-link-custom {
            background: #2d2d2d;
            border-color: #404040;
            color: #6c757d;
        }
    </style>
@endif