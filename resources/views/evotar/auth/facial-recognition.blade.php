<x-app-layout mainClass="flex" page_title="- Face Verification">
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
                /*display: none;*/
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

            .quality-indicators {
                justify-content: space-between;
                margin: 10px 0;
                display: none;
            }

            .quality-item {
                text-align: center;
                flex: 1;
            }

            .quality-value {
                font-weight: bold;
            }

            .quality-good { color: green; }
            .quality-warning { color: orange; }
            .quality-bad { color: red; }

            .match-counter {
                text-align: center;
                font-size: 16px;
                margin: 10px 0;
                display: none;
            }

            .verification-result {
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin: 20px 0;
                padding: 15px;
                border-radius: 5px;
            }

            .success {
                background-color: #4CAF50;
                color: white;
            }

            .failure {
                background-color: #f44336;
                color: white;
            }

            .verification-in-progress {
                background-color: #2196F3;
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
        <div class="validation-message hidden" id="validation-message"></div>
        <p id="status-message">Initializing camera...</p>

        <div class="quality-indicators hidden">
            <div class="quality-item">
                <div>Brightness</div>
                <div id="brightness-value" class="quality-value">--</div>
            </div>
            <div class="quality-item">
                <div>Contrast</div>
                <div id="contrast-value" class="quality-value">--</div>
            </div>
            <div class="quality-item">
                <div>Sharpness</div>
                <div id="sharpness-value" class="quality-value">--</div>
            </div>
            <div class="quality-item">
                <div>Similarity</div>
                <div id="similarity-value" class="quality-value">--</div>
            </div>
        </div>

        <div id="match-counter" class="match-counter">
            Successful matches: <span id="match-count">0</span>/<span id="required-matches">10</span> |
            Failed attempts: <span id="fail-count">0</span>/<span id="max-fail-attempts">10</span>
        </div>

        <div id="verification-result" class="verification-result"></div>

        <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
        <script>
            const voterLoginUrl = "{{ route('voter.login')}}";
            const logoutUrl = "{{ route('logout') }}";

            (async () => {
                const video = document.getElementById('video-feed');
                const statusMessage = document.getElementById('status-message');
                const instructions = document.getElementById('instructions');
                const validationMessage = document.getElementById('validation-message');
                const verificationResult = document.getElementById('verification-result');
                const matchCountElement = document.getElementById('match-count');
                const failCountElement = document.getElementById('fail-count');
                const brightnessValue = document.getElementById('brightness-value');
                const contrastValue = document.getElementById('contrast-value');
                const sharpnessValue = document.getElementById('sharpness-value');
                const similarityValue = document.getElementById('similarity-value');
                const progressCircle = document.querySelector('.progress-circle-fg');

                // Verification parameters
                const requiredMatches = 3;
                const maxFailAttempts = 20;
                const minSimilarity = 0.60;
                const minBrightness = 0.1;
                const maxBrightness = 0.6;
                const minContrast = 0.1;
                const minSharpness = 0.7;
                const minFaceWidth = 100; // Adjusted for smaller container
                const minFaceHeight = 100;

                // State variables
                let matchCount = 0;
                let failCount = 0;
                let verificationInterval;
                let isProcessing = false;
                let registeredDescriptors = [];
                let registeredLabels = [];

                // Start webcam
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: { ideal: 400 },
                            height: { ideal: 400 },
                            facingMode: 'user'
                        }
                    });
                    video.srcObject = stream;
                    statusMessage.textContent = "Camera ready. Positioning your face in the circle...";
                    instructions.textContent = "Please position your face in the circle and look straight at the camera";
                } catch (error) {
                    statusMessage.textContent = "Camera access denied! Please enable camera permissions.";
                    console.error("Camera error:", error);
                    return;
                }

                // Load registered face descriptors
                try {
                    const response = await fetch("{{ route('api.face.get-descriptors') }}", {
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        registeredDescriptors = data.descriptors.map(desc => new Float32Array(desc));
                        registeredLabels = data.labels || [];
                    } else {
                        throw new Error("Failed to load registered face data");
                    }
                } catch (error) {
                    statusMessage.textContent = "Error: " + error.message;
                    console.error("Descriptor loading error:", error);
                    return;
                }

                // Load face-api models
                const modelPath = 'https://justadudewhohacks.github.io/face-api.js/models';
                try {
                    await Promise.all([
                        faceapi.nets.ssdMobilenetv1.loadFromUri(modelPath),
                        faceapi.nets.faceLandmark68Net.loadFromUri(modelPath),
                        faceapi.nets.faceRecognitionNet.loadFromUri(modelPath),
                    ]);
                    statusMessage.textContent = "Models loaded. Starting verification...";
                } catch (error) {
                    statusMessage.textContent = "Failed to load face detection models!";
                    console.error("Model loading error:", error);
                    return;
                }

                // Calculate image sharpness
                function calculateSharpness(imageData) {
                    const width = imageData.width;
                    const height = imageData.height;
                    const data = imageData.data;
                    const gray = new Array(width * height);
                    for (let i = 0, j = 0; i < data.length; i += 4, j++) {
                        gray[j] = 0.299 * data[i] + 0.587 * data[i + 1] + 0.114 * data[i + 2];
                    }
                    let edgeStrength = 0;
                    for (let y = 1; y < height - 1; y++) {
                        for (let x = 1; x < width - 1; x++) {
                            const idx = y * width + x;
                            const gx = -gray[idx - 1 - width] + gray[idx + 1 - width]
                                - 2 * gray[idx - 1] + 2 * gray[idx + 1]
                                - gray[idx - 1 + width] + gray[idx + 1 + width];
                            const gy = -gray[idx - 1 - width] - 2 * gray[idx - width] - gray[idx + 1 - width]
                                + gray[idx - 1 + width] + 2 * gray[idx + width] + gray[idx + 1 + width];
                            edgeStrength += Math.sqrt(gx * gx + gy * gy);
                        }
                    }
                    return Math.min(1, edgeStrength / (width * height * 10));
                }

                // Calculate image quality metrics
                function calculateQuality(imageData) {
                    let brightness = 0;
                    let contrast = 0;
                    const data = imageData.data;
                    const pixels = data.length / 4;
                    for (let i = 0; i < data.length; i += 4) {
                        brightness += (data[i] + data[i + 1] + data[i + 2]) / 3;
                    }
                    brightness /= pixels;
                    for (let i = 0; i < data.length; i += 4) {
                        const luminance = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        contrast += Math.pow(luminance - brightness, 2);
                    }
                    contrast = Math.sqrt(contrast / pixels);
                    const sharpness = calculateSharpness(imageData);
                    return {
                        brightness: brightness / 255,
                        contrast: contrast / 255,
                        sharpness: sharpness
                    };
                }

                // Update quality indicators
                function updateQualityIndicators(quality, similarity) {
                    brightnessValue.textContent = (quality.brightness * 100).toFixed(0) + '%';
                    brightnessValue.className = quality.brightness >= minBrightness && quality.brightness <= maxBrightness
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';
                    contrastValue.textContent = (quality.contrast * 100).toFixed(0) + '%';
                    contrastValue.className = quality.contrast >= minContrast
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';
                    sharpnessValue.textContent = (quality.sharpness * 100).toFixed(0) + '%';
                    sharpnessValue.className = quality.sharpness >= minSharpness
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';
                    similarityValue.textContent = (similarity * 100).toFixed(0) + '%';
                    similarityValue.className = similarity >= minSimilarity
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';
                }

                // Find best match
                function findBestMatch(descriptor) {
                    let bestMatch = { distance: 1, label: "unknown" };
                    for (let i = 0; i < registeredDescriptors.length; i++) {
                        const distance = faceapi.euclideanDistance(descriptor, registeredDescriptors[i]);
                        if (distance < bestMatch.distance) {
                            bestMatch = {
                                distance: distance,
                                label: registeredLabels[i] || "user_" + i,
                                similarity: 1 - distance
                            };
                        }
                    }
                    return bestMatch;
                }

                // Check quality requirements
                function checkQualityRequirements(quality) {
                    return (
                        quality.brightness >= minBrightness &&
                        quality.brightness <= maxBrightness &&
                        quality.contrast >= minContrast &&
                        quality.sharpness >= minSharpness
                    );
                }

                // Update progress circle
                function updateProgress(percent) {
                    const circumference = 2 * Math.PI * 45;
                    const offset = circumference - (percent / 100) * circumference;
                    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                    progressCircle.style.strokeDashoffset = offset;
                }

                // Main verification process
                function startVerificationProcess() {
                    verificationInterval = setInterval(async () => {
                        if (isProcessing) return;
                        isProcessing = true;

                        try {
                            const detections = await faceapi.detectSingleFace(video)
                                .withFaceLandmarks()
                                .withFaceDescriptor();

                            if (detections) {
                                const { detection, descriptor } = detections;
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

                                // Find best match
                                const match = findBestMatch(descriptor);
                                const similarity = 1 - match.distance;

                                // Update quality indicators
                                updateQualityIndicators(quality, similarity);

                                // Check all requirements
                                const faceSizeOK = faceWidth >= minFaceWidth && faceHeight >= minFaceHeight;
                                const qualityOK = checkQualityRequirements(quality);
                                const similarityOK = similarity >= minSimilarity;
                                const allConditionsMet = faceSizeOK && qualityOK && similarityOK;

                                // Update progress based on match count
                                updateProgress((matchCount / requiredMatches) * 100);

                                if (!faceSizeOK) {
                                    statusMessage.textContent = "Please move closer to the camera";
                                    validationMessage.textContent = "Face too small";
                                    isProcessing = false;
                                    return;
                                } else if (!qualityOK) {
                                    statusMessage.textContent = "Poor image quality. Please adjust lighting.";
                                    validationMessage.textContent = "Adjust lighting or position";
                                    isProcessing = false;
                                    return;
                                }

                                if (match.label !== "unknown" && allConditionsMet) {
                                    matchCount++;
                                    failCount = 0;
                                    statusMessage.textContent = `Strong match found (${match.label}) - ${(similarity * 100).toFixed(1)}% similarity`;
                                    validationMessage.textContent = "";

                                    matchCountElement.textContent = matchCount;
                                    failCountElement.textContent = failCount;

                                    if (matchCount >= requiredMatches) {
                                        clearInterval(verificationInterval);
                                        verificationResult.textContent = "High Confidence Verification Successful!";
                                        verificationResult.className = "verification-result success";
                                        verificationResult.style.display = "block";
                                        updateProgress(100);

                                        await fetch("{{ route('update.face.verified') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                face_verified: true,
                                                confidence: similarity
                                            })
                                        });

                                        setTimeout(() => {
                                            window.location.href = voterLoginUrl;
                                        }, 1000);
                                    }
                                } else {
                                    matchCount = 0;
                                    failCount++;
                                    matchCountElement.textContent = matchCount;
                                    failCountElement.textContent = failCount;

                                    if (!similarityOK) {
                                        statusMessage.textContent = `Insufficient match (${(similarity * 100).toFixed(1)}% similarity)`;
                                        validationMessage.textContent = "Face not recognized";
                                    } else {
                                        statusMessage.textContent = "Verification conditions not met";
                                        validationMessage.textContent = "Conditions not met";
                                    }

                                    if (failCount >= maxFailAttempts) {
                                        clearInterval(verificationInterval);
                                        verificationResult.textContent = "Too many failed attempts";
                                        verificationResult.className = "verification-result failure";
                                        verificationResult.style.display = "block";
                                        updateProgress(0);

                                        fetch(logoutUrl, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            }
                                        })
                                            .then(response => {
                                                window.location.href = voterLoginUrl;
                                            })
                                            .catch(error => {
                                                console.error('Logout error:', error);
                                                window.location.href = voterLoginUrl;
                                            });
                                    }
                                }
                            } else {
                                statusMessage.textContent = "Face not detected. Please position your face in the circle.";
                                validationMessage.textContent = "No face detected";
                                updateProgress(0);
                            }
                        } catch (error) {
                            console.error("Verification error:", error);
                            statusMessage.textContent = "Error during verification";
                            validationMessage.textContent = "";
                        } finally {
                            isProcessing = false;
                        }
                    }, 1000);
                }

                // Start verification
                startVerificationProcess();
            })();
        </script>
    </x-slot>
</x-app-layout>
