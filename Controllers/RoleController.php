<?php

require_once '../Koneksi.php';
require_once '../Models/Role.php';

class RoleController {
    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createRole($roleId, $namaRole, $deskripsi) {
        try {
            $roleModel = new Role($this->conn);
            $roleModel->saveRole($roleId, $namaRole, $deskripsi);
            echo json_encode(['success' => true, 'message' => 'Role successfully created.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateRole($roleId, $namaRole, $deskripsi) {
        try {
            $roleModel = new Role($this->conn);
            $roleModel->updateRole($roleId, $namaRole, $deskripsi);
            echo json_encode(['success' => true, 'message' => 'Role successfully updated.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteRole($roleId) {
        try {
            $roleModel = new Role($this->conn);
            $roleModel->deleteRole($roleId);
            echo json_encode(['success' => true, 'message' => 'Role successfully deleted.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getRoleById($roleId) {
        try {
            $roleModel = new Role($this->conn);
            $roleData = $roleModel->findById($roleId);
            if ($roleData) {
                echo json_encode(['success' => true, 'data' => $roleData]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Role not found.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

// Usage example
$database = new Database(); // Create a Database object to get the connection
$conn = $database->conn;

$roleController = new RoleController($conn);

// Get action from request
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'createRole':
        $roleController->createRole(
            $_POST['Role_ID'],
            $_POST['Nama_Role'],
            $_POST['Deskripsi']
        );
        break;
    case 'updateRole':
        $roleController->updateRole(
            $_POST['Role_ID'],
            $_POST['Nama_Role'],
            $_POST['Deskripsi']
        );
        break;
    case 'deleteRole':
        $roleController->deleteRole($_POST['Role_ID']);
        break;
    case 'getRoleById':
        $roleController->getRoleById($_GET['Role_ID']);
        break;
    default:
        echo json_encode(['message' => 'Action not found']);
        break;
}