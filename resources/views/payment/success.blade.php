<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aslan Möbel Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container-btn{
            max-width: 800px;
            margin: 20px auto 10px;
            padding: 20px 20px 10px ;
        }

        .header,
        .footer {
            text-align: left;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .totals {
            text-align: right;
        }

        .totals p {
            margin: 4px 0;
        }

        .bank-details {
            margin-top: 20px;
        }

        .bank-details p {
            margin: 4px 0;
        }

        .important {
            font-weight: bold;
            margin-top: 20px;
        }

        .customer {
            margin: 20px 0;
        }
        
/* تحسين عرض الحاوية على الشاشات الصغيرة */
@media screen and (max-width: 600px) {
    .container {
        width: 95%;
        padding: 15px;
                /* overflow: x  */
                overflow-x: auto;
    }

    .container-btn {
        width: 95%;
        padding: 10px;
    }

     h1 {
        font-size: 16px;
    }

     p {
        font-size: 14px;
    }

    .print-button, .container-btn a {
        font-size: 14px;
        padding: 8px;
    }

    table {
        font-size: 14px;

    }
}
        /* إخفاء زر الطباعة عند الطباعة */
        @media print {
            .print-button ,.container-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-btn">
        <!-- زر الطباعة -->
        <button class="print-button" onclick="window.print()" style="margin-bottom: 20px; padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px;">
            Print Invoice
        </button>
    
        {{-- button go home --}}
        <a href="{{ route('home') }}" style="margin-bottom: 20px; padding: 10px 15px; background: #d9b382; color: white; border: none; cursor: pointer; border-radius: 5px; text-decoration: none;">
            Go Home 
        </a>
    </div>
    <div class="container">

        <div class="header">
            <h1>Aslan Möbel</h1>
            <p>Weizerplatz 7-9</p>
            <p>47139 Brügggen</p>

            <div class="customer">
                <p>{{ $payments[0]->payer_name }}</p>
                <p>{{ $payments[0]->country }}</p>
                <p>{{ $payments[0]->street }}</p>
                <p>{{ $payments[0]->address }}</p>
                <p>{{ $payments[0]->zipcode }}</p>
                <p>{{ $payments[0]->location }}</p>
                <p>{{ $payments[0]->phone }}</p>
            </div>

            {{-- payment id --}}
            <p>Rechnungsnummer: {{ $payments[0]->payment_id }}</p>
            {{-- today date --}}
            <p>Rechnungsdatum: {{ date('d.m.Y') }}</p>
            {{-- payment method --}}
            @if ($payments[0]->payment_method === 'paypal')
                <p>Zahlungsart: Paypal</p>
                
            @else   
                <p>Zahlungsart: Auf Rechnung</p>
            @endif
            {{-- <p>Zahlungsart: {{ $payments[0]->payment_method === 'paypal' ? 'Paypal' : 'Auf Rechnung' }}</p> --}}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Pos.</th>
                    <th>Bezeichnung | name</th>
                    <th>Menge | quantity</th>
                    <th>Stückpreis | prod </th>
                    <th>Inkl. Mwst | Inkl. Vat </th>
                    <th>Versandpreis | shipping price</th>
                    <th>Gesamtpreis | total price</th>
                </tr>
            </thead>
            <tbody>
                @php $pos = 1; @endphp
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $pos }}</td>
                        <td>{{ $payment->product_name }}</td>
                        <td>{{ $payment->quantity }}</td>
                        <td>{{ number_format($payment->amount, 2) }} €</td>
                        <td>{{ number_format($payment->vat, 2) }} €</td>
                        <td>{{ number_format($payment->shipping_price ?? 0, 2) }} €</td>
                        <td>{{ number_format($payment->total , 2) }} €</td>
                    </tr>

                    @if ($payment->parts->isNotEmpty())
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <strong>Parts:</strong>
                            <ul>
                                @foreach ($payment->parts as $part)
                                    <li>
                                        <strong>Part Name:</strong> {{ $part->name }} / 
                                        <strong>Part Price:</strong> € {{ number_format($part->price, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                
                    @if ($payment->textures->isNotEmpty())
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <strong>Textures:</strong>
                            <ul>
                                @foreach ($payment->textures as $texture)
                                    <li>
                                        <strong>Texture Name:</strong> {{ $texture->name }} / 
                                        <strong>Texture Price:</strong> € {{ number_format($texture->price, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endif
                    @php $pos++; @endphp
                @endforeach
            </tbody>
        </table>
        @if ($payments[0]->payment_method === 'paypal')
        <div class="totals">
            <p>19% USt: {{ $total_vat }} + {{ $total_amount }} ={{ $total_total }} € </p>
            <p><strong>Noch zu zahlender Betrag: $0.0</strong></p>
        </div>
        @else   
        <div class="totals">
            <p>19% USt: {{ $total_vat }} + {{ $total_amount }} = {{ $total_total }} € </p>
            <p><strong>Noch zu zahlender Betrag: {{ $total_total }} € </strong></p>
        </div>
        @endif
        {{-- <div class="totals">
            <p>19% USt: ${{ $total_vat }} + ${{ $total_amount }}= ${{ $total_total }}</p>
            <p><strong>Noch zu zahlender Betrag: {{ $payments[0]->payment_method === 'paypal' ? '$0.00' : '$' . $total_total }}</strong></p>
        </div> --}}

        <p class="important">Bitte Überweisen Sie den Beitrag innerhalb von 14 Tagen an die unten dargestellten Bank Verbindung</p>
        <p class="important">
                
                Bitte benutzen der Rechnung nummer als Verwendungszweck
    
            
            </p>
        <div class="bank-details">
            <p>Sparkasse Krefeld</p>
            <p>Möbel Aslan</p>
            <p>DE82 3205 0000 0000 4873 55</p>
            <p>USt-IdNr: DE366296141</p>
            <p>Steuernummer: 10252963290</p>
        </div>
    </div>
</body>

</html>
