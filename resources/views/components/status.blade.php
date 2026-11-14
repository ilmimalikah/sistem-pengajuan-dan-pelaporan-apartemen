@php
    $warna = [
        'Menunggu' => 'border-amber-200 bg-amber-50 text-amber-800',
        'Diproses' => 'border-blue-200 bg-blue-50 text-blue-800',
        'Selesai' => 'border-green-200 bg-green-50 text-green-800',
        'Ditolak' => 'border-red-200 bg-red-50 text-red-800',
    ];
@endphp

<span class="inline-block whitespace-nowrap rounded-xs border px-2.5 py-0.5 text-xs font-medium {{ $warna[$status] ?? 'border-line text-ink-soft' }}">
    {{ $status }}
</span>
