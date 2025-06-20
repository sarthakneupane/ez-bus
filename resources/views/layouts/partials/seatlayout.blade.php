{{-- seatlayout.blade.php --}}

<style>
    td.seat {
        padding: 10px;
        margin: 2px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        width: 50px;
        height: 50px;
        transition: background-color 0.3s ease;
        font-weight: bold;
        color: white;
    }

    td.available {
        background-color: #28a745;
    }

    td.available:hover {
        background-color: #ffc107;
    }

    /* td.available.clicked{
        background-color: #ffc107 !important;
    } */

    td.booked {
        background-color: #dc3545;
        cursor: not-allowed;
    }

    td.selected {
        background-color: #ffc107 !important;
    }

    .seat-div {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .legend-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        vertical-align: middle;
        border: 1px solid #ccc;
    }
</style>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-auto">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <tbody>
                        @foreach($seats as $row)
                            <tr>
                                @foreach($row as $seat)
                                    @if(is_array($seat))
                                        <td class="seat {{ $seat['booked'] ? 'booked' : 'available' }}" data-seat="{{ $seat['number'] }}">
                                            <div class="seat-div">{{ $seat['number'] }}</div>
                                        </td>
                                    @else
                                        <td class="bg-white border-0" style="width: 30px;"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-3">
            <ul class="list-unstyled">
                <li><span class="legend-box" style="background-color:#28a745;"></span> Available</li>
                <li><span class="legend-box" style="background-color:#ffc107;"></span> Selected</li>
                <li><span class="legend-box" style="background-color:#dc3545;"></span> Booked</li>
            </ul>
        
            <hr>
            <h6>Selected Seats: <span id="selectedSeatsList">None</span></h6>
            <h6>Total Fare: Rs <span id="totalFare">0</span></h6>
            <hr>
            <div class="text-end mt-4">
                <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="seats" id="bookingSeats">
                    <input type="hidden" name="schedule_id" id="bookingScheduleId">
                    <input type="hidden" name="price" id="bookingFare">
                    <input type="hidden" name="total" id="bookingTotal">
                    <input type="hidden" name="passenger_id" id="bookingPassengerId" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="no_of_seats" id="bookingNoOfSeats">
                    <input type="hidden" name="status" value="1">
                
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success w-100">Proceed Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






