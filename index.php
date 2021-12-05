

<html>
    <head>
        <script type="text/javascript" src="assets/js/jszip.js"></script>
        <script type="text/javascript" src="assets/js/jszip-utils.js"></script>
        <script src="assets/js/FileSaver.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://un.pixel-fy.com/assets/css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

       </head>
    <body onload="test()">
    <div id="overlay-back"></div>
<div id="overlay">
    <div id="dvLoading">
        <h2>Please wait</h2>
        <p>This may take a very long time....</p>
        <div class="bottom"><h2>Downloading selected apps and putting into a fashable zip...</h2>
        <p><p>DO NOT refresh or leave this page until download has started</p><br>
        </div>

        <div class="main">
          <div class="one"></div>
          <div class="two"></div>
          <div class="three"></div>
        </div>
    </div>
</div>
<script>
              $('#dvLoading, #overlay, #overlay-back').fadeIn(500);
            </script>
        </body>
    <script>
        
        function test() {
var urls = [
<?php 
  $brochure = $_POST['brochure'] ;
  foreach ($brochure as $file => $val) {
    echo "'https://corsanywhere.herokuapp.com/" . $val . "',";
   }?>
];

var zip = new JSZip();
    var moduleprop = $.get("base/module.prop");
    var customize = $.get("base/customize.sh");
    var uninstall = $.get("base/uninstall.sh");
    var updatebin = $.get("base/META-INF/com/google/android/update-binary");
    var updaterscript = $.get("base/META-INF/com/google/android/updater-script");
    var funcions = $.get("base/common/functions.sh");
    var install = $.get("base/common/install.sh");

    var count = 0;
    var count2 = 0;
    var zipFilename = "Fossapps-Custom.zip";
    var nameFromURL = [];

    var the_arr = "";
    for (var i = 0; i< urls.length; i++){
        the_arr = urls[i].split('/');
        nameFromURL[i] = the_arr.pop();

    }

    urls.forEach(function(url){
        var filename = nameFromURL[count2];
        var foldername = filename.split('.').slice(0, -1).join('.');
        count2++;
        // loading a file and add it in a zip file
        JSZipUtils.getBinaryContent(url, function (err, data) {
            if(err) {
                throw err; // or handle the error
            }
      
            zip.file("module.prop", moduleprop);
            zip.file("customize.sh", customize);
            zip.file("uninstall.sh", uninstall);
            zip.file("META-INF/com/google/android/update-binary", updatebin);
            zip.file("META-INF/com/google/android/updater-script", updaterscript);
            zip.file("common/functions.sh", funcions);
            zip.file("common/install.sh", install);

            zip.file("system/product/app/" + foldername + "/" + filename, data, {binary:true});
            count++;
            if (count === urls.length) {
                zip.generateAsync({type:'blob'}).then(function(content) {
                    saveAs(content, zipFilename);
                });
            }
        });
    });
}
    </script>
</html>
