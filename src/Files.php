<?php

namespace abhishekmittal09\torrents;

class Files
{
    public static function upload($index = 0)
    {
        $target_file = UPLOAD_DIR . '/' . $_FILES['uploads']['name'][$index];

        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        if (file_exists($target_file)) {
            return self::failed("Sorry, file already exists.");
        }

        if (!in_array($file_type, ['torrent'])) {
            return self::failed("Sorry, not valid type");
        }

        if ($_FILES["uploads"]["size"][$index] > 5000000) {
            return self::failed("Sorry, your file is too large.");
        }

        if (move_uploaded_file($_FILES["uploads"]["tmp_name"][$index], $target_file)) {
            return (object)[
                "status" => "success",
                "error" => null
            ];
        } else {
            return self::failed("Sorry, there was an error uploading your file.");
        }
    }

    public static function move($index = 0)
    {
        $file = $_POST['downloads'][$index];
        if (file_exists(ACTIVE_DIR)) {
            if (is_dir(ACTIVE_DIR)) {
                if (is_writable(ACTIVE_DIR)) {
                    if ($handle = opendir(UPLOAD_DIR)) {
                        if (is_file(UPLOAD_DIR . '/' . $file)) {
                            rename(UPLOAD_DIR . '/' . $file, ACTIVE_DIR . '/' . $file);

                            return (object)[
                                "status" => "success",
                                "error" => null
                            ];
                        }
                        closedir($handle);
                    } else {
                        return self::failed(UPLOAD_DIR . " could not be opened.");
                    }
                } else {
                    return self::failed(ACTIVE_DIR . " is not writable!");
                }
            } else {
                return self::failed(ACTIVE_DIR . " is not a directory!");
            }
        } else {
            return self::failed(ACTIVE_DIR . " does not exist");
        }
        return self::failed();
    }

    private static function failed($message = "An unknown error occurred.")
    {
        return (object)[
            "status" => "failed",
            "error" => $message
        ];
    }
}