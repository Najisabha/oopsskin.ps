<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة #INV-{{ str_pad($invoiceId ?? 1, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #d63384;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #d63384;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-section {
            width: 48%;
        }
        .info-section h3 {
            color: #d63384;
            margin-bottom: 10px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #d63384;
            color: white;
            padding: 10px;
            text-align: right;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .total-section {
            margin-top: 20px;
            text-align: left;
        }
        .total-section table {
            width: 300px;
            margin-right: auto;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>متجر المكياج</h1>
        <p>شارع الملك فهد، حي النخيل، الرياض، المملكة العربية السعودية</p>
    </div>
    
    <div class="invoice-info">
        <div class="info-section">
            <h3>معلومات الفاتورة</h3>
            <p><strong>رقم الفاتورة:</strong> #INV-{{ str_pad($invoiceId ?? 1, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }}</p>
            <p><strong>الحالة:</strong> مكتمل</p>
        </div>
        <div class="info-section">
            <h3>معلومات العميل</h3>
            <p><strong>الاسم:</strong> اسم المستخدم</p>
            <p><strong>البريد:</strong> user@example.com</p>
            <p><strong>الهاتف:</strong> 0501234567</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 3; $i++)
                <tr>
                    <td>منتج المكياج {{ $i }}</td>
                    <td>{{ $i }}</td>
                    <td>{{ number_format(rand(100, 300)) }} ₪</td>
                    <td>{{ number_format(rand(100, 300)) }} ₪</td>
                </tr>
            @endfor
        </tbody>
    </table>
    
    <div class="total-section">
        <table>
            <tr>
                <td>المجموع الفرعي:</td>
                <td>450.00 ₪</td>
            </tr>
            <tr>
                <td>الضريبة (15%):</td>
                <td>67.50 ₪</td>
            </tr>
            <tr>
                <td>الشحن:</td>
                <td>مجاني</td>
            </tr>
            <tr class="total-row">
                <td>الإجمالي:</td>
                <td>517.50 ₪</td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <p>شكرًا لك على تسوقك معنا!</p>
        <p>للاستفسارات: info@makeupstore.com | +966 50 123 4567</p>
    </div>
</body>
</html>

