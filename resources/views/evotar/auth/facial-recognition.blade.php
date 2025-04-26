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

            /* Progress circle styles */
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

            /* Quality indicators */
            .quality-indicators {
                justify-content: center;
                align-content: center;
                align-items: center;
                margin: 10px 0;
            }
            .quality-container {
                display: flex;
                max-width: 500px;
            }

            .quality-item {
                text-align: center;
                flex: 1;
            }

            .quality-value {
                font-weight: bold;
            }

            .quality-good { color: #4CAF50; }
            .quality-warning { color: #FFC107; }
            .quality-bad { color: #F44336; }

            /* Match counter */
            .match-counter {
                text-align: center;
                font-size: 16px;
                margin: 10px 0;
            }

            /* Verification result */
            .verification-result {
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin: 20px 0;
                padding: 15px;
                border-radius: 5px;
                display: none;
            }

            .verification-success {
                background-color: #4CAF50;
                color: white;
            }

            .verification-failure {
                background-color: #f44336;
                color: white;
            }

            .verification-loading {
                background-color: #2196F3;
                color: white;
            }

            /* System status */
            .system-status {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin: 15px 0;
                flex-wrap: wrap;
            }

            .status-item {
                display: flex;
                align-items: center;
                font-size: 14px;
            }

            .status-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin-right: 8px;
            }

            .status-ready {
                background-color: #4CAF50;
            }

            .status-loading {
                background-color: #FFC107;
            }

            .status-error {
                background-color: #F44336;
            }

            /* Loading spinner */
            .loading-spinner {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 3px solid rgba(255,255,255,.3);
                border-radius: 50%;
                border-top-color: #fff;
                animation: spin 1s ease-in-out infinite;
                margin-right: 8px;
                vertical-align: middle;
            }

            #loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.9);
                display: none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            #loading-message {
                margin-top: 20px;
                font-size: 18px;
                font-weight: bold;
                color: #333;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>

        <div id="container">
            <video id="video-feed" autoplay playsinline></video>
            <div id="face-guide"></div>
            <div class="progress-circle">
                <svg viewBox="0 0 100 100">
                    <circle class="progress-circle-bg" cx="50" cy="50" r="45" />
                    <circle class="progress-circle-fg" cx="50" cy="50" r="45" />
                </svg>
            </div>
        </div>

        <div id="loading-overlay">
            <div class="loading-spinner" style="width: 50px; height: 50px;"></div>
            <div id="loading-message">Loading face recognition system...</div>
        </div>

        <div id="instructions">Initializing face verification system...</div>

        <div class="system-status">
            <div class="status-item" id="camera-status">
                <span class="status-indicator status-loading"></span>
                <span>Camera initialization</span>
            </div>
            <div class="status-item" id="model-status">
                <span class="status-indicator status-loading"></span>
                <span>Loading AI models</span>
            </div>
            <div class="status-item" id="descriptor-status">
                <span class="status-indicator status-loading"></span>
                <span>Loading face data</span>
            </div>
            <div class="status-item" id="system-status">
                <span class="status-indicator status-loading"></span>
                <span>System readiness</span>
            </div>
        </div>

        <div class="quality-indicators" style="display: none;">
            <div class="quality-container">
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
            </div>
{{--            <div class="quality-item">--}}
{{--                <div>Similarity</div>--}}
{{--                <div id="similarity-value" class="quality-value">--</div>--}}
{{--            </div>--}}
        </div>

{{--        <div id="match-counter" class="match-counter" style="display: none;">--}}
{{--            Successful matches: <span id="match-count">0</span>/<span id="required-matches">3</span> |--}}
{{--            Failed attempts: <span id="fail-count">0</span>/<span id="max-fail-attempts">20</span>--}}
{{--        </div>--}}

        <div id="verification-result" class="verification-result"></div>
        <p id="status-message">Initializing system components...</p>

        <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
        <script>
            const voterLoginUrl = "{{ route('voter.login')}}";
            const logoutUrl = "{{ route('logout') }}";
            const updateVerifiedUrl = "{{ route('update.face.verified') }}";
            const getDescriptorsUrl = "{{ route('api.face.get-descriptors') }}";

            (async () => {
                // Helper function to safely update DOM elements
                function updateElement(element, value) {
                    try {
                        if (element && element.textContent !== undefined) {
                            element.textContent = value;
                        }
                    } catch (error) {
                        console.error("Error updating element:", error);
                    }
                }

                const openIDB = () => {
                    return new Promise((resolve, reject) => {
                        const request = indexedDB.open('FaceModelsDB', 1);

                        request.onupgradeneeded = (event) => {
                            const db = event.target.result;
                            if (!db.objectStoreNames.contains('models')) {
                                db.createObjectStore('models', { keyPath: 'name' });
                            }
                        };

                        request.onsuccess = () => resolve(request.result);
                        request.onerror = () => reject(request.error);
                    });
                };

                const getCachedModel = async (modelName) => {
                    try {
                        const db = await openIDB();
                        const transaction = db.transaction('models', 'readonly');
                        const store = transaction.objectStore('models');
                        const request = store.get(modelName);

                        return new Promise((resolve, reject) => {
                            request.onsuccess = () => resolve(request.result?.weights);
                            request.onerror = () => reject(null);
                        });
                    } catch (error) {
                        console.error('IndexedDB get error:', error);
                        return null;
                    }
                };

                const cacheModel = async (modelName, model) => {
                    try {
                        const db = await openIDB();
                        const transaction = db.transaction('models', 'readwrite');
                        const store = transaction.objectStore('models');

                        // Extract weights (simplified - may need adjustment for face-api.js)
                        const weights = {
                            name: modelName,
                            weights: model.modelUrl ? model : model.getWeights()
                        };

                        store.put(weights);
                    } catch (error) {
                        console.error('IndexedDB cache error:', error);
                    }
                };

                // Cache DOM elements
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
                const qualityIndicators = document.querySelector('.quality-indicators');
                // const matchCounter = document.getElementById('match-counter');

                // Status indicators
                const cameraStatus = document.getElementById('camera-status');
                const modelStatus = document.getElementById('model-status');
                const descriptorStatus = document.getElementById('descriptor-status');
                const systemStatus = document.getElementById('system-status');

                // Verification parameters
                const requiredMatches = 3;
                const maxFailAttempts = 20;
                const minSimilarity = 0.60;
                const minBrightness = 0.1;
                const maxBrightness = 0.6;
                const minContrast = 0.1;
                const minSharpness = 0.7;
                const minFaceWidth = 100;
                const minFaceHeight = 100;

                // State variables
                let matchCount = 0;
                let failCount = 0;
                let isProcessing = false;
                let registeredDescriptors = [];
                let registeredLabels = [];
                let systemReady = false;
                let cameraReady = false;
                let modelsLoaded = false;
                let descriptorsLoaded = false;
                let verificationActive = false;

                // Update system status
                function updateSystemStatus() {
                    if (cameraReady && modelsLoaded && descriptorsLoaded) {
                        systemReady = true;
                        systemStatus.querySelector('.status-indicator').className = 'status-indicator status-ready';
                        systemStatus.querySelector('span:last-child').textContent = 'System ready';
                        statusMessage.textContent = "System ready. Starting verification...";
                        instructions.textContent = "Please position your face in the circle and look straight at the camera";
                        qualityIndicators.style.display = 'flex';
                        // matchCounter.style.display = 'block';
                        startVerificationProcess();
                    } else {
                        systemStatus.querySelector('.status-indicator').className = 'status-indicator status-loading';
                        systemStatus.querySelector('span:last-child').textContent = 'Waiting for components...';
                    }
                }

                // Start webcam
                async function initializeCamera() {
                    try {
                        statusMessage.textContent = "Initializing camera...";
                        cameraStatus.querySelector('.status-indicator').className = 'status-indicator status-loading';

                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: {
                                width: { ideal: 400 },
                                height: { ideal: 400 },
                                facingMode: 'user',
                                frameRate: { ideal: 15 }
                            }
                        });

                        video.srcObject = stream;

                        // Wait for video to be ready
                        await new Promise((resolve, reject) => {
                            video.onloadedmetadata = resolve;
                            video.onerror = reject;
                            setTimeout(() => reject(new Error("Camera initialization timeout")), 10000);
                        });

                        cameraReady = true;
                        cameraStatus.querySelector('.status-indicator').className = 'status-indicator status-ready';
                        cameraStatus.querySelector('span:last-child').textContent = 'Camera ready';
                        updateSystemStatus();
                    } catch (error) {
                        console.error("Camera error:", error);
                        cameraStatus.querySelector('.status-indicator').className = 'status-indicator status-error';
                        cameraStatus.querySelector('span:last-child').textContent = 'Camera error';
                        statusMessage.textContent = "Camera access denied! Please enable camera permissions.";
                    }
                }

                // Load face-api models with retry logic
                async function loadModels() {
                    try {
                        statusMessage.textContent = "Loading AI models...";
                        modelStatus.querySelector('.status-indicator').className = 'status-indicator status-loading';

                        // Try local models first, fallback to CDN
                        const localModelPath = '{{ asset("storage/models") }}';
                        const cdnModelPath = 'https://justadudewhohacks.github.io/face-api.js/models';

                        const cachedModels = await Promise.all([
                            getCachedModel('ssdMobilenetv1'),
                            getCachedModel('faceLandmark68Net'),
                            getCachedModel('faceRecognitionNet')
                        ]);
                        if (cachedModels.every(model => model !== null)) {
                            // Load from cache
                            await Promise.all([
                                faceapi.nets.ssdMobilenetv1.loadFromDisk(cachedModels[0]),
                                faceapi.nets.faceLandmark68Net.loadFromDisk(cachedModels[1]),
                                faceapi.nets.faceRecognitionNet.loadFromDisk(cachedModels[2])
                            ]);
                            statusMessage.textContent = "Models loaded from cache!";
                        } else {
                            // Fallback to network load
                            statusMessage.textContent = "Downloading models...";
                            await Promise.all([
                                faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models'),
                                faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
                                faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models')
                            ]);

                            // Cache the newly loaded models
                            await Promise.all([
                                cacheModel('ssdMobilenetv1', faceapi.nets.ssdMobilenetv1),
                                cacheModel('faceLandmark68Net', faceapi.nets.faceLandmark68Net),
                                cacheModel('faceRecognitionNet', faceapi.nets.faceRecognitionNet)
                            ]);
                        }

                        modelsLoaded = true;
                        modelStatus.querySelector('.status-indicator').className = 'status-indicator status-ready';
                        modelStatus.querySelector('span:last-child').textContent = 'Models loaded';
                        updateSystemStatus();
                    } catch (error) {
                        console.error("Model loading error:", error);
                        modelStatus.querySelector('.status-indicator').className = 'status-indicator status-error';
                        modelStatus.querySelector('span:last-child').textContent = 'Model load failed';
                        statusMessage.textContent = "Failed to load face detection models!";

                        // Retry with exponential backoff
                        setTimeout(loadModels, Math.min(5000 * Math.pow(2, retryCount), 30000));
                        retryCount++;
                    }
                }

                // Load registered face descriptors
                async function loadDescriptors() {
                    try {
                        statusMessage.textContent = "Loading registered face data...";
                        descriptorStatus.querySelector('.status-indicator').className = 'status-indicator status-loading';

                        const response = await fetch(getDescriptorsUrl, {
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();
                            registeredDescriptors = data.descriptors.map(desc => new Float32Array(desc));
                            registeredLabels = data.labels || [];

                            if (registeredDescriptors.length > 0) {
                                descriptorsLoaded = true;
                                descriptorStatus.querySelector('.status-indicator').className = 'status-indicator status-ready';
                                descriptorStatus.querySelector('span:last-child').textContent = 'Face data loaded';
                            } else {
                                throw new Error("No registered faces found");
                            }
                        } else {
                            throw new Error("Failed to load registered face data");
                        }
                    } catch (error) {
                        console.error("Descriptor loading error:", error);
                        descriptorStatus.querySelector('.status-indicator').className = 'status-indicator status-error';
                        descriptorStatus.querySelector('span:last-child').textContent = 'Load failed';
                        statusMessage.textContent = "Error: " + error.message;
                    } finally {
                        updateSystemStatus();
                    }
                }

                // Initialize all components in parallel
                await initializeCamera();
                await loadModels();
                await loadDescriptors();

                // Calculate image sharpness (optimized)
                function calculateSharpness(imageData, sampleStep = 4) {
                    const width = imageData.width;
                    const height = imageData.height;
                    const data = imageData.data;
                    const gray = new Array(Math.ceil(width * height / sampleStep));

                    // Convert to grayscale with sampling
                    for (let i = 0, j = 0; i < data.length; i += 4 * sampleStep, j++) {
                        gray[j] = 0.299 * data[i] + 0.587 * data[i + 1] + 0.114 * data[i + 2];
                    }

                    let edgeStrength = 0;
                    const sampledWidth = Math.ceil(width / sampleStep);
                    const sampledHeight = Math.ceil(height / sampleStep);

                    // Simplified edge detection with sampling
                    for (let y = 1; y < sampledHeight - 1; y++) {
                        for (let x = 1; x < sampledWidth - 1; x++) {
                            const idx = y * sampledWidth + x;
                            const gx = -gray[idx - 1 - sampledWidth] + gray[idx + 1 - sampledWidth]
                                - 2 * gray[idx - 1] + 2 * gray[idx + 1]
                                - gray[idx - 1 + sampledWidth] + gray[idx + 1 + sampledWidth];
                            const gy = -gray[idx - 1 - sampledWidth] - 2 * gray[idx - sampledWidth] - gray[idx + 1 - sampledWidth]
                                + gray[idx - 1 + sampledWidth] + 2 * gray[idx + sampledWidth] + gray[idx + 1 + sampledWidth];
                            edgeStrength += Math.sqrt(gx * gx + gy * gy);
                        }
                    }
                    return Math.min(1, edgeStrength / (sampledWidth * sampledHeight * 10));
                }

                // Calculate image quality metrics (optimized)
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

                    // Calculate sharpness
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
                        : similarity >= minSimilarity - 0.1
                            ? 'quality-value quality-warning'
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

                // Main verification process with null checks
                async function verifyFace() {
                    if (!systemReady || isProcessing || !modelsLoaded) return;
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
                            if (brightnessValue && contrastValue && sharpnessValue && similarityValue) {
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
                                    : similarity >= minSimilarity - 0.1
                                        ? 'quality-value quality-warning'
                                        : 'quality-value quality-bad';
                            }

                            // Check all requirements
                            const faceSizeOK = faceWidth >= minFaceWidth && faceHeight >= minFaceHeight;
                            const qualityOK = checkQualityRequirements(quality);
                            const similarityOK = similarity >= minSimilarity;
                            const allConditionsMet = faceSizeOK && qualityOK && similarityOK;

                            // Update progress based on match count
                            if (progressCircle) {
                                const circumference = 2 * Math.PI * 45;
                                const offset = circumference - (matchCount / requiredMatches) * circumference;
                                progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                                progressCircle.style.strokeDashoffset = offset;
                            }

                            if (!faceSizeOK) {
                                updateElement(statusMessage, "Please move closer to the camera");
                                updateElement(validationMessage, "Face too small");
                                return;
                            } else if (!qualityOK) {
                                updateElement(statusMessage, "Poor image quality. Please adjust lighting.");
                                updateElement(validationMessage, "Adjust lighting or position");
                                return;
                            }

                            if (match.label !== "unknown" && allConditionsMet) {
                                matchCount++;
                                failCount = 0;
                                // updateElement(statusMessage, `Strong match found (${match.label}) - ${(similarity * 100).toFixed(1)}% similarity`);
                                updateElement(statusMessage, `Recognizing - ${(similarity * 100).toFixed(1)}% similarity`);
                                updateElement(validationMessage, "");

                                updateElement(matchCountElement, matchCount);
                                updateElement(failCountElement, failCount);

                                if (matchCount >= requiredMatches) {
                                    if (verificationResult) {
                                        verificationResult.textContent = "Verification Successful!";
                                        verificationResult.className = "verification-result verification-success";
                                        verificationResult.style.display = "block";
                                    }
                                    if (progressCircle) {
                                        const circumference = 2 * Math.PI * 45;
                                        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                                        progressCircle.style.strokeDashoffset = 0;
                                    }

                                    // Send verification result to server
                                    await fetch(updateVerifiedUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            face_verified: true,
                                            confidence: similarity
                                        })
                                    });

                                    setTimeout(() => {
                                        window.location.href = voterLoginUrl;
                                    }, 1500);
                                }
                            } else {
                                matchCount = 0;
                                failCount++;
                                updateElement(matchCountElement, matchCount);
                                updateElement(failCountElement, failCount);

                                if (!similarityOK) {
                                    updateElement(statusMessage, `Insufficient match (${(similarity * 100).toFixed(1)}% similarity)`);
                                    updateElement(validationMessage, "Face not recognized");
                                } else {
                                    updateElement(statusMessage, "Verification conditions not met");
                                    updateElement(validationMessage, "Conditions not met");
                                }

                                if (failCount >= maxFailAttempts) {
                                    if (verificationResult) {
                                        verificationResult.textContent = "Too many failed attempts";
                                        verificationResult.className = "verification-result verification-failure";
                                        verificationResult.style.display = "block";
                                    }
                                    if (progressCircle) {
                                        progressCircle.style.strokeDashoffset = 2 * Math.PI * 45;
                                    }

                                    // Logout and redirect
                                    await fetch(logoutUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        }
                                    });

                                    setTimeout(() => {
                                        window.location.href = voterLoginUrl;
                                    }, 1500);
                                }
                            }
                        } else {
                            updateElement(statusMessage, "Face not detected. Please position your face in the circle.");
                            updateElement(validationMessage, "No face detected");
                            if (progressCircle) {
                                progressCircle.style.strokeDashoffset = 2 * Math.PI * 45;
                            }
                        }
                    } catch (error) {
                        console.error("Verification error:", error);
                        if (error.message.includes("load model before inference")) {
                            updateElement(statusMessage, "Models not ready. Please wait...");
                            // Reset models and retry loading
                            modelsLoaded = false;
                            if (modelStatus) {
                                modelStatus.querySelector('.status-indicator').className = 'status-indicator status-loading';
                                modelStatus.querySelector('span:last-child').textContent = 'Reloading models';
                            }
                            await loadModels();
                        } else {
                            updateElement(statusMessage, "Error during verification");
                        }
                        updateElement(validationMessage, "");
                    } finally {
                        isProcessing = false;
                    }
                }


                // Start verification process
                function startVerificationProcess() {
                    if (verificationActive) return;
                    verificationActive = true;

                    function verificationLoop() {
                        if (systemReady && modelsLoaded) {
                            verifyFace().catch(console.error);
                        }
                        requestAnimationFrame(verificationLoop);
                    }

                    verificationLoop();
                }
            })();
        </script>
    </x-slot>
</x-app-layout>
