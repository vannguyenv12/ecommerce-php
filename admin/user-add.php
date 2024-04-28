<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check password match
    if ($_POST['new_password'] !== $_POST['retype_password']) {
        echo $error;
        exit;
    }


    $uploadDirectory = '../uploads/users';

    print_r($_FILES);
    if ($_FILES['photo'] && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = uploadImage($_FILES['photo'], $uploadDirectory);
        if ($uploadedFileName !== false) {
            // echo 'Hình ảnh đã được tải lên thành công với tên: ' . $uploadedFileName;
        } else {
            echo $error;
            exit;
        }
    } else {
    }

    $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $db->insert(
        'users',
        [
            "status",
            "name",
            "username",
            "email",
            "password",
            "image"
        ],
        [
            $_POST['status'],
            $_POST["name"],
            $_POST["username"],
            $_POST["email"],
            $hashedPassword,
            $uploadedFileName

        ]
    );

    echo $success;
}

?>


<div class="main-content">
    <section class="section">
        <div class="section-header flex" style="justify-content: space-between;">
            <h1>Edit Profile</h1>
            <a class="btn btn-primary" href="./users.php">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="previewImage" src="" alt="" class="profile-photo w_100_p">
                                        <input type="file" class="mt_10" name="photo" id="photoInput">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-4">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">In-Active</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="name" value="">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Username *</label>
                                            <input type="text" class="form-control" name="username" value="">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" value="">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Retype Password</label>
                                            <input type="password" class="form-control" name="retype_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label"></label>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

</div>
</div>

<script src="dist/js/scripts.js"></script>
<script src="dist/js/custom.js"></script>

<script>
    $(document).ready(function() {
        $('#photoInput').change(function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });
    });
</script>



</body>

</html>