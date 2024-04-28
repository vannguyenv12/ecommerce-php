<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php

$user = $db->query("users", "id", $_GET['id']);

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
            echo 'Hình ảnh đã được tải lên thành công với tên: ' . $uploadedFileName;
        } else {
            echo $error;
            exit;
        }
    } else {
        $uploadedFileName = $user->image;
    }

    if (empty($_POST['new_password'])) {
        $hashedPassword = $user->password;
    } else {
        if ($_POST['new_password'] !== $_POST['retype_password']) {
            echo $error;
            exit;
        }
        $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    }


    $db->update(
        'users',
        [
            "status",
            "name",
            "email",
            "password",
            "image"
        ],
        [
            $_POST['status'],
            $_POST["name"],
            $_POST["email"],
            $hashedPassword,
            $uploadedFileName

        ],
        "id",
        $user->id
    );

    $userId = $_GET['id'];
    echo "<script>
    sessionStorage.setItem('reloadingUpdate', 'true');
    window.location.href = 'user-edit.php?id=$userId';</script>
    ";
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
                                        <img id="previewImage" src="../uploads/users/<?= $user->image ?>" alt="" class="profile-photo w_100_p">
                                        <input type="file" class="mt_10" name="photo" id="photoInput">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-4">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option <?= $user->status === 'active' ? 'selected' : '' ?> value="active">Active</option>
                                                <option <?= $user->status === 'inactive' ? 'selected' : '' ?> value="inactive">In-Active</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="name" value="<?= $user->name ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="new_password" placeholder="Leave empty if you do not want to change password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Retype Password</label>
                                            <input type="password" class="form-control" name="retype_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label"></label>
                                            <button type="submit" class="btn btn-primary">Update</button>
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

<script>
    $(document).ready(function() {
        window.onload = showMessage();

        function showMessage() {
            var reloading = sessionStorage.getItem("reloadingUpdate");
            if (reloading) {
                sessionStorage.removeItem("reloadingUpdate");
                Toastify({
                    text: "Updated Successfully",
                    duration: 4000,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                }).showToast();
            }

        }


    });
</script>


</body>

</html>