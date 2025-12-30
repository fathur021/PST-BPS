<div style="padding: 1rem; text-align: center;">
    <div style="display: inline-block; text-align: center;">
      @if ($getState())
        <p style="margin: 0; font-size: 1rem; color: #000000; padding-bottom: 1rem; font-weight: bold;">Tanda Tangan</p>
        <img src="{{ $getState() }}" alt="Tanda Tangan" style="max-width: 100%; height: auto; border: 2px solid #000000;" />
      @else
        <p style="margin: 0; font-size: 1rem; color: #ffffff;">Tanda tangan belum tersedia</p>
      @endif
    </div>
</div>
