@php
    $alertLevelColor = $alertLevel === 'danger' ? '#dc2626' : '#facc15';
    $alertHeading = $alertLevel === 'danger' ? 'Danger Alert' : 'Warning Alert';
@endphp

<div style="
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100vw;
    min-height: 100%;
    max-width: 100%;
    box-sizing: border-box;
">
    <div style="
        width: 40rem;
        max-width: 40rem;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    ">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h2 style="color: {{ $alertLevelColor }}">
                {{ $alertHeading }}
            </h2>
            <div
                {{-- style="display: inline-grid; place-items: center;" --}}
                style="display: none; place-items: center;"
            >
                <form action="http://localhost:8000/alerts/{{ $alertId }}">
                    @csrf
                    @method('put')
                    <button
                        style="
                            background-color: #28a745;
                            color: #ffffff;
                            padding: 0.5rem 1.25rem;
                            text-decoration: none;
                            font-weight: bold;
                            border-radius: 0.25rem;
                        "
                    >
                        Resolve
                    </button>
                </form>
            </div>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Level:</td>
                <td style="color: {{ $alertLevelColor }};">
                    {{ Str::ucfirst($alertLevel) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Status:</td>
                <td>
                    {{ Str::ucfirst($alertStatus) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Description:</td>
                <td>
                    {{ Str::ucfirst($description) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Action Required:</td>
                <td>
                    <strong style="color: {{ $alertLevelColor }};">
                        {{ Str::ucfirst($actionRequired) }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    Tank Identifier:
                </td>
                <td>
                    {{$tankIdentifier}}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    BMP180 Value:
                </td>
                <td>
                    {{$bmp180Reading}} Pa
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    MQ2 Value:
                </td>
                <td>
                    {{$mq2Reading}} ppm
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    Location:
                </td>
                <td>
                    {{ Str::ucfirst($location) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    Fuel Type:
                </td>
                <td>
                    {{ Str::ucfirst($fuelType) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    Triggered At:
                </td>
                <td>
                    {{$triggeredAt}}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    MQ2 Range:
                </td>
                <td>
                    {{$mq2Min . ' - ' .$mq2Max. ' ppm'}}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">
                    BMP180 Range:
                </td>
                <td>
                    {{$bmp180Min . ' - ' .$bmp180Max. ' PA'}}
                </td>
            </tr>
        </table>
    </div>
</div>
