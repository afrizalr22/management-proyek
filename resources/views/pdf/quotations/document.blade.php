@php
    $companyName = config(
        'company.name',
        'Management Proyek'
    );

    $companyAddress = config(
        'company.address',
        '-'
    );

    $companyPhone = config(
        'company.phone',
        '-'
    );

    $companyEmail = config(
        'company.email',
        '-'
    );

    $personInCharge = config(
        'company.person_in_charge',
        'Owner'
    );

    $companyLogo = config('company.logo');

    $logoPath = $companyLogo
        ? public_path($companyLogo)
        : null;

    $logoExists = $logoPath
        && file_exists($logoPath);

    $clientName =
        $quotation->client_name
        ?? $quotation->client?->company_name
        ?? '-';

    $clientContactPerson =
        $quotation->client_contact_person
        ?? $quotation->client?->contact_person
        ?? '-';

    $clientPhone =
        $quotation->client_phone
        ?? $quotation->client?->phone
        ?? '-';

    $clientEmail =
        $quotation->client_email
        ?? $quotation->client?->email
        ?? '-';

    $clientAddress =
        $quotation->client_address
        ?? $quotation->client?->address
        ?? '-';

    $projectName =
        $quotation->project_name
        ?? $quotation->project?->project_name
        ?? '-';

    $projectLocation =
        $quotation->project_location
        ?? $quotation->project?->location
        ?? '-';

    $statusText = match ($quotation->status) {
        'draft' => 'DRAFT',
        'sent' => 'DIKIRIM',
        'approved' => 'DISETUJUI',
        'rejected' => 'DITOLAK',
        'expired' => 'KEDALUWARSA',
        default => strtoupper(
            (string) $quotation->status
        ),
    };

    $statusClass = match ($quotation->status) {
        'draft' => 'status-draft',
        'sent' => 'status-sent',
        'approved' => 'status-approved',
        'rejected' => 'status-rejected',
        'expired' => 'status-expired',
        default => 'status-default',
    };

    $formatCurrency = static function (
        mixed $amount
    ): string {
        return 'Rp'.number_format(
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
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Quotation {{ $quotation->quotation_number }}
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

        .page-footer-table {
            width: 100%;
        }

        .page-footer-right {
            text-align: right;
        }

        .header-table {
            width: 100%;
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
            margin: 0;
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

        .document-heading-table {
            width: 100%;
        }

        .document-title-cell {
            vertical-align: top;
        }

        .document-title {
            margin: 0;
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

        .status-cell {
            width: 130px;
            text-align: right;
            vertical-align: top;
        }

        .status {
            display: inline-block;
            border-radius: 12px;
            padding: 5px 10px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .status-sent {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-expired,
        .status-default {
            background: #f3f4f6;
            color: #4b5563;
        }

        .information-section {
            margin-top: 18px;
        }

        .information-table {
            width: 100%;
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
            min-height: 138px;
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

        .detail-table {
            width: 100%;
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

        .items-table {
            width: 100%;
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
            line-height: 1.4;
        }

        .empty-item {
            padding: 18px !important;
            color: #6b7280;
            text-align: center;
        }

        .summary-wrapper {
            width: 100%;
            margin-top: 12px;
        }

        .summary-spacer {
            width: 56%;
        }

        .summary-cell {
            width: 44%;
        }

        .summary-table {
            width: 100%;
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

        .terms-section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .terms-title {
            margin-bottom: 6px;
            color: #111827;
            font-size: 10px;
            font-weight: bold;
        }

        .terms-list {
            margin: 0;
            padding-left: 16px;
            color: #4b5563;
        }

        .terms-list li {
            margin-bottom: 3px;
        }

        .signature-section {
            margin-top: 26px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
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
                    {{ $quotation->quotation_number }}
                </td>

                <td class="page-footer-right">
                    Dokumen dibuat pada
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

                    Telepon:
                    {{ $companyPhone }}
                    &nbsp; | &nbsp;
                    Email:
                    {{ $companyEmail }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Judul dokumen --}}
    <div class="document-heading">
        <table class="document-heading-table">
            <tr>
                <td class="document-title-cell">
                    <h1 class="document-title">
                        QUOTATION
                    </h1>

                    <div class="document-subtitle">
                        Dokumen penawaran pekerjaan dan estimasi biaya
                    </div>
                </td>

                <td class="status-cell">
                    <span class="status {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Informasi quotation dan client --}}
    <div class="information-section">
        <table class="information-table">
            <tr>
                <td class="information-column information-column-left">
                    <div class="information-card">
                        <div class="section-label">
                            Informasi Quotation
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">
                                    Nomor
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $quotation->quotation_number }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Tanggal
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $quotation->quotation_date
                                        ? $quotation->quotation_date
                                            ->translatedFormat('d F Y')
                                        : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Berlaku Sampai
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $quotation->valid_until
                                        ? $quotation->valid_until
                                            ->translatedFormat('d F Y')
                                        : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Nama Project
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $projectName }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Lokasi Project
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $projectLocation }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="information-column information-column-right">
                    <div class="information-card">
                        <div class="section-label">
                            Ditujukan Kepada
                        </div>

                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">
                                    Client
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $clientName }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Kontak
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $clientContactPerson }}
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
                                    {{ $clientPhone }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Email
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $clientEmail }}
                                </td>
                            </tr>

                            <tr>
                                <td class="detail-label">
                                    Alamat
                                </td>

                                <td class="detail-separator">
                                    :
                                </td>

                                <td class="detail-value">
                                    {{ $clientAddress }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Rincian pekerjaan --}}
    <div class="items-section">
        <table class="section-heading-table">
            <tr>
                <td class="section-heading-title">
                    Rincian Penawaran
                </td>

                <td class="section-heading-count">
                    {{ $quotation->items->count() }}
                    item pekerjaan
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
                        Uraian Pekerjaan
                    </th>

                    <th class="column-quantity">
                        Qty
                    </th>

                    <th class="column-unit">
                        Satuan
                    </th>

                    <th class="column-price">
                        Harga
                    </th>

                    <th class="column-total">
                        Total
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($quotation->items as $item)
                    <tr>
                        <td class="column-number">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <div class="item-name">
                                {{ $item->item_name }}
                            </div>

                            @if ($item->description)
                                <div class="item-description">
                                    {{ $item->description }}
                                </div>
                            @endif
                        </td>

                        <td class="column-quantity">
                            {{ $formatQuantity(
                                $item->qty
                            ) }}
                        </td>

                        <td class="column-unit">
                            {{ $item->unit }}
                        </td>

                        <td class="column-price">
                            {{ $formatCurrency(
                                $item->price
                            ) }}
                        </td>

                        <td class="column-total">
                            {{ $formatCurrency(
                                $item->total
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="6"
                            class="empty-item"
                        >
                            Tidak ada rincian pekerjaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Ringkasan biaya --}}
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
                                    $quotation->subtotal
                                ) }}
                            </td>
                        </tr>

                        <tr class="grand-total-row">
                            <td>
                                Grand Total
                            </td>

                            <td class="summary-value">
                                {{ $formatCurrency(
                                    $quotation->grand_total
                                ) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- Catatan --}}
    @if ($quotation->notes)
        <div class="notes-section">
            <div class="notes-box">
                <div class="notes-title">
                    Catatan
                </div>

                <div class="notes-content">
                    {{ $quotation->notes }}
                </div>
            </div>
        </div>
    @endif

    {{-- Ketentuan --}}
    <div class="terms-section">
        <div class="terms-title">
            Ketentuan Penawaran
        </div>

        <ol class="terms-list">
            <li>
                Penawaran berlaku sampai tanggal
                {{ $quotation->valid_until
                    ? $quotation->valid_until
                        ->translatedFormat('d F Y')
                    : 'yang tercantum pada dokumen' }}.
            </li>

            <li>
                Perubahan ruang lingkup pekerjaan dapat memengaruhi nilai dan jadwal pelaksanaan.
            </li>

            <li>
                Pekerjaan dapat diproses setelah quotation memperoleh persetujuan dari Client.
            </li>

            <li>
                Dokumen ini dibuat berdasarkan rincian pekerjaan yang telah disepakati.
            </li>
        </ol>
    </div>

    {{-- Tanda tangan --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div class="signature-role">
                        Pihak Client
                    </div>

                    <div class="signature-space"></div>

                    <div class="signature-name">
                        {{ $clientContactPerson !== '-'
                            ? $clientContactPerson
                            : $clientName }}
                    </div>

                    <div class="signature-description">
                        Client
                    </div>
                </td>

                <td class="signature-spacer"></td>

                <td class="signature-cell">
                    <div class="signature-role">
                        Hormat kami,
                    </div>

                    <div class="signature-space"></div>

                    <div class="signature-name">
                        {{ $personInCharge }}
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