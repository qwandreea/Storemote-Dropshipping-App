<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            font-size: 14px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            margin-top: 8px;
            float: left;
        }


        #company {
            float: right;
            color: black;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #886f4a;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
            color:black;
        }

        #invoice {
            float: right;
        }

        #invoice h1 {
            color: #886f4a;
            font-size: 2.5em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: black;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: tan;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: tan;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #886f4a;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{(public_path().'/imagini/images_frontend/logo.png')}}" alt="Logo" height="70px">
    </div>
    <div id="company">
        <h2 class="name">STOREMOTE</h2>
        <div>{{ $infoContact->adresa }}</div>
        <div>{{ $infoContact->telefon }}</div>
        <div>{{ $infoContact->email }}</div>
    </div>
</header>
<main>
    <div id="details" class="clearfix">
        <div id="client">
            <div class="to">DESTINATAR</div>
            <h2 class="name">{{ $utilizator->nume }} - {{ $utilizator->prenume }}</h2>
            <div class="address">{{ $adresa->adresa }} , {{ $adresa->oras }} , {{ $adresa->cod_postal }}</div>
            <div class="email">Email: {{ $utilizator->email }}</div>
            <div class="email">Telefon: +4{{ $utilizator->telefon }}</div>
        </div>
        <div id="invoice">
            <h1>COMANDA {{ $comanda->nr_comanda }}</h1>
            <div class="date">Emisa la data: {{ $comanda->created_at }}</div>
        </div>
    </div>
    <table>
        <?php $count = 0; ?>
        <?php $total = 0; ?>
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">Descriere</th>
            <th class="unit">Pret unitar</th>
            <th class="qty">Cantitate</th>
            <th class="total">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @if($detalii)
            @foreach($detalii as $detaliu)
                <tr>
                    <td class="no">{{ $count + 1 }}</td>
                    <td class="desc"><h3> {{ $detaliu->produs->denumire }} </h3></td>
                    <td class="unit">{{ $detaliu->produs->pret_unitar }} RON</td>
                    <td class="qty">{{ $detaliu->cantitate }}</td>
                    <td class="total"><?php $total += $detaliu->produs->pret_unitar * $detaliu->cantitate; echo $total;?>
                        RON
                    </td>
                </tr>
                <?php $count++; ?>
            @endforeach
        @endif
        </tbody>
        @if($inchiriate->isEmpty())
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">SUBTOTAL</td>
                <td>{{ $total }} RON</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">TAX</td>
                <td>{{ $comanda->taxa }} RON</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">TOTAL</td>
                <td> <?php $grandtotal = $total + $comanda->taxa; echo $grandtotal;?> RON</td>
            </tr>
            </tfoot>
        @endif
    </table>


    @if(!$inchiriate->isEmpty())
        <h3>Produse inchiriate</h3>
        <table>
            <thead>
            <tr>
                <th class="no">#</th>
                <th class="desc">Descriere</th>
                <th class="unit">Data de inceput</th>
                <th class="qty">Data de returnare</th>
                <th class="unit">Tip calcul pret</th>
                <th class="qty">Cantitate</th>
                <th class="total">TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inchiriate as $inchiriat)
                <tr>
                    <td class="no">{{ $count }}</td>
                    <td class="desc"><h3> {{ $inchiriat->produs->denumire }} RON</h3></td>
                    <td class="unit">{{ $inchiriat->data_inceput }}</td>
                    <td class="qty">{{ $inchiriat->data_sfarsit }}</td>
                    <td class="unit">{{ $inchiriat->tip  }}</td>
                    <td class="qty">{{ $inchiriat->cantitate }}</td>
                    <td class="total">{{ $inchiriat->subtotal }} RON</td>
                    <?php $total += $inchiriat->subtotal; ?>
                </tr>
                <?php $count++; ?>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">SUBTOTAL</td>
                <td>{{ $total }} RON</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">TAX</td>
                <td>{{ $comanda->taxa }} RON</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">TOTAL</td>
                <td> <?php $grandtotal = $total + $comanda->taxa; echo $grandtotal;?> RON</td>
            </tr>
            </tfoot>
        </table>
    @endif
        <div id="thanks">Va multumim !</div>
        <div id="notices">
            <div>NOTE:</div>
            <div class="notice">Comanda a fost platita {{ $comanda->modalitate_plata }}</div>
            <div class="notice">Comanda contine <?php echo $count;?> produse</div>
        </div>
</main>
</body>
</html>
