<?php
// Include database connection file
include('koneksi.php');

// Check if the id is set in the URL
if (isset($_GET['id'])) {
    $id_anggota = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM tim WHERE id_anggota = ?";

    // Initialize a statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the id parameter
        $stmt->bind_param("i", $id_anggota);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the admin page with a success message
            echo "
                <script>
                alert('Anggota berhasil dihapus!');
                document.location.href = 'admin_tentang.php';
                </script>
            ";
        } else {
            // Redirect to the admin page with an error message
            echo "
                <script>
                alert('Gagal menghapus anggota!');
                document.location.href = 'admin_tentang.php';
                </script>
            ";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect to the admin page with an error message
        echo "
            <script>
            alert('Gagal mempersiapkan query!');
            document.location.href = 'admin_tentang.php';
            </script>
        ";
    }
} else {
    // Redirect to the admin page if id is not set
    echo "
        <script>
        alert('ID anggota tidak ditemukan!');
        document.location.href = 'admin_tentang.php';
        </script>
    ";
}

// Close the database connection
$conn->close();
