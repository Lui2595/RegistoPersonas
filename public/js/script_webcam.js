const video = document.getElementById('inputVideo');
const canvas = document.getElementById('overlay');
let currentStream;

// (async () => {
//     const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
//     video.srcObject = stream;
// })()

let resultObject = [];
let alldata = []
let first_load = false;

async function cargarDatos() {
    await $.ajax({
        type: "POST",
        url: "api.php",
        data: { action: "get" },
        success: function (response) {
            console.log(response);
            alldata = response.data;
        }
    });
}
$(document).ready(function () {
    cargarDatos()
    $("#guardar").click(function (e) {
        $.ajax({
            type: "POST",
            url: "api.php",
            data: { action: "insert", objeto: JSON.stringify(resultObject) },
            dataType: "json",
            success: function (response) {
                reiniciar();
            }
        });
    });
});

async function onPlay() {
    try {
        if (!first_load) {
            // Get the list of available cameras and populate the select element
            const devices = await navigator.mediaDevices.enumerateDevices();
            const cameras = devices.filter(device => device.kind === 'videoinput');
            cameras.forEach(camera => {
                const option = document.createElement('option');
                option.value = camera.deviceId;
                option.text = camera.label || `Camera ${camera.deviceId}`;
                cameraSelect.appendChild(option);
            });

            // Start the video stream with the default camera
            startCamera();
            first_load = true;
        }

    } catch (error) {
        console.error('Error enumerating media devices.', error);
    }
    const MODEL_URL = 'public/models';

    await faceapi.loadSsdMobilenetv1Model(MODEL_URL)
    await faceapi.loadFaceLandmarkModel(MODEL_URL)
    await faceapi.loadFaceRecognitionModel(MODEL_URL)
    await faceapi.loadFaceExpressionModel(MODEL_URL)



    let fullFaceDescriptions = await faceapi.detectAllFaces(video)
        .withFaceLandmarks()
        .withFaceDescriptors()
        .withFaceExpressions();
    
    $(".loader").hide();

    resultObject = fullFaceDescriptions;
    const dims = faceapi.matchDimensions(canvas, video, true);
    const resizedResults = faceapi.resizeResults(fullFaceDescriptions, dims);

    faceapi.draw.drawDetections(canvas, resizedResults);
    faceapi.draw.drawFaceLandmarks(canvas, resizedResults);
    faceapi.draw.drawFaceExpressions(canvas, resizedResults, 0.05);

    if (resultObject.length == 0 || resultObject[0].detection._score < .9) {
        setTimeout(() => onPlay(), 100)
    } else {
        const faceMatcher = new faceapi.FaceMatcher(fullFaceDescriptions)
        revisar(faceMatcher);
    }
}
function revisar(faceMatcher) {
    let matchEl = false;
    alldata.every((fd, i) => {
        let descriptor = Object.values(fd.objeto[0].descriptor);
        let match = faceMatcher.findBestMatch(descriptor);
        if (match._distance < .5) {
            matchEl = true;
            $("#registrado").removeClass("d-none");
            $("#registrado").addClass("d-flex");
            return false;
        }
        return true;
    })
    if (!matchEl) {
        $("#botones").removeClass("d-none");
        $("#botones").addClass("d-flex");
    }

}

function reiniciar() {
    resultObject = [];
    $("#registrado").addClass("d-none");
    $("#registrado").removeClass("d-flex");
    $("#botones").addClass("d-none");
    $("#botones").removeClass("d-flex");
    cargarDatos();
    onPlay()
}


// Function to start streaming video from the selected camera
async function startCamera(cameraId) {
    try {
        // Stop any existing stream
        if (currentStream) {
            currentStream.getTracks().forEach(track => {
                track.stop();
            });
        }

        // Get media devices
        const constraints = {
            video: { deviceId: cameraId ? { exact: cameraId } : undefined }
        };
        const stream = await navigator.mediaDevices.getUserMedia(constraints);

        // Attach the stream to the video element
        video.srcObject = stream;
        currentStream = stream;
    } catch (error) {
        console.error('Error accessing media devices.', error);
    }
}

// Function to toggle camera (switch between front and back cameras)
function toggleCamera() {
    const facingMode = video.srcObject.getVideoTracks()[0].getSettings().facingMode;
    const newFacingMode = facingMode === 'user' ? 'environment' : 'user';
    const constraints = {
        video: { facingMode: newFacingMode }
    };
    reiniciar();
    startCamera(constraints);
}

// Function to change camera based on selection
function changeCamera(selectElement) {
    const selectedCameraId = selectElement.value;
    startCamera(selectedCameraId);
}

function detenerCamaras() {
    if (currentStream) {
        currentStream.getTracks().forEach(track => {
            track.stop();
        });
    }
}

startCamera();




