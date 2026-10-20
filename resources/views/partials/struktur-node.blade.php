{{-- resources/views/partials/struktur-node.blade.php --}}
@php
    $anak = ($adaAtasan || $tingkat === 0) ? $anakDari($node) : collect();
@endphp
<li>
    <div class="org-card {{ $tingkat === 0 ? 'org-card-root' : '' }}">
        <div class="font-semibold text-sm leading-snug">{{ $node->jabatan }}</div>
        @if($node->nama_pejabat)
            <div class="text-xs mt-1 {{ $tingkat === 0 ? 'text-brand-200' : 'text-slate-500' }}">{{ $node->nama_pejabat }}</div>
        @endif
    </div>
    @if($anak->count())
        <ul>
            @foreach($anak as $a)
                @include('partials.struktur-node', ['node' => $a, 'tingkat' => $tingkat + 1, 'anakDari' => $anakDari, 'adaAtasan' => $adaAtasan])
            @endforeach
        </ul>
    @endif
</li>