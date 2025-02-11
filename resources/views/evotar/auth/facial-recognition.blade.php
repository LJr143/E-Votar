<x-app-layout mainClass="flex" page_title="- Voters">
    <x-slot name="main">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            #container {
                display: flex;
                justify-content: center;
                position: relative;
                transform: scaleX(-1);
            }
            canvas {
                position: absolute;
                transform: scaleX(-1);
            }
        </style>

        <div id="container">
            <video id="video-feed" height="560" width="720" autoplay></video>
            <canvas id="canvas"></canvas>
        </div>
    </x-slot>

    <script src="{{ asset('storage/js/face-api.min.js') }}"></script>
    <script>
        const userProfileImage = @json(asset('profile-image/' . Auth::user()->face_descriptor));
        const voterLoginUrl = @json(route('voter.login'));
        const logoutUrl = @json(route('logout'));

        const run = async () => {
            // Start webcam
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false,
            });
            const videoFeedEl = document.getElementById('video-feed');
            videoFeedEl.srcObject = stream;

            // Load Face-API models
            await Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
                faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models'),
                faceapi.nets.ageGenderNet.loadFromUri('/storage/models'),
                faceapi.nets.faceExpressionNet.loadFromUri('/storage/models'),
            ]);

            // Load reference face (user's stored profile image)
            const refFace = await faceapi.fetchImage(userProfileImage);
            let refFaceData = await faceapi
                .detectSingleFace(refFace)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!refFaceData) {
                alert("Error loading reference image. Please contact support.");
                return;
            }

            let faceMatcher = new faceapi.FaceMatcher(refFaceData);

            // Setup canvas
            const canvas = document.getElementById('canvas');
            canvas.style.left = videoFeedEl.offsetLeft + "px";
            canvas.style.top = videoFeedEl.offsetTop + "px";
            canvas.width = videoFeedEl.width;
            canvas.height = videoFeedEl.height;

            let matchCount = 0; // Count consecutive successful matches
            let failCount = 0;  // Count consecutive failed attempts
            const maxFailAttempts = 10; // Number of failures before logging out

            // Store interval ID
            const intervalId = setInterval(async () => {
                let faceData = await faceapi
                    .detectSingleFace(videoFeedEl)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!faceData) {
                    matchCount = 0;
                    failCount++;

                    console.log(`Failed attempts: ${failCount}`);

                    if (failCount >= maxFailAttempts) {
                        clearInterval(intervalId); // Stop checking
                        alert("Face not recognized multiple times. Logging out...");

                        fetch(logoutUrl, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Content-Type": "application/json",
                            },
                        }).then(() => {
                            window.location.href = voterLoginUrl; // Redirect to homepage or login page
                        }).catch(error => console.error("Logout failed:", error));
                    }

                    return;
                }

                // Resize detection results to fit video dimensions
                const resizedFaceData = faceapi.resizeResults(faceData, videoFeedEl);
                const context = canvas.getContext("2d");
                context.clearRect(0, 0, canvas.width, canvas.height);

                faceapi.draw.drawDetections(canvas, resizedFaceData);
                faceapi.draw.drawFaceLandmarks(canvas, resizedFaceData);

                // Matching process
                let match = faceMatcher.findBestMatch(faceData.descriptor);
                console.log("Match:", match.toString());

                if (match.label !== "unknown" && match.distance < 0.6) {
                    matchCount++;
                    failCount = 0; // Reset fail count on a successful match

                    if (matchCount >= 5) { // Require 5 consecutive matches
                        clearInterval(intervalId); // Stop the interval

                        // Send AJAX request to update session on the server side
                        fetch('/update-face-verified', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ face_verified: true })
                        })
                            .then(response => response.json())
                            .then(data => {
                                alert("Face verified! Redirecting...");
                                window.location.href = voterLoginUrl;
                            })
                            .catch(error => console.error('Error:', error));
                    }

                } else {
                    matchCount = 0;
                    failCount++;

                    console.log(`Failed attempts: ${failCount}`);

                    if (failCount >= maxFailAttempts) {
                        clearInterval(intervalId); // Stop checking
                        alert("Face not recognized multiple times. Logging out...");
                        window.location.href = logoutUrl; // Redirect to logout
                    }
                }
            }, 500); // Run every 500ms
        };

        run();

    </script>
</x-app-layout>
