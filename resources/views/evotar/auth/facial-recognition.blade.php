<x-app-layout mainClass="flex" page_title="- Face Verification">
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

            .verification-result {
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin: 20px 0;
                padding: 15px;
                border-radius: 5px;
                display: none;
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

            .match-counter {
                text-align: center;
                font-size: 16px;
                margin: 10px 0;
            }    .quality-indicators {
                     display: flex;
                     justify-content: space-between;
                     margin: 10px 0;
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
        </style>

        <div id="container">
            <video id="video-feed" height="560" width="720" autoplay></video>
            <div id="face-guide"></div>
        </div>

        <p id="status-message">Initializing camera...</p>

        <div class="quality-indicators">
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
            Successful matches: <span id="match-count">0</span>/10 |
            Failed attempts: <span id="fail-count">0</span>/10
        </div>

        <div id="verification-result" class="verification-result"></div>

        <script src="{{ asset('storage/js/face-api.min.js') }}"></script>
        <script>
            // URLs for redirection
            const voterLoginUrl = "{{ route('voter.login') }}";
            const logoutUrl = "{{ route('logout') }}";

            (async () => {
                const video = document.getElementById('video-feed');
                const statusMessage = document.getElementById('status-message');
                const verificationResult = document.getElementById('verification-result');
                const matchCountElement = document.getElementById('match-count');
                const failCountElement = document.getElementById('fail-count');
                const brightnessValue = document.getElementById('brightness-value');
                const contrastValue = document.getElementById('contrast-value');
                const sharpnessValue = document.getElementById('sharpness-value');
                const similarityValue = document.getElementById('similarity-value');

                // Strict verification parameters
                const requiredMatches = 10;
                const maxFailAttempts = 10;
                const minSimilarity = 0.65; // 90% similarity required
                const minBrightness = 0.1; // 0-1 scale (50%)
                const maxBrightness = 0.6; // Avoid overexposure
                const minContrast = 0.1; // 0-1 scale
                const minSharpness = 0.7; // 0-1 scale
                const minFaceWidth = 150; // Minimum face width in pixels
                const minFaceHeight = 150; // Minimum face height in pixels

                // State variables
                let matchCount = 0;
                let failCount = 0;
                let verificationInterval;
                let isProcessing = false;

                // Load registered face descriptors
                let registeredDescriptors = [];
                let registeredLabels = [];

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
                    statusMessage.textContent = "Camera ready. Positioning your face in the circle...";
                } catch (error) {
                    statusMessage.textContent = "Camera access denied! Please enable camera permissions.";
                    console.error("Camera error:", error);
                    return;
                }

                const modelPath = "storage/models";

                // Load face-api models
                try {
                    await Promise.all([
                        faceapi.nets.ssdMobilenetv1.loadFromUri('storage/models'),
                        faceapi.nets.faceLandmark68Net.loadFromUri('storage/models'),
                        faceapi.nets.faceRecognitionNet.loadFromUri('storage/models'),
                        faceapi.nets.ageGenderNet.loadFromUri('storage/models'),
                        faceapi.nets.faceExpressionNet.loadFromUri('storage/models'),

                    ]);

                    // Start verification process
                    startVerificationProcess();
                } catch (error) {
                    statusMessage.textContent = "Failed to load face detection models!";
                    console.error("Model loading error:", error);

                }

                // Calculate image sharpness (edge detection)
                function calculateSharpness(imageData) {
                    const width = imageData.width;
                    const height = imageData.height;
                    const data = imageData.data;

                    // Convert to grayscale first
                    const gray = new Array(width * height);
                    for (let i = 0, j = 0; i < data.length; i += 4, j++) {
                        gray[j] = 0.299 * data[i] + 0.587 * data[i+1] + 0.114 * data[i+2];
                    }

                    // Simple edge detection (Sobel operator)
                    let edgeStrength = 0;
                    for (let y = 1; y < height-1; y++) {
                        for (let x = 1; x < width-1; x++) {
                            const idx = y * width + x;
                            const gx = -gray[idx-1-width] + gray[idx+1-width]
                                -2*gray[idx-1] + 2*gray[idx+1]
                                -gray[idx-1+width] + gray[idx+1+width];
                            const gy = -gray[idx-1-width] - 2*gray[idx-width] - gray[idx+1-width]
                                + gray[idx-1+width] + 2*gray[idx+width] + gray[idx+1+width];
                            edgeStrength += Math.sqrt(gx*gx + gy*gy);
                        }
                    }

                    // Normalize (empirically determined values)
                    const sharpness = Math.min(1, edgeStrength / (width * height * 10));
                    return sharpness;
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

                    // Calculate sharpness
                    const sharpness = calculateSharpness(imageData);

                    // Normalize values (0-1)
                    brightness = brightness / 255;
                    contrast = contrast / 255;

                    return {
                        brightness: brightness,
                        contrast: contrast,
                        sharpness: sharpness
                    };
                }

                // Update quality indicators with color coding
                function updateQualityIndicators(quality, similarity) {
                    // Brightness
                    brightnessValue.textContent = (quality.brightness * 100).toFixed(0) + '%';
                    brightnessValue.className = quality.brightness >= minBrightness && quality.brightness <= maxBrightness
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';

                    // Contrast
                    contrastValue.textContent = (quality.contrast * 100).toFixed(0) + '%';
                    contrastValue.className = quality.contrast >= minContrast
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';

                    // Sharpness
                    sharpnessValue.textContent = (quality.sharpness * 100).toFixed(0) + '%';
                    sharpnessValue.className = quality.sharpness >= minSharpness
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';

                    // Similarity
                    similarityValue.textContent = (similarity * 100).toFixed(0) + '%';
                    similarityValue.className = similarity >= minSimilarity
                        ? 'quality-value quality-good'
                        : 'quality-value quality-bad';
                }

                // Find best match among registered faces
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

                // Check if all quality metrics are met
                function checkQualityRequirements(quality) {
                    return (
                        quality.brightness >= minBrightness &&
                        quality.brightness <= maxBrightness &&
                        quality.contrast >= minContrast &&
                        quality.sharpness >= minSharpness
                    );
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

                                // Get face region for quality check
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

                                if (!faceSizeOK) {
                                    statusMessage.textContent = "Please move closer to the camera";
                                    isProcessing = false;
                                    return;
                                }
                                else if (!qualityOK) {
                                    statusMessage.textContent = "Poor image quality. Please adjust lighting.";
                                    isProcessing = false;
                                    return;
                                }

                                if (match.label !== "unknown" && allConditionsMet) {
                                    matchCount++;
                                    failCount = 0; // Reset fail count on successful match
                                    statusMessage.textContent = `Strong match found (${match.label}) - ${(similarity * 100).toFixed(1)}% similarity`;

                                    // Update counters display
                                    matchCountElement.textContent = matchCount;
                                    failCountElement.textContent = failCount;

                                    if (matchCount >= requiredMatches) {
                                        clearInterval(verificationInterval);
                                        verificationResult.textContent = "High Confidence Verification Successful!";
                                        verificationResult.className = "verification-result success";
                                        verificationResult.style.display = "block";

                                        // Update session and redirect
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

                                        window.location.href = voterLoginUrl;
                                    }
                                } else {
                                    matchCount = 0;
                                    failCount++;

                                    // Update counters display
                                    matchCountElement.textContent = matchCount;
                                    failCountElement.textContent = failCount;

                                    if (!similarityOK) {
                                        statusMessage.textContent = `Insufficient match (${(similarity * 100).toFixed(1)}% similarity)`;
                                    } else {
                                        statusMessage.textContent = "Verification conditions not met";
                                    }

                                    if (failCount >= maxFailAttempts) {
                                        clearInterval(verificationInterval);
                                        verificationResult.textContent = "Too many failed attempts";
                                        verificationResult.className = "verification-result failure";
                                        verificationResult.style.display = "block";

                                        // Send logout request via fetch
                                        fetch(logoutUrl, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            }
                                        })
                                            .then(response => {
                                                if (response.ok) {
                                                    window.location.href = voterLoginUrl;
                                                } else {
                                                    throw new Error('Logout failed');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Logout error:', error);
                                                window.location.href = voterLoginUrl; // Fallback redirect
                                            });
                                    }
                                }
                            } else {
                                statusMessage.textContent = "Face not detected. Please position your face in the circle.";
                            }
                        } catch (error) {
                            console.error("Verification error:", error);
                            statusMessage.textContent = "Error during verification";
                        } finally {
                            isProcessing = false;
                        }
                    }, 1000); // Check every second
                }
            })();
        </script>
    </x-slot>
</x-app-layout>
