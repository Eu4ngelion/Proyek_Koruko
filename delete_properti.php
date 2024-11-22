<?php
require "koneksi.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Response array
$response = [
    'success' => false,
    'message' => 'Terjadi kesalahan yang tidak diketahui'
];

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $response['message'] = 'ID properti tidak valid';
        echo json_encode($response);
        exit;
    }

    $id_ruko = intval($_POST['id']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // First, check if the property exists
        $check_query = "SELECT * FROM ruko WHERE id_ruko = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "i", $id_ruko);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) === 0) {
            $response['message'] = 'Properti tidak ditemukan';
            echo json_encode($response);
            mysqli_stmt_close($check_stmt);
            exit;
        }

        // Delete related images first (if you have an images table)
        $delete_images_query = "DELETE FROM gambar_ruko WHERE id_ruko = ?";
        $delete_images_stmt = mysqli_prepare($conn, $delete_images_query);
        mysqli_stmt_bind_param($delete_images_stmt, "i", $id_ruko);
        mysqli_stmt_execute($delete_images_stmt);

        // Then delete the property
        $delete_query = "DELETE FROM ruko WHERE id_ruko = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "i", $id_ruko);
        
        if (mysqli_stmt_execute($delete_stmt)) {
            // Commit transaction
            mysqli_commit($conn);

            $response['success'] = true;
            $response['message'] = 'Properti berhasil dihapus';
        } else {
            // Rollback transaction
            mysqli_rollback($conn);
            $response['message'] = 'Gagal menghapus properti';
        }

        // Close statements
        mysqli_stmt_close($delete_images_stmt);
        mysqli_stmt_close($delete_stmt);
        mysqli_stmt_close($check_stmt);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Metode request tidak valid';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;