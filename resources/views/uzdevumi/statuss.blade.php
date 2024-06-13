<datalist id="statusi">
    @foreach($statusi as $statuss)
        <option value="{{ $statuss }}">
    @endforeach
</datalist>
<input type="text" list="statusi" name="uzdStat" value="{{ $uzdevums?->uzdStat }}" placeholder="Uzdevuma statuss" required/>
@error('uzdStat')
<p>{{ $message }}</p>
@enderror
