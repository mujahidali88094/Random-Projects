
$(document).ready(function(){
    var filesAmount=0;
    var validUploads = [];
    var inputFiles;
    var finalObject = { files : [] };

    //generates HTML code for preview of Files to be uploaded
    function code(name,src,error,id){
        return `<div class="uploadFile">
<div class="fileImage">
<div class="imgWrapper rounded position-relative">
<img id="previewImg" src="`+src+`">
<div class="up px-4 py-2">
<div class="name mr-auto">`
            +name+ `</div>
<button class="btn btnNoStyle p-0 pl-5 ml-auto" id="close`+id+`">x</button>
</div>
<div class="down">
<div class="error px-4 ` + error +` "><p class="mb-0">File size must be at least 4 MegaPixels...</p></div>
</div>
</div>
</div>
<div class="fileExtras">
<label><b>Tags</b> (optional)</label>
<input name="tags`+id+`" type="text" name="tags" class="tags form-control" data-value="" data-rule="tagsinput">
<label><b>Location</b> (optional)</label>
<input name="location`+id+`" type="text" name="location form-control" data-value="" class="location">
<input type="hidden" name="pictureName`+id+`" value="`+name+`">
</div>
</div>`;
    }

    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            let noOfFilesAlreadyPresent = filesAmount;
            filesAmount += input.files.length;//increment total 
            for (let i = noOfFilesAlreadyPresent; i < filesAmount; i++) {//loop through new Files
                finalObject.files.push(input.files[i-noOfFilesAlreadyPresent]);//add file by file
                let name = input.files[i-noOfFilesAlreadyPresent].name;
                //read file getting MegaPixels of image
                let reader = new FileReader();
                reader.onload = function(e) {
                    let error = "" ;
                    let image = new Image();
                    image.src = e.target.result;
                    image.onload = function (event) {
                        let megaPixels = ( this.height * this.width ) / 1000000;
                        if(megaPixels >= 4){
                            error = "d-none" ;
                            validUploads[i] = 1;
                        }
                        else{
                            error = "" ;
                            validUploads[i] = 0;
                        }
                        console.log(i);
                        console.log(validUploads.toString());
                        $(placeToInsertImagePreview).append(code(name,e.target.result,error,i));//insert HTML

                        let b =  $('.fileExtras > .tags');
                        b.tagsinput();
                        $(b).on("change",function(e){
                            $("input[name='"+e.target.getAttribute("name")+"']").attr("data-value",e.target.value);  
                        });
                        $(".location").on("input",function(e){
                            $(e.target).attr("data-value",e.target.value);  
                        });


                    }
                }
                reader.readAsDataURL(input.files[i-noOfFilesAlreadyPresent]);
            }
        }


    };

    $(document).on("load",function(){    
        $(".uploadFile").remove();
    });

    $(function() {
        $('input, select').on('change', function(event) {
            var $element = $(event.target),
                $container = $element.closest('.example');

            if (!$element.data('tagsinput'))
                return;

            //var val = $element.val();
            if (val === null)
                val = "null";
            $('code', $('pre.val', $container)).html( ($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\"") );
            $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));
        }).trigger('change');
    });
    //event listeners for drag and drop
    $("html").on("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });
    $("html").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });
    $('#uploadBox').on("dragover",function() {
        $('#uploadBox').css("opacity","0.6");
    }); 
    $('#uploadBox').on("dragenter",function() {
        $('#uploadBox').css("opacity","0.8");
    });
    $('#uploadBox').on("dragleave",function() {
        $('#uploadBox').css("opacity","1");
    });
    $('#uploadBox').on("drop",function(evt) {
        evt.preventDefault();
        $('#uploadBox').css("background-color","#f5f5f5");
        console.log("dropped");
        var filesDropped = evt.originalEvent.dataTransfer.files;	
        var validFiles = getValidFiles(filesDropped);			
        console.log(validFiles);
        inputFiles = { files : validFiles };
        imagesPreview(inputFiles,'#previewBox>#form');
    });

    //select using browse button
    $('#hiddenInput').on('change', function() {
        var validFiles = getValidFiles(this.files);			
        console.log(validFiles);
        inputFiles = { files : validFiles };
        imagesPreview(inputFiles, '#previewBox>#form');
    });

    //when close button is pressed on a preview image
    $("#previewBox").on("click",".btnNoStyle",function(){
        let id = $(this).attr("id");
        id = id.substr(5);
        console.log("picture no "+(id)+" will be removed");
        validUploads[id] = 0;
        $(this).parent().parent().parent().parent().remove();
    });

    //filters files based on extension
    function getValidFiles(allFiles){
        var validFiles = [];
        for(let c=0;c<allFiles.length;c++){
            let type = allFiles[c].type;
            if((type == "image/jpg") || (type == "image/jpeg") || (type == "image/png")) validFiles.push(allFiles[c]);
        }
        return validFiles;
    }



    //publish button is clicked
    $('#publish').on("click",function(){

        var myFormData = new FormData();
        console.log(finalObject);

        //attach files to form
        for(let i=0;i<filesAmount;i++){
            if(validUploads[i]==1){
                myFormData.append('files[]', finalObject.files[i]);
                console.log(myFormData);

                console.log(finalObject.files[i].name+' appended.');
            };
        }
        // pass info about noOfFiles and noOfTextForms(can be greater than noOfFiles)
        let size = 0;
        for(let j=0;j<validUploads.length;j++){
            if(validUploads[j]==1) ++size;
        }
        myFormData.append('noOfFiles', size );
        myFormData.append('maxSize', validUploads.length );

        //attach textForms to form
        var a = document.getElementById("form");
        a.outerHTML = a.outerHTML.replace("forma","form");

        var textFormData = $('#form').serializeArray();
        console.log(textFormData);
        for (let i=1; i<textFormData.length; i+=3){
            textFormData[i].value = $("input[name='"+textFormData[i].name+"']").attr("data-value");
            textFormData[i+1].value = $("input[name='"+textFormData[i+1].name+"']").attr("data-value");
        }
        console.log(textFormData);

        for (let i=0; i<textFormData.length; i++)
            myFormData.append(textFormData[i].name, textFormData[i].value);
        console.log(myFormData);

        //create post request and add event Listeners
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "upload.php");

        //scroll to serverResponseBox
        $('html, body').animate({
            scrollTop: $("#uploadBox").offset().top
        }, 500);

        //show progress Bar
        $('#progressBar').toggleClass("d-none d-flex");
        //aend the request
        ajax.send(myFormData);
    });

    //event Handlers for the post request 
    function _(el) {
        return document.getElementById(el);
    }
    function progressHandler(event) {
        var percent = event.lengthComputable ? (event.loaded / event.total) * 100 : 0 ;
        _("width").style.width = Math.round(percent)+"%";
        _("uploadStatus").innerHTML = "Photos Upload Status: "+Math.round(percent)+"%";
    }
    function completeHandler(event) {
        $('#serverResponse').append(event.target.responseText);
        $('#progressBar').toggleClass("d-none d-flex");
        $(".uploadFile").remove();
        window.location.href="https://localhost/img/me";

        $('footer').html("<span>Submitted</span>");
    }
    function errorHandler(event) {
        $('#progressBar').removeClass("d-flex");
        $('#progressBar').addClass("d-none");
        $('#serverResponse').append("<p class='error'>Upload Failed</p>");
    }
    function abortHandler(event) {
        $('#progressBar').removeClass("d-flex");
        $('#progressBar').addClass("d-none");
        $('#serverResponse').append("<p class='error'>Upload Aborted</p>");
    }
});