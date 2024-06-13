@if($uzdevumi->isNotEmpty())
    <table>
        <thead>
        <tr>
            @if (!isset($projekts))
                <th>Projekta nosaukums</th>
            @endif
            <th>Uzdevuma nr.</th>
            <th>Uzdevuma tips</th>
            <th>Uzdevuma nosaukums</th>
            <th>Uzdevuma statuss</th>
            <th>Reģistrācijas datums</th>
            <th>Izpildes termiņš</th>
            <th>Uzdevuma īpašnieks</th>
            <th>Uzdevuma izpildītājs</th>
            <th>Reģistrēts laiks</th>
            <th></th>
        </tr>
        </thead>
        @foreach($uzdevumi as $uzdevums)
            <tr>
                @if (!isset($projekts))
                    <td>{{ $uzdevums->projNosaukums->projNos }}</td>
                @endif
                <td>{{ $uzdevums->ID_uzdevums }}</td>
                <td>{{ $uzdevums->uzdTips }}</td>
                <td>{{ $uzdevums->uzdNos }}</td>
                <td>{{ $uzdevums->uzdStat }}</td>
                <td>{{ $uzdevums->veidDat }}</td>
                <td>{{ $uzdevums->termins ?? '-' }}</td>
                <td>{{ $uzdevums->ipasnieks->vardsUzvards }}</td>
                <td>{{ $uzdevums->izpilditajs?->vardsUzvards ?? '-' }}</td>
                <td>{{ $uzdevums->laiks }}</td>
                <td class="actions">
                    <a href="{{ route('laikauzskaite.uzdevums', ['ID_uzdevums' => $uzdevums->ID_uzdevums]) }}" class="button">
                        Laika uzskaites ieraksti
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>
        Nav neviena uzdevuma
    </p>
@endif
