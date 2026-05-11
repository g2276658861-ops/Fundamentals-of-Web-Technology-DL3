<?php
session_start();
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

if ($type !== "phone" && $type !== "email") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid login type."
    ]);
    exit();
}

if ($target === "" || $code === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter the phone/email and verification code."
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

// Check the latest valid verification code. NOW() uses the same MySQL time zone set in db_connect.php.
$codeStmt = $conn->prepare("
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
$codeStmt->bind_param("sss", $target, $type, $code);
$codeStmt->execute();
$codeResult = $codeStmt->get_result();

if ($codeResult->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid or expired verification code."
    ]);
    exit();
}

// The phone/email must already belong to a registered seller.
if ($type === "phone") {
    $sellerStmt = $conn->prepare("
        SELECT seller_id, username, name
        FROM sellers
        WHERE phone = ?
        LIMIT 1
    ");
} else {
    $sellerStmt = $conn->prepare("
        SELECT seller_id, username, name
        FROM sellers
        WHERE email = ?
        LIMIT 1
    ");
}

$sellerStmt->bind_param("s", $target);
$sellerStmt->execute();
$sellerResult = $sellerStmt->get_result();

if ($sellerResult->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "This " . $type . " is not registered as a seller. Please register first."
    ]);
    exit();
}

$seller = $sellerResult->fetch_assoc();
$codeRow = $codeResult->fetch_assoc();
$codeId = $codeRow["id"];

// Mark the code as used after successful login.
$updateStmt = $conn->prepare("
    UPDATE verification_codes
    SET is_used = 1
    WHERE id = ?
");
$updateStmt->bind_param("i", $codeId);
$updateStmt->execute();

// Create the same session used by password login.
$_SESSION["seller_id"] = $seller["seller_id"];
$_SESSION["username"] = $seller["username"];
$_SESSION["seller_name"] = $seller["name"];

echo json_encode([
    "success" => true,
    "message" => "Verification successful. Redirecting to add car page...",
    "redirect" => "add-car.php"
]);
exit();
?>
