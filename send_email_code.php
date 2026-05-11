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

$email = trim($_POST["email"] ?? "");

if ($email === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter your email address."
    ]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format."
    ]);
    exit();
}

// Generate a 6-digit verification code.
$code = strval(random_int(100000, 999999));

// Mark old email codes for this address as used.
$clearOld = $conn->prepare("
    UPDATE verification_codes
    SET is_used = 1
    WHERE target = ? AND type = 'email' AND is_used = 0
");
$clearOld->bind_param("s", $email);
$clearOld->execute();

// use MySQL NOW() to generate expires_at, not PHP date().
// This keeps expires_at and created_at in the same time zone.
$stmt = $conn->prepare("
    INSERT INTO verification_codes (target, type, code, expires_at)
    VALUES (?, 'email', ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE))
");
$stmt->bind_param("ss", $email, $code);

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
    "message" => "Email verification code generated successfully.",
    "demo_code" => $code
]);
exit();
?>
