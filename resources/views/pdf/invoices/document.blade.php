@php
    $companyName = config(
        'company.name',
        'PT Satria Cipta Karya'
    );

    $companyAddress = config(
        'company.address',
        'Jakarta, Indonesia'
    );

    $companyPhone = config(
        'company.phone',
        '-'
    );

    $companyEmail = config(
        'company.email',
        '-'
    );

    $companyPersonInCharge = config(
        'company.person_in_charge',
        'Direktur'
    );

    $companyLogo = config('company.logo');

    $logoPath = $companyLogo
        ? public_path($companyLogo)
        : null;

    $logoExists = $logoPath
        && file_exists($logoPath);

    $projectName =
        $invoice->project?->project_name
        ?? $invoice->quotation?->project_name
        ?? '-';

    $projectCode =
        $invoice->project?->project_code
        ?? '-';

    $projectLocation =
        $invoice->project?->location
        ?? $invoice->quotation?->project_location
        ?? '-';

    $mandorName =
        $invoice->project?->mandor?->name
        ?? '-';

    $formatCurrency = static function (
        mixed $amount
    ): string {
        return 'Rp '.number_format(
            (float) $amount,
            0,
            ',',
            '.'
        );
    };

    $formatQuantity = static function (
        mixed $quantity
    ): string {
        $formatted = number_format(
            (float) $quantity,
            2,
            ',',
            '.'
        );

        return rtrim(
            rtrim($formatted, '0'),
            ','
        );
    };

    $grandTotal = (float) $invoice->grand_total;
    $paidAmount = (float) $invoice->paid_amount;

    $remainingAmount = max(
        $grandTotal - $paidAmount,
        0
    );

    $isOverdue =
        $invoice->due_date
        && in_array(
            $invoice->status,
            ['issued', 'sent'],
            true
        )
        && $invoice->payment_status !== 'paid'
        && $invoice->due_date->lt(today());
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Invoice {{ $invoice->invoice_number }}
    </title>

    <style>
        @page {
            margin: 32px 36px 48px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1f2937;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.5;
        }

        table {
            border-collapse: collapse;
        }

        .page-footer {
            position: fixed;
            right: 0;
            bottom: -32px;
            left: 0;
            border-top: 1px solid #d1d5db;
            padding-top: 7px;
            color: #6b7280;
            font-size: 8px;
        }

        .page-footer-table,
        .header-table,
        .heading-table,
        .information-table,
        .detail-table,
        .items-table,
        .summary-wrapper,
        .summary-table,
        .signature-table {
            width: 100%;
        }

        .page-footer-right {
            text-align: right;
        }

        .header-table {
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 14px;
        }

        .header-logo-cell {
            width: 72px;
            vertical-align: middle;
        }

        .company-logo {
            width: 58px;
            max-height: 58px;
        }

        .company-logo-placeholder {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            background: #1d4ed8;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            line-height: 58px;
            text-align: center;
        }

        .company-information {
            vertical-align: middle;
        }

        .company-name {
            color: #111827;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.2;
        }

        .company-detail {
            margin-top: 4px;
            color: #6b7280;
            font-size: 8px;
        }

        .document-heading {
            margin-top: 20px;
        }

        .document-title {
            color: #1d4ed8;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .document-subtitle {
            margin-top: 2px;
            color: #6b7280;
            font-size: 9px;
        }

        .information-section {
            margin-top: 18px;
        }

        .information-column {
            width: 50%;
            vertical-align: top;
        }

        .information-column-left {
            padding-right: 8px;
        }

        .information-column-right {
            padding-left: 8px;
        }

        .information-card {
            min-height: 160px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #f8fafc;
            padding: 12px;
        }

        .section-label {
            margin-bottom: 8px;
            color: #1d4ed8;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 0.7px;
            text-transform: uppercase;
        }

        .detail-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .detail-label {
            width: 105px;
            color: #6b7280;
        }

        .detail-separator {
            width: 10px;
            color: #9ca3af;
        }

        .detail-value {
            color: #111827;
            font-weight: bold;
        }

        .items-section {
            margin-top: 20px;
        }

        .section-heading-table {
            width: 100%;
            margin-bottom: 8px;
        }

        .section-heading-title {
            color: #111827;
            font-size: 12px;
            font-weight: bold;
        }

        .section-heading-count {
            color: #6b7280;
            font-size: 8px;
            text-align: right;
        }

        .items-table thead {
            display: table-header-group;
        }

        .items-table tr {
            page-break-inside: avoid;
        }

        .items-table th {
            border: 1px solid #bfdbfe;
            background: #1d4ed8;
            padding: 8px 6px;
            color: #ffffff;
            font-size: 8px;
            text-align: left;
        }

        .items-table td {
            border: 1px solid #dbe3ef;
            padding: 8px 6px;
            vertical-align: top;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .column-number {
            width: 28px;
            text-align: center !important;
        }

        .column-quantity {
            width: 48px;
            text-align: center !important;
        }

        .column-unit {
            width: 54px;
            text-align: center !important;
        }

        .column-price {
            width: 91px;
            text-align: right !important;
        }

        .column-total {
            width: 96px;
            text-align: right !important;
        }

        .item-name {
            color: #111827;
            font-weight: bold;
        }

        .item-description {
            margin-top: 3px;
            color: #6b7280;
            font-size: 8px;
        }

        .summary-wrapper {
            margin-top: 12px;
        }

        .summary-spacer {
            width: 52%;
        }

        .summary-cell {
            width: 48%;
        }

        .summary-table td {
            padding: 5px 8px;
        }

        .summary-label {
            color: #6b7280;
        }

        .summary-value {
            color: #111827;
            font-weight: bold;
            text-align: right;
        }

        .grand-total-row td {
            border-top: 2px solid #1d4ed8;
            background: #eff6ff;
            padding-top: 9px;
            padding-bottom: 9px;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: bold;
        }

        .remaining-row td {
            color: #b91c1c;
            font-weight: bold;
        }

        .overdue-note {
            margin-top: 10px;
            border-left: 4px solid #dc2626;
            background: #fef2f2;
            padding: 8px 10px;
            color: #991b1b;
            font-weight: bold;
        }

        .notes-section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .notes-box {
            border-left: 4px solid #1d4ed8;
            background: #eff6ff;
            padding: 10px 12px;
        }

        .notes-title {
            margin-bottom: 4px;
            color: #1e40af;
            font-size: 9px;
            font-weight: bold;
        }

        .notes-content {
            color: #374151;
            white-space: pre-line;
        }

        .payment-information {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .payment-box {
            border: 1px solid #dbe3ef;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .payment-box-title {
            color: #111827;
            font-size: 10px;
            font-weight: bold;
        }

        .payment-box-text {
            margin-top: 5px;
            color: #4b5563;
            font-size: 8px;
        }

        .signature-section {
            margin-top: 26px;
            page-break-inside: avoid;
        }

        .signature-cell {
            width: 42%;
            vertical-align: top;
            text-align: center;
        }

        .signature-spacer {
            width: 16%;
        }

        .signature-role {
            color: #4b5563;
            font-size: 9px;
        }

        .signature-space {
            height: 58px;
        }

        .signature-name {
            display: inline-block;
            min-width: 150px;
            border-bottom: 1px solid #374151;
            padding-bottom: 3px;
            color: #111827;
            font-weight: bold;
        }

        .signature-description {
            margin-top: 4px;
            color: #6b7280;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <div class="page-footer">
        <table class="page-footer-table">
            <tr>
                <td>
                    {{ $companyName }}
                    •
                    {{ $invoice->invoice_number }}
                </td>

                <td class="page-footer-right">
                    Dicetak pada
                    {{ now()->translatedFormat(
                        'd F Y, H:i'
                    ) }}
                </td>
            </tr>
        </table>
    </div>

    <table class="header-table">
        <tr>
            <td class="header-logo-cell">
                @if ($logoExists)
                    <img
                        src="{{ $logoPath }}"
                        alt="Logo {{ $companyName }}"
                        class="company-logo"
                    >
                @else
                    <div class="company-logo-placeholder">
                        MP
                    </div>
                @endif
            </td>

            <td class="company-information">
                <div class="company-name">
                    {{ $companyName }}
                </div>

                <div class="company-detail">
                    {{ $companyAddress }}

                    <br>

                    Telepon: {{ $companyPhone }}
                    &nbsp; | &nbsp;
                    Email: {{ $companyEmail }}
                </div>
            </td>
        </tr>
    </table>

    <div class="document-heading">
        <table class="heading-table">
            <tr>
                <td>
                    <div class="document-title">
                        INVOICE
                    </div>

                    <div class="document-subtitle">
                        {{ $invoice->invoice_number }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="information-section">
        <table class="information-table">
            <tr>
                <td class="information-column information-column-left">
                    <div class="information-card">
                        <div class="section-label">
                            Ditagihkan Kepada
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">Klien</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->client_name }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Contact Person</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->client_contact_person ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Telepon</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->client_phone ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Email</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->client_email ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Alamat</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->client_address ?: '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="information-column information-column-right">
                    <div class="information-card">
                        <div class="section-label">
                            Informasi Invoice
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">Tanggal</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->invoice_date
                                        ?->translatedFormat('d F Y') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Jatuh Tempo</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->due_date
                                        ?->translatedFormat('d F Y') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Quotation</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $invoice->quotation
                                        ?->quotation_number ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Project</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $projectName }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Kode Project</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $projectCode }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Lokasi</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $projectLocation }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">Mandor</td>
                                <td class="detail-separator">:</td>
                                <td class="detail-value">
                                    {{ $mandorName }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="items-section">
        <table class="section-heading-table">
            <tr>
                <td class="section-heading-title">
                    Detail Tagihan
                </td>

                <td class="section-heading-count">
                    {{ $invoice->items->count() }} Item
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="column-number">No.</th>
                    <th>Deskripsi</th>
                    <th class="column-quantity">Qty</th>
                    <th class="column-unit">Satuan</th>
                    <th class="column-price">Harga</th>
                    <th class="column-total">Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td class="column-number">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            <div class="item-name">
                                {{ $item->item_name }}
                            </div>

                            @if (filled($item->description))
                                <div class="item-description">
                                    {{ $item->description }}
                                </div>
                            @endif
                        </td>

                        <td class="column-quantity">
                            {{ $formatQuantity($item->qty) }}
                        </td>

                        <td class="column-unit">
                            {{ $item->unit }}
                        </td>

                        <td class="column-price">
                            {{ $formatCurrency($item->price) }}
                        </td>

                        <td class="column-total">
                            {{ $formatCurrency($item->total) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-wrapper">
            <tr>
                <td class="summary-spacer"></td>

                <td class="summary-cell">
                    <table class="summary-table">
                        <tr>
                            <td class="summary-label">
                                Subtotal
                            </td>

                            <td class="summary-value">
                                {{ $formatCurrency(
                                    $invoice->subtotal
                                ) }}
                            </td>
                        </tr>

                        <tr class="grand-total-row">
                            <td>Grand Total</td>

                            <td class="summary-value">
                                {{ $formatCurrency(
                                    $invoice->grand_total
                                ) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="summary-label">
                                Sudah Dibayar
                            </td>

                            <td class="summary-value">
                                {{ $formatCurrency(
                                    $invoice->paid_amount
                                ) }}
                            </td>
                        </tr>

                        <tr class="remaining-row">
                            <td>Sisa Tagihan</td>

                            <td class="summary-value">
                                {{ $formatCurrency(
                                    $remainingAmount
                                ) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        @if ($isOverdue)
            <div class="overdue-note">
                Invoice telah melewati tanggal jatuh tempo
                dan masih memiliki sisa tagihan.
            </div>
        @endif
    </div>

    @if (filled($invoice->notes))
        <div class="notes-section">
            <div class="notes-box">
                <div class="notes-title">
                    Catatan
                </div>

                <div class="notes-content">
                    {{ $invoice->notes }}
                </div>
            </div>
        </div>
    @endif

    <div class="payment-information">
        <div class="payment-box">
            <div class="payment-box-title">
                Informasi Pembayaran
            </div>

            <div class="payment-box-text">
                Gunakan nomor invoice
                {{ $invoice->invoice_number }}
                sebagai referensi pembayaran.

                @if ($invoice->due_date)
                    Pembayaran dilakukan paling lambat
                    {{ $invoice->due_date
                        ->translatedFormat('d F Y') }}.
                @endif
            </div>
        </div>
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div class="signature-role">
                        Penerima
                    </div>

                    <div class="signature-space"></div>

                    <div class="signature-name">
                        {{ $invoice->client_contact_person
                            ?: $invoice->client_name }}
                    </div>

                    <div class="signature-description">
                        {{ $invoice->client_name }}
                    </div>
                </td>

                <td class="signature-spacer"></td>

                <td class="signature-cell">
                    <div class="signature-role">
                        Hormat Kami
                    </div>

                    <div class="signature-space"></div>

                    <div class="signature-name">
                        {{ $companyPersonInCharge }}
                    </div>

                    <div class="signature-description">
                        {{ $companyName }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>