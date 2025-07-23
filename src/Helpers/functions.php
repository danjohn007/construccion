<?php
/**
 * General Helper Functions
 */

/**
 * Format currency for display
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Format percentage for display
 */
function formatPercentage($percentage) {
    return number_format($percentage, 2) . '%';
}

/**
 * Format date for display
 */
function formatDate($date) {
    if (!$date) return '-';
    return date('d/m/Y', strtotime($date));
}

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate required fields
 */
function validateRequired($data, $required_fields) {
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            $errors[] = "El campo {$field} es requerido";
        }
    }
    return $errors;
}

/**
 * Generate random string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $length);
}

/**
 * Log activity
 */
function logActivity($user_id, $action, $details = '') {
    $db = getDbConnection();
    $stmt = $db->prepare("INSERT INTO activity_log (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action, $details, $_SERVER['REMOTE_ADDR'] ?? '']);
}

/**
 * Get pagination data
 */
function getPagination($page, $per_page, $total_records) {
    $page = max(1, intval($page));
    $per_page = max(1, min(100, intval($per_page)));
    $total_pages = ceil($total_records / $per_page);
    $offset = ($page - 1) * $per_page;
    
    return [
        'page' => $page,
        'per_page' => $per_page,
        'total_records' => $total_records,
        'total_pages' => $total_pages,
        'offset' => $offset,
        'has_prev' => $page > 1,
        'has_next' => $page < $total_pages
    ];
}

/**
 * Get status badge class
 */
function getStatusBadgeClass($status) {
    $classes = [
        'planeacion' => 'secondary',
        'en_proceso' => 'primary',
        'terminada' => 'success',
        'cancelada' => 'danger',
        'programado' => 'info',
        'retrasado' => 'warning'
    ];
    
    return $classes[$status] ?? 'secondary';
}

/**
 * Calculate work progress
 */
function calculateProgress($executed, $total) {
    if ($total <= 0) return 0;
    return min(100, ($executed / $total) * 100);
}