<h1>HELLO</h1>

<?php 
ob_clean();
ob_end_flush();
$brochure = $_POST['brochure'] ;
$version = "v.0.1-pre-alpha";
$header1 = 'ui_print "█▀▀ █▀▀█ █▀▀ █▀▀ █▀▀█ █▀▀█ █▀▀█ █▀▀"';
$header2 = 'ui_print "█▀▀ █░░█ ▀▀█ ▀▀█ █▄▄█ █░░█ █░░█ ▀▀█"';
$header3 = 'ui_print "▀░░ ▀▀▀▀ ▀▀▀ ▀▀▀ ▀░░▀ █▀▀▀ █▀▀▀ ▀▀▀ 𝘾𝙪𝙨𝙩𝙤𝙢"';
$header4 = 'ui_print "Build on Fossapps Creater ' . $version . ' @ un.pixel-fy.com"';
$header5 = 'ui_print "By wacko1805"';
$myfile = file_put_contents('base/customize.sh', $header1 . PHP_EOL , FILE_APPEND | LOCK_EX);
$myfile = file_put_contents('base/customize.sh', $header2 . PHP_EOL , FILE_APPEND | LOCK_EX);
$myfile = file_put_contents('base/customize.sh', $header3 . PHP_EOL , FILE_APPEND | LOCK_EX);
$myfile = file_put_contents('base/customize.sh', $header4 . PHP_EOL , FILE_APPEND | LOCK_EX);
$myfile = file_put_contents('base/customize.sh', $header5 . PHP_EOL , FILE_APPEND | LOCK_EX);
$archive_file_name = "Fossapps-Custom.zip";
$send = true;
if($send) {
    $zip = new ZipArchive();
    $res = $zip->open($archive_file_name, ZipArchive::CREATE);
    if ($res === TRUE) {
        foreach ($brochure as $file => $val) {

        $name =pathinfo($val, PATHINFO_FILENAME); //file name without extension

     

            $download_file = file_get_contents($val);
            $zip->addFromString('system/product/app/' . $name . '/' . $name . '.apk', $download_file);

            #$filename = 'apps/' . $val . '.apk';
            $myfile = file_put_contents('base/customize.sh', 'ui_print "Installing selected app: ' . $name . '"' . PHP_EOL , FILE_APPEND | LOCK_EX);
            $zip->addFile('base/customize.sh', 'customize.sh');
            $zip->addFile('base/module.prop', 'module.prop');
            $zip->addFile('base/uninstall.sh', 'uninstall.sh');
            $zip->addFile('base/common/functions.sh', 'common/functions.sh');
            $zip->addFile('base/common/install.sh', 'common/install.sh');
            $zip->addFile('base/META-INF/com/google/android/update-binary', 'META-INF/com/google/android/update-binary');
            $zip->addFile('base/META-INF/com/google/android/updater-script', 'META-INF/com/google/android/updater-script');
            #$zip->addFile($filename, 'system/product/app/' . $val . '/' . $val . '.apk');
        }
        $zip->close();
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Content-length: " . filesize($archive_file_name));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$archive_file_name");
        unlink("$archive_file_name");
        unlink('base/customize.sh');
    }else {
        echo 'failed';
    }
}
?>