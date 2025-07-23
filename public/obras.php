<?php
/**
 * Obras Controller
 */

require_once '../config/database.php';
require_once '../src/Helpers/auth.php';
require_once '../src/Helpers/functions.php';
require_once '../src/Models/Obra.php';

Auth::requireLogin();

$obraModel = new Obra();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'list':
        $obras = $obraModel->getAllWithUser();
        include '../src/Views/obras_list.php';
        break;
        
    case 'view':
        if (!$id) {
            setFlashMessage('error', 'ID de obra no especificado');
            header('Location: obras.php');
            exit;
        }
        $obra = $obraModel->getWithStats($id);
        if (!$obra) {
            setFlashMessage('error', 'Obra no encontrada');
            header('Location: obras.php');
            exit;
        }
        include '../src/Views/obras_view.php';
        break;
        
    case 'create':
        Auth::requireRole(['admin', 'analista']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => sanitizeInput($_POST['nombre']),
                'clave' => sanitizeInput($_POST['clave']),
                'direccion' => sanitizeInput($_POST['direccion']),
                'municipio' => sanitizeInput($_POST['municipio']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_termino' => $_POST['fecha_termino'],
                'presupuesto_total' => floatval($_POST['presupuesto_total']),
                'usuario_id' => Auth::getCurrentUser()['id']
            ];
            
            $errors = validateRequired($data, ['nombre', 'clave']);
            
            if (empty($errors)) {
                $newId = $obraModel->create($data);
                if ($newId) {
                    setFlashMessage('success', 'Obra creada exitosamente');
                    header("Location: obras.php?action=view&id={$newId}");
                    exit;
                } else {
                    $errors[] = 'Error al crear la obra';
                }
            }
        }
        
        include '../src/Views/obras_form.php';
        break;
        
    case 'edit':
        Auth::requireRole(['admin', 'analista']);
        
        if (!$id) {
            setFlashMessage('error', 'ID de obra no especificado');
            header('Location: obras.php');
            exit;
        }
        
        $obra = $obraModel->find($id);
        if (!$obra) {
            setFlashMessage('error', 'Obra no encontrada');
            header('Location: obras.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => sanitizeInput($_POST['nombre']),
                'clave' => sanitizeInput($_POST['clave']),
                'direccion' => sanitizeInput($_POST['direccion']),
                'municipio' => sanitizeInput($_POST['municipio']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_termino' => $_POST['fecha_termino'],
                'presupuesto_total' => floatval($_POST['presupuesto_total']),
                'estado' => $_POST['estado']
            ];
            
            $errors = validateRequired($data, ['nombre', 'clave']);
            
            if (empty($errors)) {
                if ($obraModel->update($id, $data)) {
                    setFlashMessage('success', 'Obra actualizada exitosamente');
                    header("Location: obras.php?action=view&id={$id}");
                    exit;
                } else {
                    $errors[] = 'Error al actualizar la obra';
                }
            }
        }
        
        include '../src/Views/obras_form.php';
        break;
        
    case 'delete':
        Auth::requireRole(['admin']);
        
        if (!$id) {
            setFlashMessage('error', 'ID de obra no especificado');
            header('Location: obras.php');
            exit;
        }
        
        if ($obraModel->delete($id)) {
            setFlashMessage('success', 'Obra eliminada exitosamente');
        } else {
            setFlashMessage('error', 'Error al eliminar la obra');
        }
        
        header('Location: obras.php');
        exit;
        break;
        
    default:
        header('Location: obras.php');
        exit;
}