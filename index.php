<?php
session_start();

// Constants
define('API_URL', 'https://nubapi.com/api/verify');
define('BEARER_TOKEN', 'Df9RunYhaFrXR56EK2zaDSMhSFoiQ0E0Lc5QSnlp28ab3892');
// Bank data
$bankData = [
  "000034"  =>  "SIGNATURE BANK",
  "000036" => "OPTIMUS BANK",
  "000001" =>"STERLING BANK",
  "000002" => "KEYSTONE BANK",
  "000003" => "FIRST CITY MONUMENT BANK",
  "000004" => "UNITED BANK FOR AFRICA",
  "000006" => "JAIZ BANK",
  "000007" => "FIDELITY BANK",
  "000008" => "POLARIS BANK",
  "000009" =>"CITI BANK",
  "000010" => "ECOBANK",
  "000011" => "UNITY BANK",
  "000012" => "STANBIC IBTC BANK",
  "000013" => "GTBANK PLC",
  "000014" => "ACCESS BANK",
  "000015" => "ZENITH BANK",
  "000016" => "FIRST BANK OF NIGERIA",
  "000017" => "WEMA BANK",
  "000018" => "UNION BANK",
  "000019" => "ENTERPRISE BANK",
  "000021" => "STANDARD CHARTERED BANK",
  "000022" => "SUNTRUST BANK",
  "000023" => "PROVIDUS BANK",
  "060001" => "CORONATION MERCHANT BANK",
  "070001" => "NPF MICROFINANCE BANK",
  "070002" => "FORTIS MICROFINANCE BANK",
  "070008" => "PAGE MFBANK",
  "090001" => "ASO SAVINGS",
  "090003" => "JUBILEE LIFE",
  "090006" => "SAFETRUST",
  "090107" => "FIRST TRUST MORTGAGE BANK PLC",
  "090108" => "NEW PRUDENTIAL BANK",
  "100002" => "PAGA",
  "100003" => "PARKWAY-READYCASH",
  "100005" => "CELLULANT",
  "100006" => "ETRANZACT",
  "100007" => "STANBIC IBTC @EASE WALLET",
  "100008" => "ECOBANK XPRESS ACCOUNT",
  "100009" => "GT MOBILE",
  "100010" => "TEASY MOBILE",
  "090267" => "KUDA MICROFINANCE BANK",
  "100012" => "VT NETWORKS",
  "100036" => "KEGOW(CHAMSMOBILE)",
  "100039" => "PAYSTACK-TITAN",
  "100016" => "FORTIS MOBILE",
  "100017" => "HEDONMARK",
  "100018" => "ZENITH MOBILE",
  "100019" => "FIDELITY MOBILE",
  "100020" => "MONEY BOX",
  "100021" => "EARTHOLEUM",
  "100022" => "STERLING MOBILE",
  "100023" => "TAGPAY",
  "100024" => "IMPERIAL HOMES MORTGAGE BANK",
  "999999" => "NIP VIRTUAL BANK",
  "090111" => "FINATRUST MICROFINANCE BANK",
  "090112" => "SEED CAPITAL MICROFINANCE BANK",
  "090115" => "IBANK MICROFINANCE BANK",
  "090114" => "EMPIRE TRUST MICROFINANCE BANK",
  "090113" => "MICROVIS MICROFINANCE BANK ",
  "090116" => "AMML MICROFINANCE BANK ",
  "090117" => "BOCTRUST MICROFINANCE BANK LIMITED",
  "090120" => "WETLAND  MICROFINANCE BANK",
  "090118" => "IBILE MICROFINANCE BANK",
  "090125" => "REGENT MICROFINANCE BANK",
  "090128" => "NDIORAH MICROFINANCE BANK",
  "090127" => "BC KASH MICROFINANCE BANK",
  "090121" => "HASAL MICROFINANCE BANK",
  "060002" => "FBNQUEST MERCHANT BANK",
  "090132" => "RICHWAY MICROFINANCE BANK",
  "090135" => "PERSONAL TRUST MICROFINANCE BANK",
  "090136" => "MICROCRED MICROFINANCE BANK",
  "090122" => "GOWANS MICROFINANCE BANK",
  "000024" => "RAND MERCHANT BANK",
  "090142" => "YES MICROFINANCE BANK",
  "090286" => "SAFE HAVEN MICROFINANCE BANK",
  "090292" => "AFEKHAFE MICROFINANCE BANK",
  "000027" => "GLOBUS BANK",
  "090285" => "FIRST OPTION MICROFINANCE BANK",
  "090296" => "POLYUNWANA MICROFINANCE BANK",
  "090295" => "OMIYE MICROFINANCE BANK",
  "090287" => "ASSETMATRIX MICROFINANCE BANK",
  "000025" => "TITAN TRUST BANK",
  "090271" => "LAVENDER MICROFINANCE BANK",
  "090290" => "FCT MICROFINANCE BANK",
  "090279" => "IKIRE MICROFINANCE BANK",
  "090303" => "PURPLEMONEY MICROFINANCE BANK",
  "100052" => "ACCESS YELLO & BETA",
  "090123" => "TRUSTBANC J6 MICROFINANCE BANK LIMITED",
  "090305" => "SULSPAP MICROFINANCE BANK",
  "090166" => "ESO-E MICROFINANCE BANK",
  "090273" => "EMERALD MICROFINANCE BANK",
  "100013" => "ACCESS MONEY",
  "090297" => "ALERT MICROFINANCE BANK",
  "090308" => "BRIGHTWAY MICROFINANCE BANK",
  "100033" => "PALMPAY",
  "100004" =>  "Opay Digital Services",
  "090325" => "SPARKLE",
  "090703" => "Bokkos MFB"
];
asort($bankData); // Sort banks alphabetically by name

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function callAPI($method, $url, $data) {
    $curl = curl_init();
    
    if ($method === "GET" && !empty($data)) {
        $url .= "?" . http_build_query($data);
    }
    
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . BEARER_TOKEN
        ],
    ]);
    
    if ($method === "POST") {
        curl_setopt($curl, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
    } elseif ($method === "PUT") {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($curl);
    
    if ($response === false) {
        throw new Exception("API request failed. Please try again later.");
    }
    
    $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    return [$httpStatus, $response];
}

$apiResponse = null;
$errorMessage = null;
$rawResponse = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = "Invalid request. Please try again.";
    } else {
        $accountNumber = trim($_POST['account_number'] ?? '');
        $bankCode = trim($_POST['bank_code'] ?? '');
        
        if (empty($accountNumber) || empty($bankCode)) {
            $errorMessage = "Account number and bank code are required.";
        } else {
            $params = [
                'account_number' => $accountNumber,
                'bank_code'      => $bankCode
            ];
            
            try {
                list($httpStatus, $body) = callAPI('GET', API_URL, $params);
                $rawResponse = $body;
                $response = json_decode($body, true);

                $isSuccess = (isset($response['status']) && $response['status'] === true) ||
                             (isset($response['success']) && $response['success'] === true);
                
                if ($isSuccess) {
                    $apiResponse = [
                        "firstname"      => $response['first_name'] ?? '',
                        "lastname"       => $response['last_name'] ?? '',
                        "othername"      => $response['other_name'] ?? '',
                        "account_name"   => $response['account_name'] ?? '',
                        "account_number" => $response['account_number'] ?? '',
                        "bank_name"      => $response['Bank_name'] ?? ''
                    ];
                } else {
                    if (isset($response['message'])) {
                        $errorMessage = is_array($response['message']) 
                            ? implode(" ", $response['message']) 
                            : $response['message'];
                    } else {
                        $errorMessage = "API responded with an Sucessfull.";
                    }
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Account Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6 space-y-6 transition-all duration-300 hover:shadow-xl">
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-gray-800">Account Verification</h1>
            <p class="text-gray-500">Verify bank account details instantly</p>
        </div>

        <form method="post" class="space-y-4" onsubmit="showLoader()">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Account Number</label>
                <div class="relative">
                    <input type="text" name="account_number" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="Enter account number">
                    <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 3v2m-4 4h18M7 21v-2m-4-4h18"/>
                    </svg>
                </div>
            </div>

           
            <!-- Bank Selection Dropdown -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                <div class="relative">
                    <select name="bank_code" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition appearance-none">
                        <option value="">Select Bank</option>
                        <?php foreach ($bankData as $code => $name): ?>
                            <option value="<?= htmlspecialchars($code) ?>" 
                                <?= (isset($_POST['bank_code']) && $_POST['bank_code'] === $code) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>


            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-transform duration-200 hover:scale-[1.02] flex items-center justify-center">
                <span id="submit-text">Verify Account</span>
                <div id="loader" class="loader hidden ml-2"></div>
            </button>
        </form>

        <?php if ($apiResponse): ?>
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg space-y-2 animate-fade-in">
                <h3 class="text-green-600 font-semibold">✓ Verification Successful</h3>
                <div class="space-y-1 text-sm">
                    <p class="text-gray-700"><span class="font-medium">Account:</span> <?= htmlspecialchars($apiResponse['account_number']) ?></p>
                    <p class="text-gray-700"><span class="font-medium">Name:</span> <?= htmlspecialchars($apiResponse['account_name']) ?></p>
                    <p class="text-gray-700"><span class="font-medium">Bank:</span> <?= htmlspecialchars($apiResponse['bank_name']) ?></p>
                </div>
            </div>
        <?php elseif ($errorMessage): ?>
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg animate-fade-in">
                <p class="text-red-600 font-medium">⚠️ <?= htmlspecialchars($errorMessage) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($rawResponse !== null): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const rawResponse = <?= json_encode($rawResponse) ?>;
                const formattedResponse = JSON.stringify(JSON.parse(rawResponse), null, 2);
                Swal.fire({
                    title: 'API Response',
                    html: `<pre class="text-left text-sm overflow-auto max-h-96">${formattedResponse}</pre>`,
                    icon: 'info',
                    confirmButtonText: 'Close',
                    customClass: {
                        popup: '!max-w-2xl !rounded-2xl',
                        confirmButton: '!bg-blue-600 !px-5 !py-2 !rounded-lg !font-medium'
                    },
                    showClass: {
                        popup: 'animate-scale-in'
                    },
                    hideClass: {
                        popup: 'animate-scale-out'
                    }
                });
            } catch {
                Swal.fire({
                    title: 'API Response',
                    text: rawResponse,
                    icon: 'info',
                    confirmButtonText: 'Close'
                });
            }
        });
    </script>
    <?php endif; ?>

    <script>
        function showLoader() {
            document.getElementById('submit-text').style.display = 'none';
            document.getElementById('loader').classList.remove('hidden');
        }
    </script>
</body>
</html>
