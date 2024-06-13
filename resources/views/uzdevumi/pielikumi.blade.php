<label>Pielikumi</label>
@foreach($uzdevums?->uzdPielikumi ?? [] as $pielikums)
    @if ($pielikums->pielDzesDat)
        @continue
    @endif
    <div class="pielikumi">
        <div>{{ $pielikums->pielPievDat }}: {{ $pielikums->pielNos }}</div>
        <div class="actions">
            <a href="{{ route('uzdevumi.download', ['ID_pielikums' => $pielikums->ID_pielikums]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            @if($uzdevums->uzdReg == request()->user()->ID_aut || $pielikums->ID_aut == request()->user()->ID_aut)
                <a href="{{ route('uzdevumi.deleteAttachment', ['ID_pielikums' => $pielikums->ID_pielikums]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
@endforeach

<input type="file" name="pielikumi[]" multiple/>
<label for="file">Pievienot failus</label>
@error('pielikumi')
<p>{{ $message }}</p>
@enderror

<br><br>
