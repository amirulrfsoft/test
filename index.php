<!DOCTYPE html>
<head>
<title>WebCam Access</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
</head>
<body style="width:350px; magin:0 auto;">
<video autoplay id="vid" style="display:block;" width="320" height="240" controls></video>
<table><tr><td><canvas id="canvas" width="320" height="240" style="border:5px solid #d3d3d3; margin:0 auto;"></canvas></td><td colspan="3">
<canvas id="canvas2" width="320" height="240" style="border:5px solid #d3d3d3; margin:0 auto;"></canvas></td></tr><tr><td>
<button onclick="snapshot()">Take Picture</button></td><td>
<button id="start">Start Recording</button></td><td>
<button id="stop">Stop Recording</button></td></tr><tr><td>
<button id="recordedplay" value = "Play recorded">Play Recorded</button></td><td>
Input Text:</td><td><input type="text" value="" id="txt"></td><td><button id="subtxt" value = "Submit Text">Submit Text</button></td></tr></table>
<script type="text/javascript">
    var video_arr = [];
    var video = document.querySelector("#vid");
    var canvas = document.querySelector('#canvas');
  var canvas2 = document.querySelector('#canvas2');
    var ctx = canvas.getContext('2d');
	var ctx2 = canvas2.getContext('2d');
    var localMediaStream = null;

    var onCameraFail = function (e) {
        console.log('Camera did not work.', e);
    };

    function snapshot() {
        if (localMediaStream) {
            ctx.drawImage(video, 0, 0,320,240);
        }
    }
	
	//// code for recording start....
	var timer;
	$('#subtxt').click(function(){
		$('input[id=txt]').val("");
		});
	$('#start').click(function(){
    var localMediaStream=null;
    
    timer = setInterval(function() {
        ctx2.drawImage(video,0,0, 320, 240);
		//alert(is_txt);
		txt =  $('input[id=txt]').val();
		var fontSize = 20;
        ctx2.textBaseline = 'top';
	    ctx2.font = 'normal ' + fontSize + 'px Arial';
        ctx2.fillText(txt, 0, 220);
				
        video_arr.push(canvas2.toDataURL());
        
    }, 67);
});
$('#stop').click(function(){
clearInterval(timer);
});
    /// code for recording end ..
    ///// recorded play start
var framenum = 0;
var image = new Image(); 
var curr_frame = 0;
$('#recordedplay').click(function(){
    curr_frame = 0;
    var timer;
    timer = setInterval(function() {
        if(curr_frame<video_arr.length){
            image.src = video_arr[curr_frame];
            ctx2.drawImage(image,0,0);
            $('#fnum').html(curr_frame);
        }
        else{
            clearInterval(timer);
        }
        curr_frame++;
    }, 67);
});
//// recorded play end
	
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    window.URL = window.URL || window.webkitURL;
    navigator.getUserMedia({video:true, audio:true}, function (stream) {

// for google crome   
//video.src = window.URL.createObjectURL(stream); 
// for mozilla 
video.mozSrcObject = stream;     

localMediaStream = stream;
    }, onCameraFail);
</script>
</body>
</html>
