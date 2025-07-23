<?php
/**
 * Authentication Helper Functions
 */

session_start();

class Auth {
    private static $roles = ['admin', 'analista', 'visitante'];
    
    public static function login($email, $password) {
        $db = getDbConnection();
        
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? AND activo = TRUE");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['rol'];
            $_SESSION['logged_in'] = true;
            return true;
        }
        
        return false;
    }
    
    public static function logout() {
        session_destroy();
        header('Location: /public/login.php');
        exit;
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /public/login.php');
            exit;
        }
    }
    
    public static function requireRole($required_roles) {
        self::requireLogin();
        
        if (!is_array($required_roles)) {
            $required_roles = [$required_roles];
        }
        
        if (!in_array($_SESSION['user_role'], $required_roles)) {
            header('HTTP/1.0 403 Forbidden');
            include '../src/Views/403.php';
            exit;
        }
    }
    
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email' => $_SESSION['user_email'],
                'role' => $_SESSION['user_role']
            ];
        }
        return null;
    }
    
    public static function hasPermission($action, $resource = null) {
        if (!self::isLoggedIn()) {
            return false;
        }
        
        $role = $_SESSION['user_role'];
        
        switch ($role) {
            case 'admin':
                return true; // Admin has full access
                
            case 'analista':
                // Analyst can read/write most things but not user management
                if ($resource === 'usuarios' && in_array($action, ['create', 'update', 'delete'])) {
                    return false;
                }
                return in_array($action, ['read', 'create', 'update', 'delete']);
                
            case 'visitante':
                return $action === 'read'; // Visitor can only read
                
            default:
                return false;
        }
    }
}

// Helper function to display flash messages
function setFlashMessage($type, $message) {
    $_SESSION['flash_messages'][] = ['type' => $type, 'message' => $message];
}

function getFlashMessages() {
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);
    return $messages;
}

function displayFlashMessages() {
    $messages = getFlashMessages();
    foreach ($messages as $msg) {
        $alertClass = $msg['type'] === 'error' ? 'danger' : $msg['type'];
        echo "<div class='alert alert-{$alertClass} alert-dismissible fade show' role='alert'>";
        echo htmlspecialchars($msg['message']);
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
    }
}