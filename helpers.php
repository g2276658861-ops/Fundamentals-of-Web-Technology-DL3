<?php
// Small helper to print database text safely in HTML.
function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
