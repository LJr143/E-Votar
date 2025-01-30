<x-app-layout mainClass="flex" page_title="- Voters">
    <x-slot name="main">
        <style>
            #container {
                display: flex;
                justify-content: center;
                position: relative;
            }

            canvas {
                position: absolute;
                z-index: 50;
            }

            #video-feed {
                transform: scaleX(-1);
                z-index: 10;
            }

            #status-message {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin-top: 10px;
                color: red;
            }

            #capture-button {
                margin-top: 20px;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                background-color: gray;
                border: none;
                color: white;
                pointer-events: none; /* Initially disabled */
            }
        </style>

        <div id="container">
            <video id="video-feed" height="560" width="720" autoplay></video>
            <canvas id="canvas"></canvas>
        </div>

        <p id="status-message">Initializing camera...</p>
        <button id="capture-button">Capture Face</button>

        <script src="{{ asset('storage/js/face-api.min.js') }}"></script>
        <script>
            (async () => {
                const video = document.getElementById('video-feed');
                const canvas = document.getElementById('canvas');
                const captureButton = document.getElementById('capture-button');
                const statusMessage = document.getElementById('status-message');
                const ctx = canvas.getContext('2d');

                let faceSteadyCounter = 0;
                let previousX = 0, previousY = 0;
                const STEADY_THRESHOLD = 15; // Frames for steadiness
                const MOVEMENT_THRESHOLD = 10; // Allowed face movement range

                // Start webcam
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    statusMessage.textContent = "Looking for face...";
                } catch (error) {
                    statusMessage.textContent = "Camera access denied!";
                    return;
                }

                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models'),
                ]);

                async function detectFace() {
                    const detections = await faceapi.detectSingleFace(video)
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    if (detections) {
                        const { box } = detections.detection;
                        const faceWidth = box.width;
                        const faceHeight = box.height;
                        const faceX = box.x;
                        const faceY = box.y;

                        // Face size check (too small means "move closer")
                        if (faceWidth < 150 || faceHeight < 150) {
                            statusMessage.textContent = "Please move closer to the camera";
                            faceSteadyCounter = 0;
                            captureButton.style.backgroundColor = "gray";
                            captureButton.style.pointerEvents = "none";
                        }
                        // Face movement check (if the face moves too much, reset counter)
                        else if (Math.abs(faceX - previousX) > MOVEMENT_THRESHOLD || Math.abs(faceY - previousY) > MOVEMENT_THRESHOLD) {
                            statusMessage.textContent = "Please stay still";
                            faceSteadyCounter = 0;
                            captureButton.style.backgroundColor = "gray";
                            captureButton.style.pointerEvents = "none";
                        }
                        // Face detected and stable
                        else {
                            statusMessage.textContent = "Face detected, hold steady...";
                            faceSteadyCounter++;

                            if (faceSteadyCounter >= STEADY_THRESHOLD) {
                                statusMessage.textContent = "Face ready! Click Capture.";
                                captureButton.style.backgroundColor = "green";
                                captureButton.style.pointerEvents = "auto";
                            }
                        }

                        // Update previous face position
                        previousX = faceX;
                        previousY = faceY;
                    } else {
                        statusMessage.textContent = "Face not detected";
                        faceSteadyCounter = 0;
                        captureButton.style.backgroundColor = "gray";
                        captureButton.style.pointerEvents = "none";
                    }

                    requestAnimationFrame(detectFace);
                }

                await detectFace();

                // Capture image when button is clicked
                captureButton.addEventListener("click", () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Convert image to base64
                    const imageData = canvas.toDataURL("image/png");

                    // Send image to backend
                    fetch("{{ route('face.upload') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ image: imageData }),
                    })
                        .then(response => response.json())
                        .then(data => alert(data.message))
                        .catch(error => console.error("Error:", error));
                });
            })();
        </script>
    </x-slot>
</x-app-layout>
