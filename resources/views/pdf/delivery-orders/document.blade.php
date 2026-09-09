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

    $project = $deliveryOrder->project;
    $client = $project?->client;
    $mandor = $project?->mandor;

    $unitLabels = [
        'unit' => 'Unit',
        'pcs' => 'Pcs',
        'set' => 'Set',
        'buah' => 'Buah',
        'batang' => 'Batang',
        'lembar' => 'Lembar',
        'sak' => 'Sak',
        'dus' => 'Dus',
        'box' => 'Box',
        'roll' => 'Roll',
        'titik' => 'Titik',
        'meter' => 'Meter',
        'm²' => 'm²',
        'm³' => 'm³',
        'kg' => 'Kg',
        'ton' => 'Ton',
        'liter' => 'Liter',
        'paket' => 'Paket',
        'ls' => 'Lumpsum',
    ];

    $conditionLabels = [
        'good' => 'Baik',
        'damaged' => 'Rusak',
    ];

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

    $totalQuantity = $deliveryOrder
        ->items
        ->sum(
            fn ($item) => (float) $item->qty
        );
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Surat Jalan {{ $deliveryOrder->delivery_number }}
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
            line-height: 1.5;
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
            min-height: 175px;
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
            width: 100px;
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
            font-weight: bold;
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
            width: 32px;
            text-align: center !important;
        }

        .column-quantity {
            width: 62px;
            text-align: right !important;
        }

        .column-unit {
            width: 75px;
            text-align: center !important;
        }

        .column-condition {
            width: 72px;
            text-align: center !important;
        }

        .item-name {
            color: #111827;
            font-weight: bold;
        }

        .item-description {
            margin-top: 3px;
            color: #6b7280;
            font-size: 8px;
            line-height: 1.4;
        }

        .condition-good {
            color: #166534;
            font-weight: bold;
        }

        .condition-damaged {
            color: #b91c1c;
            font-weight: bold;
        }

        .empty-item {
            padding: 18px !important;
            color: #6b7280;
            text-align: center;
        }

        .summary-section {
            margin-top: 12px;
            page-break-inside: avoid;
        }

        .summary-spacer {
            width: 58%;
        }

        .summary-content {
            width: 42%;
        }

        .summary-box {
            border: 1px solid #dbe3ef;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .summary-row {
            width: 100%;
        }

        .summary-row td {
            padding: 3px 0;
        }

        .summary-label {
            color: #6b7280;
        }

        .summary-value {
            color: #111827;
            font-weight: bold;
            text-align: right;
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

        .confirmation-section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .confirmation-box {
            border: 1px solid #dbe3ef;
            background: #f8fafc;
            padding: 10px 12px;
        }

        .confirmation-title {
            color: #111827;
            font-size: 10px;
            font-weight: bold;
        }

        .confirmation-text {
            margin-top: 5px;
            color: #4b5563;
            font-size: 8px;
            line-height: 1.5;
        }

        .signature-section {
            margin-top: 28px;
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
    {{-- Footer setiap halaman --}}
    <div class="page-footer">
        <table class="page-footer-table">
            <tr>
                <td>
                    {{ $companyName }}
                    •
                    {{ $deliveryOrder->delivery_number }}
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

    {{-- Kop perusahaan --}}
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

    {{-- Judul dokumen --}}
    <div class="document-heading">
        <table class="heading-table">
            <tr>
                <td>
                    <div class="document-title">
                        SURAT JALAN
                    </div>

                    <div class="document-subtitle">
                        {{ $deliveryOrder->delivery_number }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Informasi pengiriman dan Project --}}
    <div class="information-section">
        <table class="information-table">
            <tr>
                <td class="information-column information-column-left">
                    <div class="information-card">
                        <div class="section-label">
                            Informasi Pengiriman
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">
                                    Tanggal
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $deliveryOrder->delivery_date
                                        ?->translatedFormat('d F Y') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Tujuan
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $deliveryOrder->destination ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Penerima
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $deliveryOrder->receiver_name ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Telepon
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $deliveryOrder->receiver_phone ?: '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Dibuat Oleh
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $deliveryOrder->creator?->name ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="information-column information-column-right">
                    <div class="information-card">
                        <div class="section-label">
                            Informasi Project
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">
                                    Kode Project
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $project?->project_code ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Project
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $project?->project_name ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Lokasi
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $project?->location ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Nomor Kontrak
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $project?->contract_number ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Client
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $client?->company_name ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    PIC Client
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $client?->contact_person ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Mandor
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $mandor?->name ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Item pengiriman --}}
    <div class="items-section">
        <table class="section-heading-table">
            <tr>
                <td class="section-heading-title">
                    Detail Barang atau Material
                </td>

                <td class="section-heading-count">
                    {{ $deliveryOrder->items->count() }} Item
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="column-number">
                        No.
                    </th>

                    <th>
                        Nama Item dan Deskripsi
                    </th>

                    <th class="column-quantity">
                        Jumlah
                    </th>

                    <th class="column-unit">
                        Satuan
                    </th>

                    <th class="column-condition">
                        Kondisi
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($deliveryOrder->items as $index => $item)
                    @php
                        $conditionLabel =
                            $conditionLabels[
                                $item->condition
                            ]
                            ?? 'Tidak Diketahui';

                        $conditionClass =
                            $item->condition === 'good'
                                ? 'condition-good'
                                : (
                                    $item->condition === 'damaged'
                                        ? 'condition-damaged'
                                        : ''
                                );
                    @endphp

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
                            {{ $unitLabels[$item->unit]
                                ?? $item->unit
                                ?? '-' }}
                        </td>

                        <td class="column-condition">
                            <span class="{{ $conditionClass }}">
                                {{ $conditionLabel }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="5"
                            class="empty-item"
                        >
                            Surat Jalan tidak mempunyai item pengiriman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($deliveryOrder->items->isNotEmpty())
            <div class="summary-section">
                <table class="summary-table">
                    <tr>
                        <td class="summary-spacer"></td>

                        <td class="summary-content">
                            <div class="summary-box">
                                <table class="summary-row">
                                    <tr>
                                        <td class="summary-label">
                                            Total Jenis Item
                                        </td>

                                        <td class="summary-value">
                                            {{ $deliveryOrder
                                                ->items
                                                ->count() }}
                                            Item
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="summary-label">
                                            Total Quantity
                                        </td>

                                        <td class="summary-value">
                                            {{ $formatQuantity(
                                                $totalQuantity
                                            ) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

    {{-- Catatan --}}
    @if (filled($deliveryOrder->notes))
        <div class="notes-section">
            <div class="notes-box">
                <div class="notes-title">
                    Catatan
                </div>

                <div class="notes-content">
                    {{ $deliveryOrder->notes }}
                </div>
            </div>
        </div>
    @endif

    {{-- Konfirmasi penerimaan --}}
    <div class="confirmation-section">
        <div class="confirmation-box">
            <div class="confirmation-title">
                Konfirmasi Penerimaan
            </div>

            <div class="confirmation-text">
                Dengan menandatangani dokumen ini, penerima menyatakan bahwa barang atau material telah diterima sesuai dengan daftar yang tercantum pada Surat Jalan.
            </div>
        </div>
    </div>

    {{-- Tanda tangan --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div class="signature-role">
                        Penerima
                    </div>

                    <div class="signature-space"></div>

                    <div class="signature-name">
                        {{ $deliveryOrder->receiver_name ?: '-' }}
                    </div>

                    <div class="signature-description">
                        {{ $client?->company_name
                            ?? $project?->project_name
                            ?? '-' }}
                    </div>
                </td>

                <td class="signature-spacer"></td>

                <td class="signature-cell">
                    <div class="signature-role">
                        Pengirim
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