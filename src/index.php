<?php
include 'db.php';

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query database
$sql = "SELECT id, name FROM users";
$result = $conn->query($sql);

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>PHP + MySQL + Monaco Editor</title>
</head>
<body>
<h1>PHP + MySQL on Docker</h1>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>ID: {$row['id']} - Name: {$row['name']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No users found.</p>";
}

$conn->close();

echo "<h2>Code Editor</h2>
<div id='container' style='height: 400px; border: 1px solid #ccc;'></div>

<script src='vs/loader.js'></script>
<script>
    require.config({ paths: { 'vs': 'vs' } });
    require(['vs/editor/editor.main'], function() {
        monaco.editor.create(document.getElementById('container'), {
            value: `<?php
echo 'Hello, World!';
?>`,
            language: 'php'
        });
    });
</script>
</body>
</html>";
