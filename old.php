<h1>HELLO</h1>
<?php 
ob_clean();
ob_end_flush();
$brochure = $_POST['brochure'] ;
$version = "v.0.1-beta";
// create text for customize.sh
$header1 = 'ui_print "█▀▀ █▀▀█ █▀▀ █▀▀ █▀▀█ █▀▀█ █▀▀█ █▀▀"';
$header2 = 'ui_print "█▀▀ █░░█ ▀▀█ ▀▀█ █▄▄█ █░░█ █░░█ ▀▀█"';
$header3 = 'ui_print "▀░░ ▀▀▀▀ ▀▀▀ ▀▀▀ ▀░░▀ █▀▀▀ █▀▀▀ ▀▀▀ 𝘾𝙪𝙨𝙩𝙤𝙢"';
$header4 = 'ui_print "Build on Fossapps Creater ' . $version . ' @ un.pixel-fy.com"';
$header5 = 'ui_print "By wacko1805"';
//create text for module.prop
$module1 = 'id=Fossapps-Custom';
$module2 = 'name=Fossapps Custom';
$module3 = 'version='.$version.'';
$module4 = 'versionCode=8';
$module5 = 'author=Wacko1805';
$module6 = 'description=Fossapps Package made using Fossapps creator @ un.pixel-fy.com';
$module7 = 'support=https://t.me/Fossapps_support';
//create file and insert text for customize.sh
$customize = file_put_contents('base/customize.sh', $header1 . PHP_EOL , FILE_APPEND | LOCK_EX);
$customize = file_put_contents('base/customize.sh', $header2 . PHP_EOL , FILE_APPEND | LOCK_EX);
$customize = file_put_contents('base/customize.sh', $header3 . PHP_EOL , FILE_APPEND | LOCK_EX);
$customize = file_put_contents('base/customize.sh', $header4 . PHP_EOL , FILE_APPEND | LOCK_EX);
$customize = file_put_contents('base/customize.sh', $header5 . PHP_EOL , FILE_APPEND | LOCK_EX);
//create file and insert text for module.prop
$module = file_put_contents('base/module.prop', $module1 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module2 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module3 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module4 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module5 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module6 . PHP_EOL , FILE_APPEND | LOCK_EX);
$module = file_put_contents('base/module.prop', $module7 . PHP_EOL , FILE_APPEND | LOCK_EX);

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
            $customize = file_put_contents('base/customize.sh', 'ui_print "Installing selected app: ' . $name . '"' . PHP_EOL , FILE_APPEND | LOCK_EX);
            $zip->addFile('base/customize.sh', 'customize.sh');
            $zip->addFile('base/module.prop', 'module.prop');
            $zip->addFile('base/uninstall.sh', 'uninstall.sh');
            $zip->addFile('base/common/functions.sh', 'common/functions.sh');
            $zip->addFile('base/common/install.sh', 'common/install.sh');
            $zip->addFile('base/META-INF/com/google/android/update-binary', 'META-INF/com/google/android/update-binary');
            $zip->addFile('base/META-INF/com/google/android/updater-script', 'META-INF/com/google/android/updater-script');
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
        unlink('base/module.prop');
    }else {
        echo 'failed';
    }
}
?>