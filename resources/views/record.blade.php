<!DOCTYPE html>
<html>

<head>
    <title>Audio Recording with Hark.js</title>

</head>

<body>
    <button id="recordButton" onclick="startListening()">Start Recording</button>
    <button id="recordButton" onclick="stopListening()">Stop Recording</button>


    <script src="https://cdn.jsdelivr.net/npm/hark@1.2.3/hark.bundle.min.js"></script>
    <script>
        let isNewChat = true;
        let inProgress = false;
        let mediaRecorder;
        let chat_id = null;
        let recordedChunks = [];
        let user_input = false;
        let silenceTimeout;
        let speechEvents;
        let mediaStream;

        async function startRecording() {
            recordedChunks = [];

            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });

            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = async () => {
                const audioBlob = new Blob(recordedChunks, {
                    type: "audio/wav"
                });
                recordedChunks = [];
                if(user_input){
                sendAudioToBackend(audioBlob);
                }


            };

            const options = {
                // threshold: -50, // Adjust this threshold value based on your needs
            };

            const speechEvents = hark(stream, options);

            speechEvents.on("speaking", () => {
                clearTimeout(silenceTimeout); // Clear the timeout if speaking resumes
                console.log("User is speaking...",mediaRecorder);
                user_input = true;
            });

            speechEvents.on("stopped_speaking", () => {
                console.log("User stopped speaking.",mediaRecorder);
                clearTimeout(silenceTimeout); // Clear the timeout if speaking resumes

                // Set a timeout to send the audio after a certain period of silence
                silenceTimeout = setTimeout(() => {
                    console.log("Silence detected. Stopping recording...");
                    mediaRecorder.stop();
                    recordedChunks = [];
                    if(inProgress){
                    startRecording();
                    }

                }, 3000); // Adjust the duration (in milliseconds) as needed
            });

            mediaRecorder.start();
        }

        async function sendAudioToBackend(audioBlob) {
            const formData = new FormData();
            formData.append("audio", audioBlob, "recorded_audio.wav");
            formData.append("is_new_chat", isNewChat);
            formData.append("chat_id", chat_id);

            try {
                const response = await fetch("{{ route('upload') }}", {
                    method: "POST",
                    body: formData,
                });

                if (response.ok) {
                    let res = await response.json();
                    chat_id = res.chat_id;
                    console.log("Audio file successfully uploaded!");
                } else {
                    console.error("Failed to upload audio file.");
                }
            } catch (error) {
                console.error("An error occurred during audio file upload:", error);
            }
            isNewChat = false;
        }

        // Start recording automatically when the page loads
        function startListening(){
            inProgress = true;
            startRecording();
        }
        function stopListening(){
            isNewChat = true;
            chat_id = null;
            inProgress = false;
            recordedChunks = [];
            if (mediaRecorder) {
                mediaRecorder.stop();
            }
            if(speechEvents){
                speechEvents.stop();
            }
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
            user_input = false;
        }


    </script>
</body>

</html>
