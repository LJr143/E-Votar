<x-app-layout mainClass="flex" page_title="- Voters">
    <x-slot name="main">
        <style>
            #container {
                display: flex;
                justify-content: center;
                position: relative;
                margin: 20px auto;
                width: 720px;
                height: 560px;
            }

            #video-feed {
                transform: scaleX(-1);
                z-index: 10;
                object-fit: cover;
            }

            #face-guide {
                position: absolute;
                width: 400px;
                height: 400px;
                border: 3px dashed #fff;
                border-radius: 50%;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 20;
                pointer-events: none;
                box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
            }

            #status-message {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin: 10px 0;
                color: red;
                min-height: 60px;
            }

            #capture-button {
                display: block;
                margin: 20px auto;
                padding: 12px 30px;
                font-size: 18px;
                cursor: pointer;
                background-color: gray;
                border: none;
                color: white;
                border-radius: 5px;
                pointer-events: none;
                transition: background-color 0.3s;
            }

            #angle-instructions {
                text-align: center;
                margin: 15px 0;
                font-size: 16px;
                color: #333;
            }

            #progress-container {
                width: 100%;
                background-color: #f1f1f1;
                border-radius: 5px;
                margin: 10px 0;
            }

            #progress-bar {
                height: 20px;
                background-color: #4CAF50;
                border-radius: 5px;
                width: 0%;
                transition: width 0.3s;
            }

            #quality-indicator {
                height: 10px;
                width: 100%;
                background: linear-gradient(to right, red, yellow, green);
                margin: 10px 0;
                position: relative;
            }

            #quality-marker {
                position: absolute;
                height: 15px;
                width: 2px;
                background: black;
                top: -2px;
            }
        </style>

        <div id="container">
            <video id="video-feed" height="560" width="720" autoplay></video>
            <div id="face-guide"></div>
        </div>

        <div id="angle-instructions">Please follow the instructions to capture your face from multiple angles</div>
        <div id="progress-container">
            <div id="progress-bar"></div>
        </div>
        <div id="quality-indicator">
            <div id="quality-marker"></div>
        </div>
        <p id="status-message">Initializing camera...</p>
        <button id="capture-button" data-user-id="{{ $user->id }}">Start Registration</button>

        <script src="/storage/models/face-api.min.js"></script>
        <script>
            (async () => {
                const video = document.getElementById('video-feed');
                const captureButton = document.getElementById('capture-button');
                const statusMessage = document.getElementById('status-message');
                const angleInstructions = document.getElementById('angle-instructions');
                const progressBar = document.getElementById('progress-bar');
                const qualityMarker = document.getElementById('quality-marker');

                // Get the return URL from the query parameter
                const urlParams = new URLSearchParams(window.location.search);
                const returnUrl = urlParams.get('return_url') || '/admin/voters';

                // Registration state
                let registrationState = {
                    step: 0, // 0: ready, 1: front, 2: left, 3: right, 4: up, 5: down
                    captures: [],
                    faceDescriptors: []
                };

                // Start webcam
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: 720,
                            height: 560,
                            facingMode: 'user'
                        }
                    });
                    video.srcObject = stream;
                    statusMessage.textContent = "Camera ready. Click Start Registration.";
                    captureButton.style.backgroundColor = "#4CAF50";
                    captureButton.style.pointerEvents = "auto";
                    captureButton.textContent = "Start Registration";
                } catch (error) {
                    statusMessage.textContent = "Camera access denied! Please enable camera permissions.";
                    console.error("Camera error:", error);
                    return;
                }

                const modelPath = "/storage/models"; // leading slash is key

                // Load face-api models
                try {
                    await Promise.all([
                        faceapi.nets.ssdMobilenetv1.loadFromUri(modelPath),
                        faceapi.nets.faceLandmark68Net.loadFromUri(modelPath),
                        faceapi.nets.faceRecognitionNet.loadFromUri(modelPath),
                        faceapi.nets.ageGenderNet.loadFromUri(modelPath),
                        faceapi.nets.faceExpressionNet.loadFromUri(modelPath),
                    ]);

                } catch (error) {
                    statusMessage.textContent = "Failed to load face detection models!";
                    console.error("Model loading error:", error);
                    return;
                }

                // Calculate image quality metrics
                function calculateQuality(imageData) {
                    let brightness = 0;
                    let contrast = 0;
                    const data = imageData.data;
                    const pixels = data.length / 4;

                    // Calculate brightness (average luminance)
                    for (let i = 0; i < data.length; i += 4) {
                        brightness += (data[i] + data[i + 1] + data[i + 2]) / 3;
                    }
                    brightness /= pixels;

                    // Calculate contrast (standard deviation of luminance)
                    for (let i = 0; i < data.length; i += 4) {
                        const luminance = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        contrast += Math.pow(luminance - brightness, 2);
                    }
                    contrast = Math.sqrt(contrast / pixels);

                    // Normalize values (0-1)
                    brightness = brightness / 255;
                    contrast = contrast / 255;

                    // Combined quality score (0-100)
                    return Math.min(100, Math.max(0, (brightness * 40 + contrast * 60) * 100));
                }

                // Main detection function
                async function detectFace() {
                    try {
                        const detections = await faceapi.detectSingleFace(video)
                            .withFaceLandmarks()
                            .withFaceDescriptor();

                        if (detections) {
                            const { detection, landmarks, descriptor } = detections;
                            const { box } = detection;
                            const faceWidth = box.width;
                            const faceHeight = box.height;

                            // Create canvas for quality analysis
                            const canvas = document.createElement('canvas');
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                            // Get face region for quality check
                            const faceImage = ctx.getImageData(
                                Math.max(0, box.x - 20),
                                Math.max(0, box.y - 20),
                                Math.min(canvas.width - box.x, box.width + 40),
                                Math.min(canvas.height - box.y, box.height + 40)
                            );

                            // Calculate quality
                            const qualityScore = calculateQuality(faceImage);
                            qualityMarker.style.left = `${qualityScore}%`;

                            // Check face size and quality
                            if (faceWidth < 200 || faceHeight < 200) {
                                statusMessage.textContent = "Please move closer to the camera";
                            }
                            else if (qualityScore < 40) {
                                statusMessage.textContent = "Poor image quality. Please improve lighting.";
                            }
                            else {
                                if (registrationState.step === 0) {
                                    statusMessage.textContent = "Ready to start registration";
                                }
                                else {
                                    statusMessage.textContent = getStepInstruction(registrationState.step);
                                }
                            }

                            return { detections, qualityScore };
                        } else {
                            statusMessage.textContent = "Face not detected. Please position your face in the circle.";
                            return null;
                        }
                    } catch (error) {
                        console.error("Detection error:", error);
                        statusMessage.textContent = "Error detecting face. Please try again.";
                        return null;
                    }
                }

                // Get instruction for current step
                function getStepInstruction(step) {
                    const instructions = [
                        "",
                        "Looking straight ahead (Frontal view)",
                        "Slowly turn your head to the LEFT",
                        "Slowly turn your head to the RIGHT",
                        "Slowly tilt your head UP",
                        "Slowly tilt your head DOWN"
                    ];
                    return instructions[step] || "";
                }

                // Capture face for current angle
                async function captureFace() {
                    const result = await detectFace();
                    if (!result || result.qualityScore < 40) {
                        return false;
                    }

                    const { detections, qualityScore } = result;

                    // Create canvas for capture
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Apply circular mask
                    ctx.globalCompositeOperation = 'destination-in';
                    ctx.beginPath();
                    ctx.arc(
                        canvas.width/2,
                        canvas.height/2,
                        Math.min(canvas.width, canvas.height)/2,
                        0,
                        Math.PI*2
                    );
                    ctx.fill();

                    // Store capture
                    registrationState.captures.push({
                        angle: registrationState.step,
                        image: canvas.toDataURL("image/jpeg", 0.9),
                        quality: qualityScore,
                        descriptor: Array.from(detections.descriptor) // Convert Float32Array to regular array
                    });

                    return true;
                }

                // Process registration steps
                async function processRegistration() {
                    if (registrationState.step === 0) {
                        // Start registration
                        registrationState.step = 1;
                        captureButton.textContent = "Capturing...";
                        captureButton.style.backgroundColor = "orange";
                        captureButton.style.pointerEvents = "none";
                        angleInstructions.textContent = getStepInstruction(1);
                        progressBar.style.width = "0%";

                        // Wait for user to position face
                        await new Promise(resolve => setTimeout(resolve, 2000));
                    }

                    // Capture current angle
                    const success = await captureFace();
                    if (!success) {
                        statusMessage.textContent = "Could not capture. Please try again.";
                        captureButton.textContent = "Retry Capture";
                        captureButton.style.backgroundColor = "orange";
                        captureButton.style.pointerEvents = "auto";
                        return;
                    }

                    // Update progress
                    progressBar.style.width = `${registrationState.step * 20}%`;

                    // Move to next step or complete
                    if (registrationState.step < 5) {
                        registrationState.step++;
                        angleInstructions.textContent = getStepInstruction(registrationState.step);

                        // Wait for user to change position
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        await processRegistration();
                    } else {
                        // Registration complete
                        await completeRegistration();
                    }
                }

                // Complete registration process
                async function completeRegistration() {
                    try {
                        captureButton.disabled = true;
                        captureButton.textContent = "Processing...";
                        statusMessage.textContent = "Finalizing registration...";

                        // Prepare the data to send
                        const registrationData = {
                            user_id: captureButton.getAttribute("data-user-id"),
                            captures: registrationState.captures.map(capture => ({
                                angle: capture.angle,
                                image: capture.image.split(',')[1], // Send only the base64 data
                                quality: capture.quality,
                                descriptor: capture.descriptor
                            }))
                        };

                        // Send data to backend
                        const response = await fetch("{{ route('api.face.registration') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify(registrationData)
                        });

                        if (!response.ok) {
                            throw new Error("Server responded with error");
                        }

                        const data = await response.json();

                        if (data.success) {
                            statusMessage.textContent = "Registration successful!";
                            progressBar.style.width = "100%";
                            angleInstructions.textContent = "Thank you for completing face registration";
                            captureButton.style.display = "none";
                            alert('Registration successful!');
                            window.location.href = returnUrl;
                        } else {
                            throw new Error(data.message || "Registration failed");
                        }
                    } catch (error) {
                        console.error("Registration error:", error);
                        statusMessage.textContent = "Registration failed: " + error.message;
                        captureButton.textContent = "Try Again";
                        captureButton.style.backgroundColor = "red";
                        captureButton.style.pointerEvents = "auto";
                        captureButton.disabled = false;
                    }
                }

                // Start detection loop
                setInterval(detectFace, 500);

                // Start registration when button clicked
                captureButton.addEventListener("click", async () => {
                    if (registrationState.step === 0) {
                        await processRegistration();
                    } else {
                        // Retry current step
                        await processRegistration();
                    }
                });
            })();
        </script>
    </x-slot>
</x-app-layout>
