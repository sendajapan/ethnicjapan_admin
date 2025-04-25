<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcodes</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            .barcode-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                page-break-inside: avoid;
            }

            .barcode-item {
                text-align: center;
                page-break-inside: avoid;
                padding: 4px;
            }

            img {
                max-width: 100%;
                height: auto;
            }
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .barcode-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .barcode-item {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

    </style>
</head>
<body>

<div class="barcode-grid">
    @foreach($parts as $part)
        <div class="barcode-item">
            @php
                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG(
                    sprintf('%03d', $part->vehicle->id) .
                    sprintf('%03d', $part->id),
                    'C39', 1, 33, [1, 1, 1], false
                ) . '" alt="barcode" />';
            @endphp
            <div>{{ sprintf('%03d', $part->vehicle->id) . sprintf('%03d', $part->id)}}</div>
        </div>
    @endforeach
</div>

<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>
</html>
