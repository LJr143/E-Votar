<x-app-layout mainClass="flex" page_title="- Voters">
    <x-slot name="main">
        <style>
            #container {
                display: flex;
                justify-content: center;
                position: relative;
                margin: 20px auto;
                width: 400px;
                height: 400px;
                border-radius: 50%;
                overflow: hidden;
            }

            #video-feed {
                transform: scaleX(-1);
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            #face-guide {
                position: absolute;
                width: 350px;
                height: 350px;
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

            #instructions {
                text-align: center;
                margin: 15px 0;
                font-size: 16px;
                color: #333;
            }

            .validation-message {
                text-align: center;
                color: #ff5722;
                font-weight: bold;
                margin: 5px 0;
                min-height: 20px;
            }

            /* Circular progress bar styles */
            .progress-circle {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10;
                pointer-events: none;
            }

            .progress-circle svg {
                width: 100%;
                height: 100%;
                transform: rotate(-90deg);
            }

            .progress-circle circle {
                fill: none;
                stroke-width: 8;
                stroke-linecap: round;
            }

            .progress-circle-bg {
                stroke: #f1f1f1;
            }

            .progress-circle-fg {
                stroke: #4CAF50;
                stroke-dasharray: 0;
                transition: stroke-dasharray 0.3s;
            }

            /* Liveliness check styles */
            .liveliness-checks {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin: 15px 0;
            }

            .liveliness-check {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .liveliness-check .icon {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background-color: #ccc;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 5px;
            }

            .liveliness-check .label {
                font-size: 12px;
                color: #666;
            }

            .liveliness-check.completed .icon {
                background-color: #4CAF50;
                color: white;
            }
        </style>

        <div id="container">
            <video id="video-feed" autoplay></video>
            <div id="face-guide"></div>
            <div class="progress-circle">
                <svg viewBox="0 0 100 100">
                    <circle class="progress-circle-bg" cx="50" cy="50" r="45" />
                    <circle class="progress-circle-fg" cx="50" cy="50" r="45" />
                </svg>
            </div>
        </div>

        <div id="instructions">Please position your face in the circle and look straight at the camera</div>

        <div class="liveliness-checks">
            <div class="liveliness-check" id="blink1-check">
                <div class="icon">1</div>
                <div class="label">Blink Once</div>
            </div>
            <div class="liveliness-check" id="blink2-check">
                <div class="icon">2</div>
                <div class="label">Blink Twice</div>
            </div>
            <div class="liveliness-check" id="smile-check">
                <div class="icon">☺</div>
                <div class="label">Smile</div>
            </div>
        </div>

        <div class="validation-message" id="validation-message"></div>
        <p id="status-message">Initializing camera...</p>
        <button id="capture-button" data-user-id="{{ $user->id }}">Start Registration</button>
        <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

        <script>
            (async () => {
                const video = document.getElementById('video-feed');
                const captureButton = document.getElementById('capture-button');
                const statusMessage = document.getElementById('status-message');
                const instructions = document.getElementById('instructions');
                const validationMessage = document.getElementById('validation-message');
                const progressCircle = document.querySelector('.progress-circle-fg');

                // Liveliness check elements
                const blink1Check = document.getElementById('blink1-check');
                const blink2Check = document.getElementById('blink2-check');
                const smileCheck = document.getElementById('smile-check');

                // Get the return URL from the query parameter
                const urlParams = new URLSearchParams(window.location.search);
                const returnUrl = urlParams.get('return_url') || '/admin/voters';

                // Registration state
                let registrationState = {
                    currentStep: 0, // 0: ready, 1: positioning, 2: blink once, 3: blink twice, 4: smile, 5: complete
                    captures: [],
                    validationAttempts: 0,
                    maxValidationAttempts: 3,
                    blinkCount: 0,
                    lastBlinkTime: 0,
                    smileDetected: false
                };

                // Start webcam
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: 400,
                            height: 400,
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

                const modelPath = 'https://justadudewhohacks.github.io/face-api.js/models';

                // Load face-api models
                try {
                    await Promise.all([
                        faceapi.nets.ssdMobilenetv1.loadFromUri(modelPath),
                        faceapi.nets.faceLandmark68Net.loadFromUri(modelPath),
                        faceapi.nets.faceRecognitionNet.loadFromUri(modelPath),
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

                // Check for glasses or other obstructions
                function checkForObstructions(landmarks) {
                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();

                    // Calculate eye openness (simple ratio of height to width)
                    const leftEyeOpenness = (leftEye[1].y - leftEye[5].y) / (leftEye[3].x - leftEye[0].x);
                    const rightEyeOpenness = (rightEye[1].y - rightEye[5].y) / (rightEye[3].x - rightEye[0].x);

                    return {
                        // hasObstruction: leftEyeOpenness < 0.2 || rightEyeOpenness < 0.2,
                        // message: (leftEyeOpenness < 0.2 || rightEyeOpenness < 0.2) ? "Please remove glasses or other face coverings" : ""
                    };
                }

                // Validate frontal face position
                function validateFrontalFace(landmarks) {
                    const jawline = landmarks.getJawOutline();
                    const nose = landmarks.getNose();
                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();
                    const mouth = landmarks.getMouth();

                    // Calculate center points
                    const faceCenter = {
                        x: (jawline[0].x + jawline[16].x) / 2,
                        y: (jawline[0].y + jawline[16].y) / 2
                    };

                    const eyesCenter = {
                        x: (leftEye[0].x + rightEye[3].x) / 2,
                        y: (leftEye[0].y + rightEye[3].y) / 2
                    };

                    const noseTip = nose[6];
                    const mouthCenter = {
                        x: (mouth[0].x + mouth[6].x) / 2,
                        y: (mouth[0].y + mouth[6].y) / 2
                    };

                    // Calculate ratios for position detection
                    const horizontalRatio = (eyesCenter.x - faceCenter.x) / (jawline[16].x - jawline[0].x);
                    const verticalRatio = (noseTip.y - eyesCenter.y) / (mouthCenter.y - eyesCenter.y);

                    // Determine if face is frontal
                    const isFrontal = Math.abs(horizontalRatio) < 0.1 && verticalRatio > 0.4 && verticalRatio < 0.8;

                    return {
                        isValid: isFrontal,
                        message: isFrontal ? "" : "Please look straight at the camera"
                    };
                }

                // Check for blinking
                function checkBlinking(landmarks, previousLandmarks) {
                    if (!previousLandmarks) return false;

                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();
                    const prevLeftEye = previousLandmarks.getLeftEye();
                    const prevRightEye = previousLandmarks.getRightEye();

                    // Calculate current eye openness
                    const leftEyeOpenness = (leftEye[1].y - leftEye[5].y) / (leftEye[3].x - leftEye[0].x);
                    const rightEyeOpenness = (rightEye[1].y - rightEye[5].y) / (rightEye[3].x - rightEye[0].x);

                    // Calculate previous eye openness
                    const prevLeftOpenness = (prevLeftEye[1].y - prevLeftEye[5].y) / (prevLeftEye[3].x - prevLeftEye[0].x);
                    const prevRightOpenness = (prevRightEye[1].y - prevRightEye[5].y) / (prevRightEye[3].x - prevRightEye[0].x);

                    // Check if eyes were more open before
                    const blinkDetected =
                        (leftEyeOpenness < prevLeftOpenness * 0.5 && rightEyeOpenness < prevRightOpenness * 0.5) ||
                        (leftEyeOpenness < 0.2 && rightEyeOpenness < 0.2);

                    return blinkDetected;
                }

                // Check for smiling
                function checkSmiling(expressions) {
                    return expressions.happy > 0.8;
                }

                // Update circular progress
                function updateProgress(percent) {
                    const circumference = 2 * Math.PI * 45;
                    const offset = circumference - (percent / 100) * circumference;
                    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                    progressCircle.style.strokeDashoffset = offset;
                }

                // Main detection function
                let previousLandmarks = null;
                async function detectFace() {
                    try {
                        const detections = await faceapi.detectSingleFace(video)
                            .withFaceLandmarks()
                            .withFaceDescriptor()
                            .withFaceExpressions();

                        if (detections) {
                            const { detection, landmarks, descriptor, expressions } = detections;
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

                            // Check for obstructions
                            const obstructionCheck = checkForObstructions(landmarks);
                            if (obstructionCheck.hasObstruction) {
                                validationMessage.textContent = obstructionCheck.message;
                                validationMessage.style.color = "#ff5722";
                                return null;
                            }

                            // Validate face position
                            const positionCheck = validateFrontalFace(landmarks);
                            validationMessage.textContent = positionCheck.message;
                            validationMessage.style.color = positionCheck.isValid ? "#4CAF50" : "#ff5722";

                            // Check face size and quality
                            if (faceWidth < 100 || faceHeight < 100) {
                                statusMessage.textContent = "Please move closer to the camera";
                                return null;
                            }
                            else if (qualityScore < 40) {
                                statusMessage.textContent = "Poor image quality. Please improve lighting.";
                                return null;
                            }

                            // Check for blinking (liveliness detection)
                            if (registrationState.currentStep >= 2 && registrationState.currentStep <= 3) {
                                const blinkDetected = checkBlinking(landmarks, previousLandmarks);
                                if (blinkDetected) {
                                    const now = Date.now();
                                    if (now - registrationState.lastBlinkTime > 500) { // Debounce blinks
                                        registrationState.blinkCount++;
                                        registrationState.lastBlinkTime = now;

                                        if (registrationState.currentStep === 2 && registrationState.blinkCount >= 1) {
                                            blink1Check.classList.add('completed');
                                            registrationState.currentStep = 3;
                                            registrationState.blinkCount = 0;
                                            instructions.textContent = "Great! Now blink twice";
                                        }
                                        else if (registrationState.currentStep === 3 && registrationState.blinkCount >= 2) {
                                            blink2Check.classList.add('completed');
                                            registrationState.currentStep = 4;
                                            instructions.textContent = "Perfect! Now please smile";
                                        }
                                    }
                                }
                            }

                            // Check for smiling (liveliness detection)
                            if (registrationState.currentStep === 4 && !registrationState.smileDetected) {
                                const smiling = checkSmiling(expressions);
                                if (smiling) {
                                    smileCheck.classList.add('completed');
                                    registrationState.smileDetected = true;
                                    instructions.textContent = "Thank you! Capturing your face now";
                                    setTimeout(() => {
                                        registrationState.currentStep = 5;
                                        processRegistration();
                                    }, 1000);
                                }
                            }

                            previousLandmarks = landmarks;

                            return {
                                detections,
                                qualityScore,
                                isValid: positionCheck.isValid && !obstructionCheck.hasObstruction
                            };
                        } else {
                            statusMessage.textContent = "Face not detected. Please position your face in the circle.";
                            validationMessage.textContent = "";
                            return null;
                        }
                    } catch (error) {
                        console.error("Detection error:", error);
                        statusMessage.textContent = "Error detecting face. Please try again.";
                        validationMessage.textContent = "";
                        return null;
                    }
                }

                // Capture face image
                async function captureFace() {
                    const result = await detectFace();
                    if (!result || !result.isValid || result.qualityScore < 40) {
                        return {
                            success: false,
                            message: "Please adjust your position and try again"
                        };
                    }

                    // Create canvas for capture
                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');

                    // Draw circular mask
                    ctx.beginPath();
                    ctx.arc(
                        canvas.width/2,
                        canvas.height/2,
                        Math.min(canvas.width, canvas.height)/2,
                        0,
                        Math.PI*2
                    );
                    ctx.closePath();
                    ctx.clip();

                    // Draw the video frame
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Store capture
                    registrationState.captures.push({
                        image: canvas.toDataURL("image/jpeg", 0.9),
                        quality: result.qualityScore,
                        descriptor: Array.from(result.detections.descriptor)
                    });

                    return { success: true };
                }

                // Process registration steps
                async function processRegistration() {
                    if (registrationState.currentStep === 0) {
                        // Start registration
                        registrationState.currentStep = 1;
                        captureButton.textContent = "Capturing...";
                        captureButton.style.backgroundColor = "orange";
                        captureButton.style.pointerEvents = "none";
                        updateProgress(0);
                        instructions.textContent = "Please position your face in the circle";

                        // Wait for user to position face
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        registrationState.currentStep = 2;
                        instructions.textContent = "Please blink once";
                        return;
                    }

                    if (registrationState.currentStep === 5) {
                        // Capture current image
                        const { success, message } = await captureFace();

                        if (!success) {
                            registrationState.validationAttempts++;

                            if (registrationState.validationAttempts >= registrationState.maxValidationAttempts) {
                                statusMessage.textContent = "Could not capture valid image after multiple attempts";
                                captureButton.textContent = "Try Again";
                                captureButton.style.backgroundColor = "red";
                                captureButton.style.pointerEvents = "auto";
                                return;
                            }

                            // Wait before retrying
                            await new Promise(resolve => setTimeout(resolve, 1000));
                            return await processRegistration();
                        }

                        // Reset validation attempts after successful capture
                        registrationState.validationAttempts = 0;

                        // Update progress
                        updateProgress(100);

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
                        validationMessage.textContent = "";

                        // Prepare the data to send
                        const registrationData = {
                            user_id: captureButton.getAttribute("data-user-id"),
                            captures: registrationState.captures.map(capture => ({
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
                            instructions.textContent = "Thank you for completing face registration";
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
                    if (registrationState.currentStep === 0) {
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
