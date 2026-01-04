<?php
include("../config/main.php");

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        addFeature();
        break;
    case 'edit':
        editFeature();
        break;
    case 'delete':
        deleteFeature();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function addFeature() {
    global $db;
    
    $icon_class = htmlspecialchars(trim($_POST['icon_class']), ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
    $sort_order = (int)$_POST['sort_order'];
    
    if (empty($icon_class) || empty($title) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    $query = "INSERT INTO about_features (icon_class, title, description, sort_order, is_active) 
              VALUES ('$icon_class', '$title', '$description', $sort_order, 1)";
    
    if ($db->query($query)) {
        echo json_encode(['success' => true, 'message' => 'Feature added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add feature']);
    }
}

function editFeature() {
    global $db;
    
    $feature_id = (int)$_POST['feature_id'];
    $icon_class = htmlspecialchars(trim($_POST['icon_class']), ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
    $sort_order = (int)$_POST['sort_order'];
    
    if (empty($icon_class) || empty($title) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    $query = "UPDATE about_features SET 
              icon_class = '$icon_class',
              title = '$title',
              description = '$description',
              sort_order = $sort_order
              WHERE id = $feature_id";
    
    if ($db->query($query)) {
        echo json_encode(['success' => true, 'message' => 'Feature updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update feature']);
    }
}

function deleteFeature() {
    global $db;
    
    $feature_id = (int)$_POST['feature_id'];
    
    $query = "DELETE FROM about_features WHERE id = $feature_id";
    
    if ($db->query($query)) {
        echo json_encode(['success' => true, 'message' => 'Feature deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete feature']);
    }
}
?>