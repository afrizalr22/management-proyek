<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Quotation</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#222;
            line-height:1.6;
        }

        .container{
            padding:40px;
        }

        .text-center{
            text-align:center;
        }

        .text-right{
            text-align:right;
        }

        .mb-1{
            margin-bottom:8px;
        }

        .mb-2{
            margin-bottom:16px;
        }

        .mb-3{
            margin-bottom:24px;
        }

        .mb-4{
            margin-bottom:40px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#f3f4f6;
            border:1px solid #ddd;
            padding:8px;
            text-align:left;
        }

        table td{
            border:1px solid #ddd;
            padding:8px;
        }

        .border{
            border:1px solid #ddd;
        }

        .p-2{
            padding:12px;
        }

    </style>

</head>

<body>

<div class="container">

    {{-- Company Header --}}
    <table class="mb-4">

        <tr>

            <td style="width:90px; vertical-align:top;">

                <div
                    style="
                        width:70px;
                        height:70px;
                        border:1px solid #ccc;
                        text-align:center;
                        line-height:70px;
                        font-size:11px;
                    "
                >
                    LOGO
                </div>

            </td>

            <td>

                <h2
                    style="
                        font-size:22px;
                        margin-bottom:8px;
                    "
                >
                    PT SATRIA CIPTA KARYA
                </h2>

                <p>
                    Jl. Contoh Alamat No. 123
                </p>

                <p>
                    Jakarta, Indonesia
                </p>

                <p>
                    Telp : (021) 12345678
                </p>

                <p>
                    Email : info@satriaciptakarya.com
                </p>

            </td>

        </tr>

    </table>

    <hr class="mb-3">

    {{-- Document Title --}}
    <div class="text-center mb-4">

        <h1
            style="
                font-size:24px;
                letter-spacing:2px;
            "
        >
            QUOTATION
        </h1>

    </div>

    {{-- Document Information --}}
    <table class="mb-4">

        <tr>

            <td style="width:180px;">

                <strong>Quotation Number</strong>

            </td>

            <td>

                : QTN-2026-0001

            </td>

        </tr>

        <tr>

            <td>

                <strong>Quotation Date</strong>

            </td>

            <td>

                : 15 July 2026

            </td>

        </tr>

        <tr>

            <td>

                <strong>Project</strong>

            </td>

            <td>

                : Renovasi Gedung Kantor

            </td>

        </tr>

    </table>

    {{-- Client Information --}}
<table class="mb-4">

    <tr>

        {{-- Bill To --}}
        <td
            style="
                width:50%;
                vertical-align:top;
                padding-right:20px;
            "
        >

            <h3
                style="
                    font-size:14px;
                    margin-bottom:10px;
                "
            >
                Bill To
            </h3>

            <p>

                <strong>PT Maju Bersama</strong>

            </p>

            <p>

                Attn : Budi Santoso

            </p>

            <p>

                Jl. Sudirman No. 88

            </p>

            <p>

                Jakarta

            </p>

            <p>

                Phone : 0812-3456-7890

            </p>

            <p>

                Email : purchasing@majubersama.com

            </p>

        </td>

        {{-- Project Information --}}
        <td
            style="
                width:50%;
                vertical-align:top;
            "
        >

            <h3
                style="
                    font-size:14px;
                    margin-bottom:10px;
                "
            >
                Project Information
            </h3>

            <table>

                <tr>

                    <td style="width:120px;">

                        Project

                    </td>

                    <td>

                        : Renovasi Gedung Kantor

                    </td>

                </tr>

                <tr>

                    <td>

                        Location

                    </td>

                    <td>

                        : Jakarta Selatan

                    </td>

                </tr>

                <tr>

                    <td>

                        PIC

                    </td>

                    <td>

                        : Ahmad Afrizal

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>
{{-- Quotation Items --}}
<h3
    style="
        font-size:14px;
        margin-bottom:10px;
    "
>
    Quotation Items
</h3>

<table class="mb-4">

    <thead>

        <tr>

            <th style="width:50px; text-align:center;">
                No
            </th>

            <th>
                Description
            </th>

            <th style="width:70px; text-align:center;">
                Qty
            </th>

            <th style="width:70px; text-align:center;">
                Unit
            </th>

            <th style="width:120px; text-align:right;">
                Unit Price
            </th>

            <th style="width:140px; text-align:right;">
                Total
            </th>

        </tr>

    </thead>

    <tbody>

        <tr>

            <td style="text-align:center;">
                1
            </td>

            <td>
                Pekerjaan Pondasi
            </td>

            <td style="text-align:center;">
                1
            </td>

            <td style="text-align:center;">
                Lot
            </td>

            <td style="text-align:right;">
                Rp 50.000.000
            </td>

            <td style="text-align:right;">
                Rp 50.000.000
            </td>

        </tr>

        <tr>

            <td style="text-align:center;">
                2
            </td>

            <td>
                Pekerjaan Struktur Beton
            </td>

            <td style="text-align:center;">
                1
            </td>

            <td style="text-align:center;">
                Lot
            </td>

            <td style="text-align:right;">
                Rp 70.000.000
            </td>

            <td style="text-align:right;">
                Rp 70.000.000
            </td>

        </tr>

        <tr>

            <td style="text-align:center;">
                3
            </td>

            <td>
                Finishing
            </td>

            <td style="text-align:center;">
                1
            </td>

            <td style="text-align:center;">
                Lot
            </td>

            <td style="text-align:right;">
                Rp 30.000.000
            </td>

            <td style="text-align:right;">
                Rp 30.000.000
            </td>

        </tr>

    </tbody>

</table>

{{-- Summary --}}
<table style="width:100%; margin-top:20px; margin-bottom:40px;">

    <tr>

        <td style="width:60%; border:none;"></td>

        <td style="width:20%; border:1px solid #ddd; padding:10px;">

            <strong>Subtotal</strong>

        </td>

        <td
            style="
                width:20%;
                border:1px solid #ddd;
                padding:10px;
                text-align:right;
            "
        >

            Rp 150.000.000

        </td>

    </tr>

    <tr
        style="
            background:#f3f4f6;
            font-weight:bold;
        "
    >

        <td style="border:none;"></td>

        <td
            style="
                border:1px solid #ddd;
                padding:12px;
            "
        >

            Grand Total

        </td>

        <td
            style="
                border:1px solid #ddd;
                padding:12px;
                text-align:right;
            "
        >

            Rp 150.000.000

        </td>

    </tr>

</table>

{{-- Notes --}}
<div style="margin-top:30px;">

    <h3
        style="
            font-size:14px;
            margin-bottom:10px;
        "
    >
        Notes
    </h3>

    <div
        style="
            border:1px solid #ddd;
            padding:12px;
            min-height:70px;
        "
    >

        Harga di atas berlaku selama 30 hari sejak tanggal quotation.

        <br><br>

        Pekerjaan akan dimulai setelah quotation disetujui oleh pihak client.

    </div>

</div>

{{-- Signature --}}
<table
    style="
        width:100%;
        margin-top:60px;
    "
>

    <tr>

        <td
            style="
                width:50%;
                text-align:center;
                border:none;
            "
        >

            <strong>

                Prepared By

            </strong>

            <br><br><br><br><br>

            ______________________

            <br>

            PT SATRIA CIPTA KARYA

        </td>

        <td
            style="
                width:50%;
                text-align:center;
                border:none;
            "
        >

            <strong>

                Accepted By

            </strong>

            <br><br><br><br><br>

            ______________________

            <br>

            Client

        </td>

    </tr>

</table>

</div>

</body>

</html>