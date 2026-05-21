<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "luna_echo_valley");
if ($conn->connect_error) {
    echo json_encode(["error" => "Database gagal disambung"]);
    exit;
}

if (isset($_GET['slug'])) {
    $slug = $conn->real_escape_string($_GET['slug']);
    $result = $conn->query("SELECT * FROM resort_amenities WHERE slug = '$slug'");

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Maklumat tempat tiada"]);
    }
} else {
    echo json_encode(["error" => "Tiada zon dipilih"]);
}
$conn->close();
?>