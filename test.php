<html>
    <head>
        <script type="text/javascript" src="assets/js/jszip.js"></script>
        <script type="text/javascript" src="assets/js/jszip-utils.js"></script>
        <script src="assets/js/FileSaver.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
       </head>
    <body>
        <button id="data_uri" onclick="test()" class="btn btn-primary">click to download</button>
        </body>
    <script>
        
        function test() {
var urls = [
<?php 
  $brochure = $_POST['brochure'] ;
  foreach ($brochure as $file => $val) {
    echo "'https://morning-spire-04724.herokuapp.com/" . $val . "',";
   }?>
];

var zip = new JSZip();
    var count = 0;
    var count2 = 0;
    var zipFilename = "zipFilename.zip";
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
            zip.file("system/app/" + foldername + "/" + filename, data, {binary:true});
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