<?php

// Shared access checks
// include after connection.php, then call require_login() or require_admin()

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/connection.php");


// Request must come from this same site (blocks cross-site requests)
function same_origin(){

    $source = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';

    $host = parse_url($source, PHP_URL_HOST);

    if (!$host) {
        return false;
    }

    $port = parse_url($source, PHP_URL_PORT);

    if ($port) {
        $host = $host . ":" . $port;
    }

    return strtolower($host) === strtolower($_SERVER['HTTP_HOST'] ?? '');
}


// Stop the request (json for endpoints, redirect for pages)
function deny($json, $message, $page, $code){

    if ($json) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode([
            "success" => false,
            "message" => $message
        ]);
    } else {
        header("Location: " . $page);
    }

    exit;
}


// User must be logged in and active, returns the role of the user
function require_login($json = true, $strict = false){

    global $conn;

    if (empty($_SESSION['user_id'])) {
        deny($json, "User not logged in", "../php/login.php", 401);
    }

    if (($strict || $_SERVER['REQUEST_METHOD'] === 'POST') && !same_origin()) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            "success" => false,
            "message" => "Invalid request"
        ]);
        exit;
    }

    $st = "SELECT role, is_active FROM users WHERE id = ?";
    $stm = $conn->prepare($st);
    $stm->bind_param("i", $_SESSION['user_id']);
    $stm->execute();
    $user = $stm->get_result()->fetch_assoc();
    $stm->close();

    if (!$user || (int)$user['is_active'] !== 1) {
        session_unset();
        session_destroy();
        deny($json, "User not logged in", "../php/login.php", 401);
    }

    return $user['role'];
}


// User must be an admin
function require_admin($json = true){

    // endpoints are strict, pages are only checked on POST
    $role = require_login($json, $json);

    if ($role !== 'admin') {
        deny($json, "Access denied", "../php/studentpage.php", 403);
    }
}
?>
