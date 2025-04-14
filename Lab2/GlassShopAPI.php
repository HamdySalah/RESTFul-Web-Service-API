<?php
require_once 'vendor/autoload.php';

header("Content-Type: application/json");//send the api as a json obj

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'] ?? null;// recive a resource or not

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = end($pathParts);
$id = is_numeric($id) ? $id : null;

$db = new MySQLHandler("products");
switch ($method) {
    case 'GET':
        if ($id) {
            $res = $db->get_record_by_id($id);
        } else {
            $res = $db->get_data();
        }
        echo json_encode($res ?: ["error" => "Resource deosn't exist"]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($db->save($data)) {
            echo json_encode(["status" => "Record added successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Bad request"]);
        }
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Missing ID for update"]);
            break;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if ($db->update($data, $id)) {
            echo json_encode(["status" => "Record updated successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Update failed"]);
        }
        break;

    case 'DELETE':
        if ($db->delete($id)) {
            echo json_encode(["status" => "Resource was deleted successfully!"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Delete failed or not found"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
