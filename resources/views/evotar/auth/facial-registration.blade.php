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

            /* Countdown styles */
            #countdown-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 30;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
            }

            #countdown-text {
                font-size: 80px;
                color: white;
                font-weight: bold;
            }

            /* Loading overlay styles */
            #loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 40;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
            }

            #loading-spinner {
                border: 5px solid #f3f3f3;
                border-top: 5px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
                margin-bottom: 15px;
            }

            #loading-text {
                color: white;
                font-size: 18px;
                font-weight: bold;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Quality indicators */
            .quality-indicators {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin: 10px 0;
            }

            .quality-indicator {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .quality-indicator .label {
                font-size: 12px;
                color: #666;
                margin-bottom: 5px;
            }

            .quality-indicator .value {
                font-size: 14px;
                font-weight: bold;
            }

            .quality-indicator .good {
                color: #4CAF50;
            }

            .quality-indicator .warning {
                color: #FFC107;
            }

            .quality-indicator .bad {
                color: #F44336;
            }

            /* Status indicators */
            .status-container {
                display: flex;
                justify-content: center;
                margin: 15px 0;
                gap: 15px;
            }

            .status-item {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .status-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
            }

            .status-loading {
                background-color: #FFC107;
                animation: pulse 1.5s infinite;
            }

            .status-ready {
                background-color: #4CAF50;
            }

            .status-error {
                background-color: #F44336;
            }

            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
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
            <div id="countdown-overlay">
                <div id="countdown-text"></div>
            </div>
            <div id="loading-overlay">
                <div id="loading-spinner"></div>
                <div id="loading-text">Processing your registration...</div>
            </div>
        </div>

        <div id="instructions">Please position your face in the circle and look straight at the camera</div>

        <div class="quality-indicators">
            <div class="quality-indicator">
                <div class="label">Brightness</div>
                <div class="value" id="brightness-value">--</div>
            </div>
            <div class="quality-indicator">
                <div class="label">Contrast</div>
                <div class="value" id="contrast-value">--</div>
            </div>
            <div class="quality-indicator">
                <div class="label">Sharpness</div>
                <div class="value" id="sharpness-value">--</div>
            </div>
        </div>

        <div class="status-container">
            <div class="status-item" id="camera-status">
                <div class="status-indicator status-loading"></div>
                <span>Camera</span>
            </div>
            <div class="status-item" id="model-status">
                <div class="status-indicator status-loading"></div>
                <span>AI Models</span>
            </div>
            <div class="status-item" id="system-status">
                <div class="status-indicator status-loading"></div>
                <span>System</span>
            </div>
        </div>

        <div class="validation-message" id="validation-message"></div>
        <p id="status-message">Initializing camera...</p>
        <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

        <script>
            (async () => {
                // Get DOM elements
                const video = document.getElementById('video-feed');
                const statusMessage = document.getElementById('status-message');
                const instructions = document.getElementById('instructions');
                const validationMessage = document.getElementById('validation-message');
                const progressCircle = document.querySelector('.progress-circle-fg');
                const countdownOverlay = document.getElementById('countdown-overlay');
                const countdownText = document.getElementById('countdown-text');
                const loadingOverlay = document.getElementById('loading-overlay');
                const loadingText = document.getElementById('loading-text');
                const brightnessValue = document.getElementById('brightness-value');
                const contrastValue = document.getElementById('contrast-value');
                const sharpnessValue = document.getElementById('sharpness-value');

                // Get the return URL from query parameters
                const urlParams = new URLSearchParams(window.location.search);
                const returnUrl = urlParams.get('return_url') || '/admin/dashboard'; // Default fallback URL
                let totalScore = 0;

                // Registration state
                let registrationState = {
                    currentStep: 0, // 0: ready, 1: positioning, 2: blink once, 3: blink twice, 4: smile, 5: complete
                    captures: [],
                    validationAttempts: 0,
                    blinkCount: 0,
                    lastBlinkTime: 0,
                    maxValidationAttempts: 3,
                    faceDetected: false,
                    countdownActive: false,
                    detectionActive: true,
                    qualityMetrics: {
                        brightness: 0,
                        contrast: 0,
                        sharpness: 0
                    },
                    systemReady: false,
                    cameraReady: false,
                    modelsLoaded: false,
                    previousLandmarks: null
                };

                // Quality thresholds
                const qualityThresholds = {
                    minBrightness: 0.2,    // 20%
                    maxBrightness: 0.8,    // 80%
                    minContrast: 0.15,    // 15%
                    minSharpness: 0.03,    // 3%
                    minFaceWidth: 100,
                    minFaceHeight: 100
                };

                // Initialize camera and models
                await initializeCamera();
                await loadModels();

                // Start detection loop
                setInterval(detectFace, 500);

                // Helper functions
                function updateProgress(percent) {
                    const circumference = 2 * Math.PI * 45;
                    const offset = circumference - (percent / 100) * circumference;
                    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                    progressCircle.style.strokeDashoffset = offset;
                }

                async function showCountdown() {
                    if (registrationState.countdownActive) return;

                    registrationState.countdownActive = true;
                    countdownOverlay.style.opacity = 1;

                    for (let i = 3; i > 0; i--) {
                        countdownText.textContent = i;
                        await new Promise(resolve => setTimeout(resolve, 1000));
                    }

                    countdownOverlay.style.opacity = 0;
                    registrationState.countdownActive = false;

                    if (registrationState.currentStep === 0) {
                        await processRegistration();
                    }
                }

                function showLoading(message) {
                    loadingText.textContent = message;
                    loadingOverlay.style.opacity = 1;
                    registrationState.detectionActive = false;
                }

                function hideLoading() {
                    loadingOverlay.style.opacity = 0;
                    registrationState.detectionActive = true;
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

                // Calculate image quality metrics
                function calculateQuality(imageData) {
                    let brightness = 0;
                    let contrast = 0;
                    const data = imageData.data;
                    const pixels = data.length / 4;
                    const sampleStep = 4; // Sample every 4th pixel for performance

                    // Calculate brightness (sampled)
                    let sampledPixels = 0;
                    for (let i = 0; i < data.length; i += 4 * sampleStep) {
                        brightness += (data[i] + data[i + 1] + data[i + 2]) / 3;
                        sampledPixels++;
                    }
                    brightness /= sampledPixels;

                    // Calculate contrast (sampled)
                    for (let i = 0; i < data.length; i += 4 * sampleStep) {
                        const luminance = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        contrast += Math.pow(luminance - brightness, 2);
                    }
                    contrast = Math.sqrt(contrast / sampledPixels);

                    // Calculate sharpness using Sobel operator
                    const sharpness = calculateSharpness(imageData);
                    const normBrightness = brightness / 255;
                    const normContrast = contrast / 255;
                    totalScore = (normBrightness + normContrast + sharpness) / 3;

                    return {
                        brightness: brightness / 255,
                        contrast: contrast / 255,
                        sharpness: sharpness
                    };
                }

                // Improved sharpness calculation using Sobel operator
                function calculateSharpness(imageData, sampleStep = 2) {
                    const width = imageData.width;
                    const height = imageData.height;
                    const data = imageData.data;

                    // Convert to grayscale
                    const grayscale = new Array(width * height);
                    for (let y = 0; y < height; y++) {
                        for (let x = 0; x < width; x++) {
                            const idx = (y * width + x) * 4;
                            grayscale[y * width + x] = 0.299 * data[idx] + 0.587 * data[idx + 1] + 0.114 * data[idx + 2];
                        }
                    }

                    let edgeStrength = 0;
                    let edgeCount = 0;

                    // Apply Sobel operator (simplified for performance)
                    for (let y = 1; y < height - 1; y += sampleStep) {
                        for (let x = 1; x < width - 1; x += sampleStep) {
                            const idx = y * width + x;

                            // Horizontal gradient
                            const gx = -grayscale[idx - width - 1] - 2 * grayscale[idx - 1] - grayscale[idx + width - 1] +
                                grayscale[idx - width + 1] + 2 * grayscale[idx + 1] + grayscale[idx + width + 1];

                            // Vertical gradient
                            const gy = -grayscale[idx - width - 1] - 2 * grayscale[idx - width] - grayscale[idx - width + 1] +
                                grayscale[idx + width - 1] + 2 * grayscale[idx + width] + grayscale[idx + width + 1];

                            edgeStrength += Math.sqrt(gx * gx + gy * gy);
                            edgeCount++;
                        }
                    }

                    // Normalize sharpness (empirically determined scaling)
                    const sharpness = edgeStrength / (edgeCount * 1000);
                    return Math.min(1, Math.max(0, sharpness));
                }

                // Update quality indicators
                function updateQualityIndicators(quality) {
                    brightnessValue.textContent = (quality.brightness * 100).toFixed(0) + '%';
                    brightnessValue.className = quality.brightness >= qualityThresholds.minBrightness &&
                    quality.brightness <= qualityThresholds.maxBrightness
                        ? 'value good'
                        : 'value bad';

                    contrastValue.textContent = (quality.contrast * 100).toFixed(0) + '%';
                    contrastValue.className = quality.contrast >= qualityThresholds.minContrast
                        ? 'value good'
                        : 'value bad';

                    sharpnessValue.textContent = (quality.sharpness * 100).toFixed(0) + '%';
                    sharpnessValue.className = quality.sharpness >= qualityThresholds.minSharpness
                        ? 'value good'
                        : 'value bad';
                }

                // Check quality requirements
                function checkQualityRequirements(quality) {
                    return (
                        quality.brightness >= qualityThresholds.minBrightness &&
                        quality.brightness <= qualityThresholds.maxBrightness &&
                        quality.contrast >= qualityThresholds.minContrast &&
                        quality.sharpness >= qualityThresholds.minSharpness
                    );
                }

                // Capture face image
                async function captureFace() {
                    try {
                        const detections = await faceapi.detectSingleFace(video)
                            .withFaceLandmarks()
                            .withFaceDescriptor();

                        if (!detections) {
                            return { success: false, message: "Face not detected" };
                        }

                        // Create canvas and get image data
                        const canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Get base64 image with proper format
                        let imageData = canvas.toDataURL("image/jpeg", 0.9);

                        // Verify the image data
                        if (!imageData || imageData.length < 100) { // Simple length check
                            throw new Error("Invalid image data captured");
                        }

                        // Store capture with quality score
                        registrationState.captures.push({
                            image: imageData,
                            quality: totalScore,
                            descriptor: Array.from(detections.descriptor)
                        });

                        return { success: true };
                    } catch (error) {
                        console.error("Capture error:", error);
                        return {
                            success: false,
                            message: error.message || "Error capturing image"
                        };
                    }
                }

                // Main detection function
                async function detectFace() {
                    if (!registrationState.detectionActive) return;

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

                            // Get face region
                            const faceImage = ctx.getImageData(
                                Math.max(0, box.x - 20),
                                Math.max(0, box.y - 20),
                                Math.min(canvas.width - box.x, box.width + 40),
                                Math.min(canvas.height - box.y, box.height + 40)
                            );

                            // Calculate quality metrics
                            const quality = calculateQuality(faceImage);
                            updateQualityIndicators(quality);

                            // Check face size and quality
                            if (faceWidth < qualityThresholds.minFaceWidth || faceHeight < qualityThresholds.minFaceHeight) {
                                statusMessage.textContent = "Please move closer to the camera";
                                registrationState.faceDetected = false;
                                return;
                            }
                            else if (!checkQualityRequirements(quality)) {
                                statusMessage.textContent = "Poor image quality. Please adjust lighting.";
                                registrationState.faceDetected = false;
                                return;
                            }

                            // If we get here, face is properly detected
                            if (!registrationState.faceDetected && registrationState.currentStep === 0) {
                                registrationState.faceDetected = true;
                                showCountdown();
                            }

                            // Check for blinking
                            if (registrationState.currentStep >= 2 && registrationState.currentStep <= 3) {
                                const blinkDetected = checkBlinking(landmarks, registrationState.previousLandmarks);
                                if (blinkDetected) {
                                    const now = Date.now();
                                    if (now - registrationState.lastBlinkTime > 500) {
                                        registrationState.blinkCount++;
                                        registrationState.lastBlinkTime = now;

                                        if (registrationState.currentStep === 2 && registrationState.blinkCount >= 1) {
                                            registrationState.currentStep = 3;
                                            registrationState.blinkCount = 0;
                                            instructions.textContent = "Great! Now blink twice";
                                        }
                                        else if (registrationState.currentStep === 3 && registrationState.blinkCount >= 2) {
                                            registrationState.currentStep = 4;
                                            instructions.textContent = "Perfect! Now please smile";
                                        }
                                    }
                                }
                            }

                            // Check for smiling
                            if (registrationState.currentStep === 4 && !registrationState.smileDetected) {
                                const smiling = checkSmiling(expressions);
                                if (smiling) {
                                    registrationState.smileDetected = true;
                                    instructions.textContent = "Thank you! Capturing your face now";
                                    setTimeout(() => {
                                        registrationState.currentStep = 5;
                                        processRegistration();
                                    }, 1000);
                                }
                            }

                            registrationState.previousLandmarks = landmarks;
                        } else {
                            statusMessage.textContent = "Face not detected. Please position your face in the circle.";
                            validationMessage.textContent = "";
                            registrationState.faceDetected = false;
                        }
                    } catch (error) {
                        console.error("Detection error:", error);
                        statusMessage.textContent = "Error detecting face. Please try again.";
                        validationMessage.textContent = "";
                        registrationState.faceDetected = false;
                    }
                }

                // Process registration steps
                async function processRegistration() {
                    if (registrationState.currentStep === 0) {
                        registrationState.currentStep = 1;
                        updateProgress(0);
                        instructions.textContent = "Please position your face in the circle";
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        registrationState.currentStep = 2;
                        instructions.textContent = "Please blink once";
                        return;
                    }

                    if (registrationState.currentStep === 5) {
                        const { success } = await captureFace();
                        if (success) {
                            updateProgress(100);
                            await completeRegistration();
                        }
                    }
                }

                // Complete registration process
                async function completeRegistration() {
                    try {
                        showLoading("Processing your registration...");

                        // Prepare the data to send - matching backend expectations
                        const registrationData = {
                            user_id: "{{ $user->id }}",
                            captures: registrationState.captures.map(capture => ({
                                image: capture.image,
                                quality: capture.quality || 0.8, // Default quality if not set
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

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || "Server responded with error");
                        }

                        statusMessage.textContent = "Registration successful!";
                        instructions.textContent = "Thank you for completing face registration";

                        // Show success message before redirect
                        loadingText.textContent = "Registration successful!";
                        await new Promise(resolve => setTimeout(resolve, 2000));

                        window.location.href = returnUrl;
                    } catch (error) {
                        console.error("Registration error:", error);
                        statusMessage.textContent = "Registration failed: " + error.message;
                        hideLoading();
                    }
                }

                // Initialize camera
                async function initializeCamera() {
                    try {
                        statusMessage.textContent = "Initializing camera...";

                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: {
                                width: { ideal: 400 },
                                height: { ideal: 400 },
                                facingMode: 'user',
                                frameRate: { ideal: 15 }
                            }
                        });

                        video.srcObject = stream;

                        await new Promise((resolve, reject) => {
                            video.onloadedmetadata = resolve;
                            video.onerror = reject;
                            setTimeout(() => reject(new Error("Camera initialization timeout")), 10000);
                        });

                        registrationState.cameraReady = true;
                        updateSystemStatus();
                    } catch (error) {
                        console.error("Camera error:", error);
                        statusMessage.textContent = "Camera access denied! Please enable camera permissions.";
                    }
                }

                // Load models
                async function loadModels() {
                    try {
                        statusMessage.textContent = "Loading AI models...";

                        const localModelPath = '{{ asset("storage/models") }}';
                        const cdnModelPath = 'https://justadudewhohacks.github.io/face-api.js/models';

                        await Promise.all([
                            faceapi.nets.ssdMobilenetv1.loadFromUri(localModelPath).catch(() =>
                                faceapi.nets.ssdMobilenetv1.loadFromUri(cdnModelPath)),
                            faceapi.nets.faceLandmark68Net.loadFromUri(localModelPath).catch(() =>
                                faceapi.nets.faceLandmark68Net.loadFromUri(cdnModelPath)),
                            faceapi.nets.faceRecognitionNet.loadFromUri(localModelPath).catch(() =>
                                faceapi.nets.faceRecognitionNet.loadFromUri(cdnModelPath)),
                            faceapi.nets.faceExpressionNet.loadFromUri(localModelPath).catch(() =>
                                faceapi.nets.faceExpressionNet.loadFromUri(cdnModelPath))
                        ]);

                        registrationState.modelsLoaded = true;
                        updateSystemStatus();
                    } catch (error) {
                        console.error("Model loading error:", error);
                        statusMessage.textContent = "Failed to load face detection models!";
                        setTimeout(loadModels, 5000);
                    }
                }

                // Update system status
                function updateSystemStatus() {
                    if (registrationState.cameraReady && registrationState.modelsLoaded) {
                        registrationState.systemReady = true;
                        statusMessage.textContent = "System ready. Position your face in the circle.";
                        instructions.textContent = "Please position your face in the circle and look straight at the camera";
                    }
                }
            })();
        </script>
    </x-slot>
</x-app-layout>
