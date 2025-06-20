{{-- ticket_pdf.blade --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $booking->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            padding: 20px;
            margin: 0 auto;
            width: 100%;
            max-width: 800px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2e3a59;
        }
        .ticket-header h1 {
            font-size: 28px;
            color: #2e3a59;
            margin: 0;
        }
        .ticket-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .ticket-body {
            font-size: 16px;
            margin-bottom: 30px;
        }
        .ticket-body table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .ticket-body th, .ticket-body td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .ticket-body th {
            width: 30%;
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 5px;
        }
        .terms {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .note {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-style: italic;
            border-left: 4px solid #2e3a59;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="ticket-header">
            <h1>EZ-Bus Ticket</h1>
            <div class="status-badge {{ $booking->status ? 'status-cancelled' : 'status-active' }}">
                {{ $booking->status ? 'CANCELLED' : 'CONFIRMED' }}
            </div>
        </div>

        <!-- Important Note -->
        <div class="note">
            <p>Please present this ticket (digital or printed) and valid ID at boarding. Boarding begins 30 minutes before departure.</p>
        </div>

        <!-- Ticket Meta -->
        <div class="ticket-meta">
            <div>
                <strong>Ticket #:</strong> {{ $booking->id }}<br>
                <strong>Issued:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, h:i A') }}
            </div>
            <div>
                <strong>Issued to:</strong> {{ $passenger->name }} ({{$passenger->phone}}) <br>
                <strong>Departure:</strong> {{ \Carbon\Carbon::parse($booking->schedule->departure_date_time)->format('d M Y, h:i A') }}<br>
            </div>
        </div>

        <!-- Ticket Details -->
        <div class="ticket-body">
            <table>
                <tr>
                    <th>Passenger Name</th>
                    <td>
                        @foreach($bookedSeats as $seat)
                            {{ $seat->passenger_name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>
                        @foreach($bookedSeats as $seat)
                            {{ $seat->passenger_phone }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Route</th>
                    <td>
                        {{ $booking->schedule->vehicleHasRoute->route->fromLocation->name }} 
                        to 
                        {{ $booking->schedule->vehicleHasRoute->route->toLocation->name }}
                    </td>
                </tr>
                <tr>
                    <th>Bus Details</th>
                    <td>
                        {{ optional($booking->schedule->vehicleHasRoute->vehicle->busCompany)->bc_name ?? 'N/A' }}
                        ({{ optional($booking->schedule->vehicleHasRoute->vehicle)->vehicle_no ?? 'N/A' }})<br>
                    </td>

                </tr>
                <tr>
                    <th>Seat Numbers</th>
                    <td>
                        @foreach($bookedSeats as $seat)
                            {{ $seat->seat_number }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Boarding Points</th>
                    <td>
                        @foreach($bookedSeats as $seat)
                            {{ $seat->boarding_point ?: 'Main Terminal' }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Fare Details</th>
                    <td>
                        {{ $booking->seats }} seat(s) × Rs. {{ number_format($booking->price, 2) }}<br>
                        <strong>Total: Rs. {{ number_format($booking->price * $booking->seats, 2) }}</strong>
                    </td>
                </tr>
            </table>
        </div>

<!-- QR Code Section -->
{{-- <div class="qr-section">
    <h3>Ticket Verification QR Code</h3>
    <div class="qr-code">
        <img src="{{ $qrCodeImage }}" alt="Ticket QR Code" style="width:100%; height:100%;">
    </div>
    <p>Scan this code to verify ticket authenticity</p>
</div> --}}
        

        <!-- Terms and Conditions -->
        <div class="terms">
            <h4>Terms & Conditions:</h4>
            <ul style="padding-left: 20px; margin-top: 5px;">
                <li>Tickets can be cancelled up to 24 hours before departure with 80% refund</li>
                <li>No refunds for no-shows or cancellations within 24 hours of departure</li>
                <li>Valid photo ID required for boarding</li>
                <li>Arrive at boarding point at least 30 minutes before departure</li>
                <li>Company not liable for delays due to weather, traffic, or unforeseen circumstances</li>
                <li>Seat allocation subject to change due to operational requirements</li>
            </ul>
            <p style="text-align: center; margin-top: 15px;">
                <strong>Thank you for traveling with EZ-Bus!</strong><br>
                For assistance, contact: support@ez-bus.com | +977-1-1234567
            </p>
        </div>
    </div>
</body>
</html>