@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2" aria-label="Pagination">
        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 rounded-full text-sm text-slate-300 cursor-not-allowed">&laquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 rounded-full text-sm text-blue-900 bg-blue-50 hover:bg-blue-100 transition">&laquo; Sebelumnya</a>
        @endif

        {{-- Nomor Halaman --}}
        <div class="flex items-center gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-sm text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-full text-sm font-semibold bg-blue-900 text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-full text-sm text-blue-900 hover:bg-blue-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Tombol Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 rounded-full text-sm text-blue-900 bg-blue-50 hover:bg-blue-100 transition">Berikutnya &raquo;</a>
        @else
            <span class="px-4 py-2 rounded-full text-sm text-slate-300 cursor-not-allowed">Berikutnya &raquo;</span>
        @endif
    </nav>
@endif