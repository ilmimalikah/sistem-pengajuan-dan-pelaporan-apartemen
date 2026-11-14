<ol>
    @foreach ($riwayat as $item)
        <li class="relative pb-7 pl-7 @if (!$loop->last) before:absolute before:bottom-0 before:left-[5px] before:top-4 before:w-px before:bg-line @endif">
            <span class="absolute left-0 top-1 h-[11px] w-[11px] rounded-full border-2 {{ $loop->first ? 'border-brand bg-brand' : 'border-line bg-white' }}"></span>
            <p class="text-sm font-medium">{{ $item['status'] }}</p>
            <p class="mt-0.5 text-xs text-ink-soft">{{ $item['waktu'] }}@if (!empty($item['nama'])) &middot; {{ $item['nama'] }} @endif</p>
            @if (!empty($item['catatan']))
                <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $item['catatan'] }}</p>
            @endif
        </li>
    @endforeach
</ol>
