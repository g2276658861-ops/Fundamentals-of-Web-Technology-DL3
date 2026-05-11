<?php
require_once "db_connect.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit();
}

$phone = trim($_POST["phone"] ?? "");

if ($phone === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter your phone number."
    ]);
    exit();
}

// Accept numbers with optional + at the start.
if (!preg_match("/^\+?[0-9]{8,15}$/", $phone)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid phone number format."
    ]);
    exit();
}

// Generate a 6-digit verification code.
$code = strval(random_int(100000, 999999));

// Mark old phone codes for this number as used.
$clearOld = $conn->prepare("
    UPDATE verification_codes
    SET is_used = 1
    WHERE target = ? AND type = 'phone' AND is_used = 0
");
$clearOld->bind_param("s", $phone);
$clearOld->execute();

// Important: use MySQL NOW() to generate expires_at, not PHP date().
// This keeps expires_at and created_at in the same time zone.
$stmt = $conn->prepare("
    INSERT INTO verification_codes (target, type, code, expires_at)
    VALUES (?, 'phone', ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE))
");
$stmt->bind_param("ss", $phone, $code);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save verification code."
    ]);
    exit();
}

// For local coursework testing, return the demo code directly.
echo json_encode([
    "success" => true,
    "message" => "Phone verification code generated successfully.",
    "demo_code" => $code
]);
exit();
?>
