function uploadchange() {
            var input = document.getElementById("file");
            var ul = document.getElementById("uploadlist");
            while (ul.hasChildNodes()) {
                ul.removeChild(ul.firstChild);
            }
            for (var i = 0; i < input.files.length; i++) {
                var li = document.createElement("li");
                thefilesize = input.files[i].fileSize||input.files[i].size;
                if (thefilesize > 1024 * 1024){
                             thefilesize = (Math.round(thefilesize  * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                         }else{
                                thefilesize = (Math.round(thefilesize  * 100 / 1024) / 100).toString() + 'KB';
                }

                li.innerHTML = input.files[i].name + " " + thefilesize ;
                ul.appendChild(li);             
            }
            if(!ul.hasChildNodes()) {
                var li = document.createElement("li");
                li.innerHTML = 'No Files Selected';
                ul.appendChild(li);
            }
            sendRequest();
        }

window.BlobBuilder = window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder;

            function sendRequest() {
        var blob = document.getElementById('file').files[0];
                var BYTES_PER_CHUNK = 524288; // 1MB chunk sizes.
                var SIZE = blob.size;
                var start = 0;
                var end = BYTES_PER_CHUNK;
        window.uploadcounter=0;
        window.uploadfilearray = [];
        document.getElementById('progressNumber').innerHTML = "Upload: 0 % ";
                while( start < SIZE ) {

                    var chunk = blob.slice(start, end);
            window.uploadfilearray[window.uploadcounter]=chunk;
                        window.uploadcounter=window.uploadcounter+1;
                    start = end;
                    end = start + BYTES_PER_CHUNK;
                }
        window.uploadcounter=0;
        uploadFile(window.uploadfilearray[window.uploadcounter],document.getElementById('file').files[0].name);
            }

            function fileSelected() {
                var file = document.getElementById('file').files[0];
                if (file) {
                    var fileSize = 0;
                    if (file.size > 1024 * 1024)
                        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                    else
                        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

                    document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
                    document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
                    document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
                }
            }

            function uploadFile(blobFile,filename,SIZE) {
                var fd = new FormData();
                fd.append("file", blobFile);
			

                var xhr = new XMLHttpRequest();


                xhr.addEventListener("load", uploadComplete, false);
                xhr.addEventListener("error", uploadFailed, false);
                xhr.addEventListener("abort", uploadCanceled, false);

                xhr.open("POST", "services/uploadBigFile.php?SIZE="+SIZE+"&filename="+filename);

                xhr.onload = function(e) {
            window.uploadcounter=window.uploadcounter+1;
            if (window.uploadfilearray.length > window.uploadcounter ){
                uploadFile(window.uploadfilearray[window.uploadcounter],document.getElementById('file').files[0].name,document.getElementById('file').files[0].size); 
                var percentloaded2 = parseInt((window.uploadcounter/window.uploadfilearray.length)*100);
                document.getElementById('progressNumber').innerHTML = 'Upload: '+percentloaded2+' % ';
				
            }else{
                document.getElementById('progressNumber').innerHTML = "File uploaded";
                loadXMLDoc('./system/loaddir.php?url='+ window.currentuploaddir);
				//var res=document.getElementById('progressNumber').innerHTML;
				

            }
                  };

                xhr.send(fd);

            }

           function uploadComplete(evt) {
                /* This event is raised when the server send back a response */
        if (evt.target.responseText != ""){
                    alert(evt.target.responseText);
        }
            }

            function uploadFailed(evt) {
                alert("There was an error attempting to upload the file.");
            }

            function uploadCanceled(evt) {
                xhr.abort();
                xhr = null;
                //alert("The upload has been canceled by the user or the browser dropped the connection.");
            }
