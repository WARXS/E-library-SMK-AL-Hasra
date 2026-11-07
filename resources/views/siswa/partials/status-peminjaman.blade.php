@php
    $statusStyle = match ($status) {
        'pending' => ['label' => 'Menunggu', 'class' => 'bg-[color:var(--color-warning-surface)] text-[color:var(--color-warning)]'],
        'dipinjam' => ['label' => 'Dipinjam', 'class' => 'bg-[color:var(--color-info-surface)] text-[color:var(--color-info)]'],
        'dikembalikan' => ['label' => 'Dikembalikan', 'class' => 'bg-[color:var(--color-success-surface)] text-[color:var(--color-success)]'],
        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-[color:var(--color-danger-surface)] text-[color:var(--color-danger)]'],
        default => ['label' => ucfirst($status ?? 'Tidak diketahui'), 'class' => 'bg-[color:var(--color-surface-muted)] text-[color:var(--color-text-muted)]'],
    };
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyle['class'] }}">{{ $statusStyle['label'] }}</span>
