<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:08
 */
namespace framework\tools;
use \finfo;

//@class 图片上传工具类

class Upload
{
    private $upload_path = 'upload/';
    private $maxsize = 200 * 1024;
    private $allow_type = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
    private $newfile_prefix = 'ask_';

    public function __get($para)
    {
        if (property_exists($this, $para)) {
            return $this->$para;
        } else {
            return '没有' . $para . '这个属性';
        }
    }

    public function __set($para, $valu)
    {
        if (property_exists($this, $para)) {
            return $this->$para = $valu;
        } else {
            return '没有' . $para . '这个属性';
        }
    }

    public function doUpload($file)
    {
        if ($file['size'] > $this->maxsize) {
            echo '图片超出大小';
            exit();
        }
        if (!in_array($file['type'], $this->allow_type)) {
            echo '图片格式不正确';
            exit();
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($file['tmp_name']);
        if (!in_array($type, $this->allow_type)) {
            echo '图片格式不正确';
            exit();
        }

        //生成唯一名
        $filename = uniqid($this->newfile_prefix, true);
        $ext = strchr($file['name'], '.');
        $new_filename = $filename . $ext;

        //创建目录
        $destination = $this->upload_path;
        $sub_path = date('Ymd') . '/';
        if (!is_dir($destination . $sub_path)) {
            mkdir($destination . $sub_path, 0777, true);
        }
        $destination .= $sub_path . $new_filename;

        //上传到指定目录
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo '上传成功';
        } else {
            echo '上传失败';
        }
    }
}
?>



