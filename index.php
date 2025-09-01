<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUKANG VPN Online Users</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #ffffff 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .table-container {
            width: 95%;
            max-width: 800px;
            margin: 32px auto 0 auto;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.08);
            border-radius: 8px;
            padding: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            border: 1px solid #ececec;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .online {
            color: #00C853; font-weight: bold;
        }
        .online-warning {
            color: #FFD600; font-weight: bold; /* Yellow */
        }
        .online-danger {
            color: #D32F2F; font-weight: bold; /* Red */
        }
        .offline {
            color: #d32f2f; font-weight: bold;
        }
        .total-users {
            text-align: center;
            margin-top: 16px;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .status-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: middle;
        }
        .dot-green { background: #00C853; }
        .dot-yellow { background: #FFD600; }
        .dot-red { background: #D32F2F; }
        @media (max-width: 600px) {
            .table-container {padding: 5px;}
            th, td {font-size: 0.91rem;}
        }
    </style>
</head>
<body>
    <!-- Navbar (same as index.html) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="https://raw.githubusercontent.com/hunmai/icon/refs/heads/main/icon_pukang.png" alt="PUKANG VPN Logo" style="width:36px; height:auto;">
                PUKANG VPN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#PUKANG VPN Navbar" aria-controls="PUKANG VPN Navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="PUKANG VPN Navbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                </ul>
            </div>
        </div>
    </nav>
    <h3 class="mt-4 text-center">PUKANG VPN Server Status</h3>
    <div class="table-container">
    <?php
        
// CSP header (allow all domains)
header("Content-Security-Policy: frame-ancestors *;");

        $servers = [
            '🇹🇭 TH 01' => 'http://pu01.saeng.shop:82/server/online',
            '🇹🇭 TH 02' => 'http://pu02.saeng.shop:82/server/online',
            '🇹🇭 TH 03' => 'http://pu03.saeng.shop:82/server/online',
            '🇹🇭 TH 04' => 'http://pu04.saeng.shop:82/server/online',
            '🇹🇭 TH 05' => 'http://pu05.saeng.shop:82/server/online',
            '🇹🇭 TH 06' => 'http://pu06.saeng.shop:82/server/online',
            '🇹🇭 TH 07' => 'http://pu07.saeng.shop:82/server/online',
            '🇹🇭 TH 08' => 'http://pu08.saeng.shop:82/server/online',
            '🇹🇭 TH 09' => 'http://pu09.saeng.shop:82/server/online',
            '🇹🇭 TH 10' => 'http://pu10.saeng.shop:82/server/online',
            
            
        ];

        $totalOnlineCount = 0;

        echo '<table>';
        echo '<tr>
                <th>Server Name</th>
                <th>Status</th>
              </tr>';

        foreach ($servers as $serverName => $serverURL) {
            $response = @file_get_contents($serverURL);
            if ($response !== false && is_numeric(trim($response))) {
                $onlineCount = intval($response);
                $totalOnlineCount += $onlineCount;

                // Color logic
                if ($onlineCount > 400) {
                    $statusClass = "online-danger";
                    $dotClass = "dot-red";
                    $label = "High Load";
                } elseif ($onlineCount > 300) {
                    $statusClass = "online-warning";
                    $dotClass = "dot-yellow";
                    $label = "Busy";
                } else {
                    $statusClass = "online";
                    $dotClass = "dot-green";
                    $label = "Normal";
                }

                echo "<tr>
                        <td>$serverName</td>
                        <td class='$statusClass'>
                            <span class='status-dot $dotClass'></span>
                            Online $onlineCount people
                            <span class='badge rounded-pill ms-2 $statusClass' style='background: transparent; border: 1px solid #ececec; font-size: 0.85em;'>$label</span>
                        </td>
                      </tr>";
            } else {
                echo "<tr><td>$serverName</td><td class='offline'><span class='status-dot dot-red'></span>Unable to connect</td></tr>";
            }
        }

        // Total users color
        if ($totalOnlineCount > 400 * count($servers)) {
            $totalClass = "online-danger";
            $dotClass = "dot-red";
        } elseif ($totalOnlineCount > 300 * count($servers)) {
            $totalClass = "online-warning";
            $dotClass = "dot-yellow";
        } else {
            $totalClass = "online";
            $dotClass = "dot-green";
        }

        echo '</table>';
        echo "<div class='total-users'>Total online users: <span class='$totalClass'><span class='status-dot $dotClass'></span>$totalOnlineCount</span> people</div>";
    ?>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
