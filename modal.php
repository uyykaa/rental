<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Input Modal</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h4 class="m-0 font-weight-bold text-primary">Input Modal</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="input_modal.php">
                <div class="form-group">
                    <label for="nominal">Nominal Saldo</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="index.php" class="btn btn-secondary">Keluar</a>
            </form>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>
