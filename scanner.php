<!DOCTYPE html>
<html>
<head>
	<title>scanner</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<video id="video" width="300" height="300" autoplay></video>
<button id="snap" class="hidden">Snap Photo</button>
<button id="set-camera" class="hidden">Turn On Camera</button>
<p>Result: <span id="result"></span></p>
<canvas id="canvas" width="300" height="300" style="display: none"></canvas>
<script type="text/javascript" src="js/qrcode.js"></script>
<script>

const result = document.getElementById("result");

const snap = document.getElementById("snap");
const setCamera = document.getElementById("set-camera");

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

const turnOnCamera = async() => {
	try {
		// Get access to the camera!
		if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		    // Not adding `{ audio: true }` since we only want video now
		    await navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
		        //video.src = window.URL.createObjectURL(stream);
		        video.srcObject = stream;
		        video.play();
		    });
		}

		snap.classList.remove("hidden");
		setCamera.classList.add("hidden");
	}
	catch {
		alert("please turn on the camera");
		snap.classList.add("hidden");
		setCamera.classList.remove("hidden");
	}
}

// Elements for taking the snapshot
// Trigger photo take
snap.addEventListener("click", function() {
	context.drawImage(video, 0, 0, 300, 300);
	console.log(canvas.toDataURL());
	qrcode.callback = function(s) {
		console.log(s);
		result.textContent = s;
	}
	qrcode.decode(canvas.toDataURL());
});

setCamera.addEventListener("click", function() {
	turnOnCamera();
});

turnOnCamera();

</script>
</body>
</html>