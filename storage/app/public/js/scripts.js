console.log(faceapi)

const run = async()=>{
    //loading the models is going to use await
    const stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
    })
    const videoFeedEl = document.getElementById('video-feed')
    videoFeedEl.srcObject = stream
    //we need to load our models
    // pre-trained machine learning for our facial detection!
    await Promise.all([
        faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models'),
        faceapi.nets.ageGenderNet.loadFromUri('/storage/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('/storage/models'),
    ])

    //make the canvas the same size and in the same location
    // as our video feed
    const canvas = document.getElementById('canvas')
    canvas.style.left = videoFeedEl.offsetLeft
    canvas.style.top = videoFeedEl.offsetTop
    canvas.height = videoFeedEl.height
    canvas.width = videoFeedEl.width

    /////OUR FACIAL RECOGNITION DATA
    // we KNOW who this is (Michael Jordan)
    const refFace = await faceapi.fetchImage('/storage/assets/profile/IMG_20230823_191834-removebg-preview.jpg')
    //we grab the reference image, and hand it to detectAllFaces method
    let refFaceAiData = await faceapi.detectAllFaces(refFace).withFaceLandmarks().withFaceDescriptors()
    let faceMatcher = new faceapi.FaceMatcher(refFaceAiData)

    // facial detection with points
    setInterval(async()=>{
        // get the video feed and hand it to detectAllFaces method
        let faceAIData = await faceapi.detectAllFaces(videoFeedEl).withFaceLandmarks().withFaceDescriptors().withAgeAndGender().withFaceExpressions()
        // console.log(faceAIData)
        // we have a ton of good facial detection data in faceAIData
        // faceAIData is an array, one element for each face

        // draw on our face/canvas
        //first, clear the canvas
        canvas.getContext('2d').clearRect(0,0,canvas.width,canvas.height)
        // draw our bounding box
        faceAIData = faceapi.resizeResults(faceAIData,videoFeedEl)
        faceapi.draw.drawDetections(canvas,faceAIData)
        faceapi.draw.drawFaceLandmarks(canvas,faceAIData)
        faceapi.draw.drawFaceExpressions(canvas,faceAIData)

        // ask AI to guess age and gender with confidence level
        // Inside the setInterval function
        // Inside the setInterval function
        faceAIData.forEach(face => {
            const { age, gender, genderProbability, detection, descriptor } = face;
            const genderText = `${gender} - ${Math.round(genderProbability * 100) / 100 * 100}`;
            const ageText = `${Math.round(age)} years`;
            const textField = new faceapi.draw.DrawTextField([genderText, ageText], face.detection.box.topRight);
            textField.draw(canvas);

            // Find the best match and get the confidence score
            const bestMatch = faceMatcher.findBestMatch(descriptor);
            let label = bestMatch.toString();
            let confidence = bestMatch.distance; // This is the distance score
            let options = { label: "Lorjohn M. Rana" };
            let confidencePercentage = 0; // Initialize the variable

            if (label.includes("unknown")) {
                options = { label: "Unknown subject..." };
            } else {
                // Display the confidence percentage
                confidencePercentage = Math.round((1 - confidence) * 100); // Convert distance to percentage
                options.label = `${label} (${confidencePercentage}%)`;
            }

            // Draw the bounding box
            const drawBox = new faceapi.draw.DrawBox(detection.box, options);
            drawBox.draw(canvas);

            // Draw the confidence percentage inside the box
            const ctx = canvas.getContext('2d');
            ctx.font = '16px Arial';
            ctx.fillStyle = 'white'; // Text color
            ctx.fillText(`${confidencePercentage}%`, detection.box.x + 5, detection.box.y + 20); // Adjust position as needed
        });


    },200)

}

run()
