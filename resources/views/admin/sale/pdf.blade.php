@php use App\Models\DataSellingUnit; @endphp
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>売上明細書 - {{ $sale->sale_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial Unicode MS', sans-serif;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .header {
            text-align: center;
            /* margin-bottom: 30px; */
        }
        
        .document-title {
            font-size: 24px;
            font-weight: bold;
            margin-top: -40px;
        }
        
        .header-info {
            display: table;
            width: 100%;
            /* margin-bottom: 20px; */
        }
        
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        
        .company-logo {
            background-color: #f0f0f0;
            border: 2px solid #333;
            padding: 8px 15px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .logo {
            /* height: 50px; */
            width: 200px;
            vertical-align: middle;
            margin-left: 10px;
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-left {
            display: table-cell;
            width: 50%;
            padding-right: 20px;
            padding-top: 20px;
            font-size: 14px;
        }
        
        .info-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            font-size: 14px;
        }
        
        
        .field-label {
            font-weight: bold;
            /* margin-bottom: 5px; */
        }
        
        .field-value {
            border-bottom: 1px solid #333;
            padding-bottom: 2px;
            min-height: 20px;
            margin-bottom: 3px;
            text-align: right;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
            border: 2px solid #333;
        }
        
        .items-table th {
            background-color: #666;
            color: white;
            padding: 8px;
            text-align: center;
            border: 1px solid #333;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #333;
            min-height: 25px;
        }
        
        .items-table .item-name {
            text-align: center;
        }
        
        .items-table .amount {
            text-align: center;
        }
        
        .totals-section {
            width: 40%;
            margin-left: auto;
            border: 2px solid #333;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px;
            border: 1px solid #333;
        }
        
        .totals-table .label {
            background-color: #666;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        
        .totals-table .value {
            text-align: center;
        }
        
        .notes-section {
            margin-top: 30px;
            border: 2px solid #333;
        }
        
        .notes-header {
            background-color: #666;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        
        .notes-content {
            min-height: 100px;
            padding: 10px;
        }
        
        .empty-row {
            height: 30px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="document-title">SALES INVOICE</div>
        
        <div class="header-info">
            <div class="header-right">
                <div>Issue Date: {{ date('M d, Y') }}</div>
                <div>Invoice No: {{ $sale->sale_no }}</div>
                <br>          
            </div>
        </div>
    </div>

    <!-- Company and Customer Information -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-left">
                <div class="field-label">Bill To:</div>
                <div class="field-value">{{ $sale->customer->customer_name }}</div>
                
                <div class="field-label">Total Amount:</div>
                <div class="field-value">¥{{ number_format($totalWithTax, 0) }} JPY</div>
                
                <div class="field-label">Payment Terms:</div>
                <div class="field-value">Bank Transfer to Company Account</div>
                
                <div class="field-label">Due Date:</div>
                <div class="field-value">{{ \Carbon\Carbon::parse($sale->sale_date)->addDays(30)->format('M d, Y') }}</div>
            </div>
            <div class="info-right">
            <div id="logo">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('assets/imgs/theme/pdflogo.jpg'))) }}" class="logo" />
                </div>
                <div>Ethnic Corporation</div>
                <div>110-0015</div>
                <div>5-24-9 Higashiueno, Taito-ku, Tokyo</div>
                <div>TEL: 03-5826-7885</div>
                <div>FAX: 03-6806-0979</div>
                <div>mail: sales@ethnicjapan.com</div>
                <div style="text-align: left;">Contact Person:</div>
                <!-- <div class="field-value"></div> -->
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->salesItems as $item)
            <tr>
                <td class="item-name">{{ $item->item->item_name }}</td>
                <td>{{ number_format($item->item_qty, 0) }}</td>
                <td>{{ $item->item_unit ?? 'Package' }}</td>
                <td>¥{{ number_format($item->item_unit_price, 0) }}</td>
                <td class="amount">¥{{ number_format($item->item_line_price, 0) }}</td>
            </tr>
            @endforeach
            
            <!-- Add empty rows to match the original format -->
            @for($i = 0; $i < (2 - count($sale->salesItems)); $i++)
            <tr class="empty-row">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <!-- Totals Section -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">¥{{ number_format($subtotal, 0) }}</td>
            </tr>
            <tr>
                <td class="label">Tax 8%</td>
                <td class="value">¥{{ number_format($tax, 0) }}</td>
            </tr>
            <tr>
                <td class="label">Total</td>
                <td class="value">¥{{ number_format($totalWithTax, 0) }}</td>
            </tr>
        </table>
    </div>

    <!-- Notes Section -->
    <div class="notes-section">
        <div class="notes-header">Terms & Conditions</div>
        <div class="notes-content">
            Sale Date: {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}<br>
            Total Items: {{ $sale->salesItems->count() }} items<br><br>
            
            * This invoice contains the details of the sale transaction.<br>
            * For any inquiries, please contact our sales representative.
        </div>
    </div>
</body>
</html>
