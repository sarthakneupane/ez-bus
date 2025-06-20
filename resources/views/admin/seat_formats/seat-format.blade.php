<div class="d-flex flex-column align-items-center">
    @foreach($seats as $row)
        <div class="d-flex mb-2">
            @foreach($row as $seat)
                @if (is_null($seat))
                    <div style="width: 40px;"></div>
                @else
                    <div class="p-2 text-center border me-1 {{ $seat['booked'] ? 'bg-secondary text-white' : 'bg-success text-white' }}"
                         style="width: 40px; border-radius: 5px;">
                        {{ $seat['number'] }}
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
</div>
