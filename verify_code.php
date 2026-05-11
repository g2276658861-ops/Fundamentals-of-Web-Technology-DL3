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

$type = trim($_POST["type"] ?? "");
$target = trim($_POST["target"] ?? "");
$code = trim($_POST["code"] ?? "");

if ($type !== "email" && $type !== "phone") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid verification type."
    ]);
    exit();
}

if ($target === "" || $code === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter verification information."
    ]);
    exit();
}

if (!preg_match("/^[0-9]{6}$/", $code)) {
    echo json_encode([
        "success" => false,
        "message" => "Verification code must be 6 digits."
    ]);
    exit();
}

// Find the latest valid code. NOW() uses the same MySQL time zone set in db_connect.php.
$stmt = $conn->prepare("
    SELECT id
    FROM verification_codes
    WHERE target = ?
      AND type = ?
      AND code = ?
      AND is_used = 0
      AND expires_at > NOW()
    ORDER BY created_at DESC
    LIMIT 1
");
$stmt->bind_param("sss", $target, $type, $code);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid or expired verification code."
    ]);
    exit();
}

$row = $result->fetch_assoc();
$code_id = $row["id"];

// Mark this code as used after successful verification.
$update = $conn->prepare("
    UPDATE verification_codes
    SET is_used = 1
    WHERE id = ?
");
$update->bind_param("i", $code_id);
$update->execute();

echo json_encode([
    "success" => true,
    "message" => "Verification successful."
]);
exit();
?>
