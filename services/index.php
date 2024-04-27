<?php

function uploadImage($file, $targetDirectory)
{
    // Kiểm tra xem có lỗi khi tải lên không
    if ($file['error'] !== UPLOAD_ERR_OK) {
        // Xử lý lỗi tải lên nếu có
        return false;
    }

    // Đường dẫn tập tin tạm thời của hình ảnh trên máy chủ
    $tempFilePath = $file['tmp_name'];

    // Lấy phần mở rộng của tên tập tin hình ảnh
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    // Tạo tên tập tin mới để lưu trữ hình ảnh (có thể tùy chỉnh theo nhu cầu của bạn)
    $newFileName = uniqid() . '.' . $fileExtension;

    // Đường dẫn đầy đủ đến tập tin lưu trữ hình ảnh trên máy chủ
    $targetFilePath = $targetDirectory . '/' . $newFileName;

    // Di chuyển tập tin tạm thời đến đúng vị trí trên máy chủ
    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
        // Trả về tên tập tin mới sau khi tải lên thành công
        return $newFileName;
    } else {
        // Xử lý lỗi khi di chuyển tập tin tạm thời
        return false;
    }
}

function uploadMultiImages($files, $uploadDirectory)
{
    $uploadedFiles = [];

    // Loop through each file
    foreach ($files['name'] as $key => $name) {
        // File details
        $fileName = $files['name'][$key];
        $fileTmpName = $files['tmp_name'][$key];
        $fileSize = $files['size'][$key];
        $fileError = $files['error'][$key];

        // Check for upload errors
        if ($fileError === UPLOAD_ERR_OK) {
            // Generate unique file name to avoid overwriting
            $uniqueFileName = uniqid('image_') . '_' . $fileName;

            // Move the file to the upload directory
            $destination = $uploadDirectory . '/' . $uniqueFileName;
            if (move_uploaded_file($fileTmpName, $destination)) {
                // File uploaded successfully, add its name to the list
                $uploadedFiles[] = $uniqueFileName;
            } else {
                // Failed to move the file
                echo "Failed to move file: $fileName";
            }
        } else {
            // Upload error
            echo "Error uploading file: $fileName";
        }
    }

    return $uploadedFiles;
}
