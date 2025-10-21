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

	table,
	th,
	td {
		border: 1px solid #ddd;
	}

	th,
	td {
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
	</style>
</head>

<body>
	<div class="container">
		<div class="header">
			<h1>Aslan Möbel</h1>
			<p>Weizerplatz 7-9</p>
			<p>47139 Brügggen</p>

			<div class="customer">
				<p>{{ $location_data['first_name'] . ' ' . $location_data['last_name'] }}</p>
				<p>{{ $location_data['country'] }}</p>
				<p>{{ $location_data['street'] }}</p>
				<p>{{ $location_data['house_number'] }}</p>
				<p>{{ $location_data['zipcode'] }}</p>
				<p>{{ $location_data['phone'] }}</p>
			</div>

			{{-- payment id --}}
			<p>Rechnungsnummer: {{ $total_data['payment_id'] }}</p>
			{{-- today date --}}
			<p>Rechnungsdatum: {{ date('d.m.Y') }}</p>
			{{-- payment method --}}
			@if ($total_data['payment_method'] === 'paypal')
			<p>Zahlungsart: Paypal</p>
			@else
			<p>Zahlungsart: Auf Rechnung</p>
			@endif

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
				@foreach ($cartItems as $item)
				<!-- عرض بيانات المنتج الرئيسية -->
				<tr>
					<td>{{ $pos }}</td>
					<td>{{ $item['name'] }}</td>
					<td>{{ $item['quantity'] }}</td>
					<td>{{ number_format($item['price'], 2) }} €</td>
					<td>{{ number_format($item['vatAmount'], 2) }} €</td>
					<td>{{ number_format($item['shipping_price'] ?? 0, 2) }} €</td>
					<td>{{ number_format($item['price'] * $item['quantity'] + $item['shipping_price'] ?? 0, 2) }}
						€
					</td>
				</tr>

				<!-- عرض بيانات partsBreakdown مع المنتج -->
				@if (!empty($item['partsBreakdown']))
				<tr>
					<td></td>
					<td colspan="4">
						<strong>Parts:</strong>
						<ul>
							@foreach ($item['partsBreakdown'] as $part)
							<li>
								<strong>Part Name:</strong>
								{{ $part['name'] }} / <strong>Part
									Price:</strong> €
								{{ number_format($part['price'], 2) }}
							</li>
							@endforeach
						</ul>
					</td>
				</tr>
				@endif

				<!-- عرض بيانات texturesBreakdown مع المنتج -->
				@if (!empty($item['texturesBreakdown']))
				<tr>
					<td></td>
					<td colspan="4">
						<strong>Textures:</strong>
						<ul>
							@foreach ($item['texturesBreakdown'] as $texture)
							<li>
								<strong>Texture Name:</strong>
								{{ $texture['name'] }}
								/
								<strong>Texture Price:</strong> €
								{{ number_format($texture['price'], 2) }}
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

		@if ($total_data['payment_method'] === 'paypal')
		<div class="totals">
			<p>19% USt: {{ number_format($total_data['totalVat'], 2) }} +
				{{ number_format($total_data['totalPriceWithoutVat'], 2) }}
				= {{ number_format($total_data['total'], 2) }} €</p>
			<p><strong>Noch zu zahlender Betrag: 0.00 €</strong></p>
		</div>
		@else
		<div class="totals">
			<p>19% USt: {{ number_format($total_data['totalVat'], 2) }} +
				{{ number_format($total_data['totalPriceWithoutVat'], 2) }} =
				{{ number_format($total_data['total'], 2) }} €</p>
			<p><strong>Noch zu zahlender Betrag: {{ number_format($total_data['total'], 2) }}
					€</strong></p>
		</div>
		@endif


		<p class="important">Bitte Überweisen Sie den Beitrag innerhalb von 14 Tagen an die unten
			dargestellten Bank
			Verbindung</p>

		<p class="important">

			Bitte benutzen der Rechnung nummer als Verwendungszweck


		</p>


		<div class="bank-details">
			{{-- <p>Aslan Möbel</p>
            <p>IBAN: DE2368492641</p>
            <p>Sparkasse Kredit</p>
            <p>BIC: DE2368492641</p>
            <p>Steuernummer: 10252963290</p> --}}
			<p>Sparkasse Krefeld</p>
			<p>Möbel Aslan</p>
			<p>DE82 3205 0000 0000 4873 55</p>
			<p>USt-IdNr: DE366296141</p>
			<p>Steuernummer:10252963290</p>
		</div>
	</div>
</body>

</html>