<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Skin911 — Executive Sales Report</title>
<style>
    @page { size: A4; margin: 12mm 10mm; }

    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 11px;
        color: #444;
    }

    /* Header */
    .header {
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 3px solid #F56289; padding-bottom: 15px; margin-bottom: 25px;
    }
    .header-left { display: flex; align-items: center; gap: 12px; }
    .logo { width: 110px; }

    .company-info h1 {
        font-size: 26px; font-weight: 700; color: #F56289; margin: 0;
    }

    .header-right { text-align: right; }
    .report-title { font-size: 18px; font-weight: 700; }
    .report-period {
        font-size: 11px; background: #f8f9fb; padding: 4px 8px;
        border-radius: 4px; border: 1px solid #ececec;
    }

    /* CEO Section */
    .ceo-overview {
        background: #FDECEF; padding: 14px; border-radius: 8px;
        border-left: 5px solid #F56289; margin-bottom: 25px;
    }
    .ceo-title { font-size: 16px; font-weight: 700; margin-bottom: 10px; }

    /* KPI Tiles */
    .kpi-section { display: flex; gap: 12px; margin-bottom: 20px; }
    .kpi-card {
        flex: 1; padding: 14px; border-radius: 8px; color: white;
        text-align: center; font-weight: 600;
    }
    .kpi-primary { background: #F56289; }
    .kpi-green { background: #48C774; }
    .kpi-blue { background: #3E8AFF; }

    .kpi-label { font-size: 10px; opacity: .9; text-transform: uppercase; }
    .kpi-value { font-size: 22px; font-weight: 700; }

    /* Branch Performance */
    .section-title { font-size: 14px; font-weight: 700; margin-bottom: 8px; }
    .matrix { display: flex; gap: 15px; }
    .matrix-box {
        flex: 1; background: white; border: 1px solid #eaeaea;
        border-radius: 6px; padding: 10px;
    }
    .matrix-box h4 { font-size: 12px; margin-bottom: 6px; }

    table {
        width: 100%; border-collapse: collapse; font-size: 10px;
        margin-top: 8px; background: white;
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    thead { background: #F56289; color: white; }
    th, td { padding: 8px; border-bottom: 1px solid #f1f1f1; }
    td.amount { text-align: right; font-weight: 600;}

    footer {
        position: fixed; bottom: 10mm; left: 12mm; right: 12mm;
        font-size: 9px; color: #888; border-top: 1px solid #eee; padding-top: 6px;
    }
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="header-left">
        <div class="logo" aria-hidden="true">
            <!-- Inline SVG logo so PDF renders without PHP GD -->
            <svg width="110" height="56" viewBox="0 0 220 112" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Skin911 logo">
                <rect width="100%" height="100%" fill="none" />

            </svg>
        </div>
        <div class="company-info">
            <h1>Skin911</h1>
            <div class="tagline">Facial & Slimming Centre</div>
        </div>
    </div>
    <div class="header-right">
        <div class="report-title">Executive Sales Report</div>

    </div>
</div>

<!-- CEO OVERVIEW -->
<div class="ceo-overview">
    <div class="ceo-title">📌 Summary Insights</div>
    <p>Overall sales performance has been analyzed across all operating branches. The strongest branch and most purchased services are identified below. This report highlights profit opportunities on top services and promo impact.</p>
</div>

<!-- KPI CARDS -->
<div class="kpi-section">
    <div class="kpi-card kpi-primary">
        <div class="kpi-label">Total Revenue</div>
        <div class="kpi-value">{{ number_format($report['total'],2) }}</div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-label">Total Transactions</div>
        <div class="kpi-value">{{ $report['count'] }}</div>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-label">Average Sale</div>
        <div class="kpi-value">{{ number_format($report['total'] / max(1,$report['count']),2) }}</div>
    </div>
</div>

<!-- PERFORMANCE MATRIX -->
@if(isset($metrics))
<div class="section-title">📊 Branch Performance Matrix</div>
<div class="matrix">
    <div class="matrix-box">
        <h4>🏢 Revenue Per Branch</h4>
        <table>
            @foreach($metrics['branch_revenues'] as $br)
            <tr>
                <td>{{ $br->branch_name }}</td>
                <td class="amount">{{ number_format($br->total, 2) }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="matrix-box">
        <h4>⭐ Top Services</h4>
        <table>
            @foreach($metrics['top_services'] as $ts)
            <tr>
                <td>{{ $ts->service_name }}</td>
                <td class="amount">{{ number_format($ts->revenue,2) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endif

<br><br>

<!-- TRANSACTION DETAILS TABLE -->
<div class="section-title">🧾 Transaction Records</div>
<table>
    <thead>
        <tr>
            <th>#</th><th>Branch</th><th>Service</th><th>Date</th><th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report['rows'] as $i => $r)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $r->branch_name ?? ($r->branch->name ?? 'N/A') }}</td>
            <td>{{ $r->service_name ?? ($r->service->name ?? 'N/A') }}</td>
            <td>{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y') }}</td>
            <td class="amount">{{ number_format($r->price ?? $r->amount, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<footer>

    <span><strong>Skin911 Confidential</strong></span>
<footer>
    <span><strong>Skin911 Confidential</strong></span>
</footer>
