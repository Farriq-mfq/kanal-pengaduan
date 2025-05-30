<div>
    @if ($aduan->masyarakat_id != null)
        {{ $aduan->masyarakat->nama }}
    @else
        Anonymous
    @endif
</div>
