<?php
$images = array();
$path = './images/filters';

foreach (scandir($path) as $image)
{
    if ($image !== '.' && $image !== '..' && $image !== '.DS_Store')
    {
        $images[] = $image;
    }
}


//$type = pathinfo($path, PATHINFO_EXTENSION);
//$data = file_get_contents($path);

//$base64 = 'data:image/'. $type .';base64,'. base64_encode($data);

?>

<button class="btn btn-lg"><a href="/camagru/index.php/blog/index">BACK TO MAIN PAGE</a></button>

<html>
    <head>
        <title>Webcam</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="/camagru/classes/view/constant/style.css">
    </head>

    <body>
    <div class="container">
        <div class="row">
            <div class="col-xl-2"><br><br><br><br><p class="text-monospace">Choose a filter!</p></div>
            <div class="col-xl-10" id="filters">
                
                    <button onclick="removeFilter()" class="btn btn-danger">No filter</button>
                        <?php
                            foreach ($images as $image)
                            {
                                $name = pathinfo($image, PATHINFO_FILENAME);
                                $type = pathinfo($image, PATHINFO_EXTENSION);
                                $data = file_get_contents('./images/filters/'.$image);
                                $base64 = 'data:image/'. $type .';base64,'. base64_encode($data);

                                ?><button id="<?=$name?>"><img src="<?=$base64?>" height="100px" id="image<?=$name?>" onclick="activateFilter('image<?=$name?>')"></button>
                    <?php   } ?>


                </div>
        </div>

        <div class="row">

            <div class="col-xl-9">
                <div class="row">
                    <video id="video" playsinline autoplay style="z-index: 1; width: 854px;"></video><br>
                    <canvas id="canvas" width="854" height="480" style="z-index: 0; position: absolute; display: none;"></canvas>
                    <img src="<?=$base64?>" height="200px" width="200px" id="imageFilter" style="z-index: 3; position: absolute; display:none; top:0; left:0;">
                    
                </div>
                <div class="row">
                    <button id="snap" class="btn btn-primary" style="text-align: center; margin: auto; margin-top: 20px;" disabled><p class="text-monospace">Capture image!</p></button>
                    <button id="webcam" class="btn btn-primary" onclick="useWebcam()" style="display: none;"><p class="text-monospace">Use webcam</p></button>
                </div>
                <div class="row">
                    <p class="text-monospace" style="text-align: center; margin: auto; margin-top: 20px;">or upload your own image</p>
                </div>
                <div class="row">
                    <button id="uploadImage" class="btn btn-primary" style="text-align: center; margin: auto; margin-top: 20px;"><input type="file" id="imageLoader" name="imageLoader" value="upload image!"></button>
                </div>
            </div>
            <div class="col-xl-3" id="imageSidebar"><p class="text-monospace">Click on image to make it bigger!</p></div>
        </div>
    </div>
                
                <div style="display: block;" id="canvasDiv">
                    
                </div>

                <div id="previewBack">
                    <div id="previewBox">
                        <img src="" height="480" width="854" style="display: none;" id="previewImage">
                        <button id="closePreview" class="btn btn-danger" onclick="closePreview()">X</button>
                    </div>
                    
                </div>




    <script>

        var webcam = 1;

        var nayttoKerroin = 1;

        var imageCounter = 0;

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('span#ErrorMsg');
        var imageLoader = document.getElementById('imageLoader');
        var imageFilter = document.getElementById('imageFilter');
        var context = canvas.getContext('2d');
        imageLoader.addEventListener('change', handleImage, false);
        var activatedFilter;
        var activatedFilterName;
        var uploadedImageSrc;

        var rect = video.getBoundingClientRect();

        var filterPosX;
        var filterPosY;


        const constraints = {
            audio: false,
            video:{
                width: 854, height: 480
            }
        };

        async function init()
        {
            try{
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            }
            catch(e){
                errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
            }
        }

        function handleSuccess(stream)
        {
            window.stream = stream;
            video.srcObject = stream;
        }

        init();

        function drawNewImage()
        {

            
            updateSidebar();
        }

        function updateSidebar()
        {
            if (!filterPosX || !filterPosY)
            {
                filterPosX = 0;
                filterPosY = 0;
            }

            var img = new Image;
            if (activatedFilter)
                img.src = activatedFilter;
            imageCounter++;
            if (webcam == 1)
                context.drawImage(video, 0, 0, 854, 480);

            var originalImage = canvas.toDataURL("image/png");
            //console.log(originalImage);
            if (activatedFilter != '')
                context.drawImage(img, (parseInt(filterPosX) / nayttoKerroin), (parseInt(filterPosY) / nayttoKerroin), 200, 200);
            //console.log(filterPosX);
            //console.log(filterPosY);

            imageSidebar = document.getElementById('imageSidebar');

            var sidebarElement = document.createElement('div');
            var imageDiv = document.createElement('div');
            var buttonDiv = document.createElement('div');

            //imageDiv.setAttribute('class', 'col-sm-10');
            //buttonDiv.setAttribute('class', 'col-sm-2');
            imageDiv.setAttribute('style', 'width: 250px; height: 180px;');
            imageDiv.setAttribute('class', 'imageDiv');
            buttonDiv.setAttribute('style', 'display: block; margin-bottom: 15px;');
            sidebarElement.setAttribute('class', 'row');
            sidebarElement.setAttribute('style', 'height: 280px; display: flex;');
            sidebarElement.id = "div"+imageCounter;

            var sidebarImageButton = document.createElement('button');
            var sidebarRemoveButton = document.createElement('button');
            var sidebarAddButton = document.createElement('button');

            sidebarRemoveButton.id = "r"+imageCounter;
            sidebarRemoveButton.setAttribute('onclick', 'imageRemove('+imageCounter+')');
            sidebarRemoveButton.setAttribute('class', 'btn btn-danger');
            sidebarRemoveButton.innerHTML = "X";

            sidebarAddButton.id = "a"+imageCounter;
            sidebarAddButton.setAttribute('onclick', 'imageAdd('+imageCounter+')');
            sidebarAddButton.setAttribute('class', 'btn btn-success');
            sidebarAddButton.innerHTML = "Add to gallery!";
         
            sidebarImageButton.id = "b"+imageCounter;
            sidebarImageButton.setAttribute('onclick', 'imageClick('+imageCounter+')');

            var canvasData = canvas.toDataURL("image/png");

            var image = document.createElement('img');
            image.src = canvasData;
            image.id = "i"+imageCounter;
            image.setAttribute('size', nayttoKerroin);
            image.setAttribute('filterX', filterPosX);
            image.setAttribute('filterY', filterPosY);
            image.setAttribute('filter', activatedFilterName);
            image.setAttribute('original', originalImage);
            image.setAttribute('style', 'width: 250px; height: 200px; object-fit: contain;');

            //image.style.width = "300px";

            sidebarElement.appendChild(imageDiv);
            imageDiv.appendChild(sidebarImageButton);
            sidebarImageButton.appendChild(image);

            buttonDiv.appendChild(sidebarAddButton);
            buttonDiv.appendChild(sidebarRemoveButton);
            sidebarElement.appendChild(buttonDiv);
            
            imageSidebar.appendChild(sidebarElement);
            
            if (uploadedImageSrc)
            {
                context.fillStyle = "white";
                context.fillRect(0, 0, 854, 480);
                context.drawImage(uploadedImageSrc, 0, 0, 854, 480);
            }
        }

        
        snap.addEventListener("click", function(){
            
            drawNewImage();
            
/*  
            var canvasData = canvas.toDataURL("image/png");
            var ajax = new XMLHttpRequest();
            ajax.open("POST", '/camagru/index.php/ajax/uploadImage', true);
            ajax.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200)
                {
                    console.log(ajax.responseText);
                    
                    imageCounter++;
                    console.log(imageCounter);
                }
            }
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("imgData=" + canvasData);
*/
        });
        
        function closePreview()
        {
            previewBack = document.getElementById('previewBack');
            imageFilter = document.getElementById('imageFilter');
            previewBack.style.display = "none";
            video.style.display = "block";
            canvas.style.display = "block";
            imageFilter.style.opacity = 1;
        }

        function imageClick(id)
        {

            previewBack = document.getElementById('previewBack');
            previewBox = document.getElementById('previewBox');
            previewImage = document.getElementById('previewImage');
            srcImage = document.getElementById('i' + id);
            imageFilter = document.getElementById('imageFilter');

            previewImage.style.display = "block";
            previewImage.src = srcImage.src;
            video.style.display = "none";
            canvas.style.display = "none";
            imageFilter.style.opacity = 0;
            previewBack.style.display = "flex";



        }
        
        function imageRemove(id)
        {

            document.getElementById("div"+id).remove();
        }

        function imageAdd(id)
        {



            var image = document.getElementById("i"+id);

            var imageData = image.getAttribute("original");
            var filterName = image.getAttribute("filter");
            var filterPosY = image.getAttribute("filterY");
            var filterPosX = image.getAttribute("filterX");
            var kerroin = image.getAttribute("size");


            filterName = filterName.replace("image", "");


            var ajax = new XMLHttpRequest();
            ajax.open("POST", '/camagru/index.php/ajax/uploadImage', true);
            ajax.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200)
                {
                    if (ajax.responseText == "false")
                        console.log("failed");
                    else
                    {

                        document.getElementById("div"+id).remove();
                    }
                    //console.log(ajax.responseText);

                }
            }
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("imageData=" + imageData + "&filterName=" + filterName + "&filterPosX=" + filterPosX + "&filterPosY=" + filterPosY + "&kerroin=" + kerroin);
            

        }

        function activateFilter(id)
        {
            var filter = document.getElementById(id);
            activatedFilter = filter.src;
            activatedFilterName = filter.id;

            
            imageFilter.style.display = "block";
            imageFilter.src = activatedFilter;

            snap.disabled = false;
        }
        
        function removeFilter()
        {
            activatedFilter = '';
            activatedFilterName = '';
            var imageFilter = document.getElementById('imageFilter');
            imageFilter.src = activatedFilter;
            imageFilter.style.display = "none";
            snap.disabled = true;
        }

        function addListeners()
        {
            document.getElementById("imageFilter").addEventListener("mousedown", mouseDown, false);
            window.addEventListener("mouseup", mouseUp, false);

            document.getElementById("imageFilter").ondragstart = function() { return false };
        }

        function mouseUp()
        {
            window.removeEventListener("mousemove", divMode, true);

        }

        function mouseDown()
        {
            window.addEventListener("mousemove", divMode, true);

            rect = video.getBoundingClientRect();
        }

        function divMode(e)
        {

            
            var newY = e.clientY - rect.top - (100 * nayttoKerroin);
            var newX = e.clientX - rect.left - (100 * nayttoKerroin);

            //console.log(e.clientY);
 
            imageFilter.style.top = newY + 'px';
            imageFilter.style.left = newX + 'px';
            //console.log(imageFilter.style.top);
            //console.log("X: "+div.style.left);
            //console.log("Y: "+div.style.top); 854 480
            if (newY < 0)
                imageFilter.style.top = 0 + 'px';
            if (newY > (480 - 200) * nayttoKerroin)
                imageFilter.style.top = ((480 - 200) * nayttoKerroin) + 'px';
            if (newX < 0)
                imageFilter.style.left = 0 + 'px';
            if (newX > ((854 - 200) * nayttoKerroin))
                imageFilter.style.left = ((854 - 200) * nayttoKerroin) + 'px';

            filterPosX = imageFilter.style.left;
            filterPosY = imageFilter.style.top;

        }

        function handleImage()
        {
            var reader = new FileReader();
            reader.onload = function(event)
            {
                var img = new Image();
                img.src = event.target.result;
                canvas.style.display = "block";
                
                img.onload = function()
                {
                    img.height = 50;
                    img.width = 50;
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    //canvas.height = 100;
                    //canvas.width = 50;
                    uploadedImageSrc = img;
                    context.clearRect(0, 0, 854, 480);
                    context.fillStyle = "white";
                    context.fillRect(0, 0, 854, 480);
                    context.drawImage(img, 0, 0, 854, 480);
                    
                }

            }
            reader.readAsDataURL(this.files[0]);

            canvas.style.zIndex = 2;
            webcam = 0;
            document.getElementById('webcam').style.display = "block";
            video.style.opacity = 0;
        }
        
        function useWebcam()
        {

            canvas.style.zIndex = 0;
            video.style.opacity = 1;
            document.getElementById('webcam').style.display = "none";
            webcam = 1;
        }

        function widthCheck(widthChecker)
        {
            if (widthChecker.matches)
            {
                nayttoKerroin = 0.5;

                imageFilter.style.left = 0;
                imageFilter.style.top = 0;
            }
            else
            {
                nayttoKerroin = 1;

            }
        }

        var widthChecker = window.matchMedia("(max-width: 1000px)")
        widthCheck(widthChecker);
        widthChecker.addListener(widthCheck);


        addListeners();

    
    </script>




    </body>
</html>