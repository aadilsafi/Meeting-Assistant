<!DOCTYPE html>
<html lang="en">
    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no, viewport-fit=cover">
        <meta name="color-scheme" content="light dark">

        <title>{{env('APP_NAME')}}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset('assets/img/favicon/favicon.ico')}}" type="image/x-icon">

        <!-- Font -->
        <!-- Template CSS -->
        <link class="css-lt" rel="stylesheet" href="{{asset('assets/css/template.bundle.css')}}" media="(prefers-color-scheme: light)">
    </head>

    <body>
        <!-- Layout -->
        <div class="layout overflow-hidden">
            <!-- Navigation -->
            <nav class="navigation d-flex flex-column text-center navbar navbar-light hide-scrollbar">
                <!-- Brand -->
                <a href="{{route('dashboard')}}" title="Messenger" class="d-none d-xl-block mb-6">
                    <svg version="1.1" width="46px" height="46px" fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 46 46" enable-background="new 0 0 46 46" xml:space="preserve">
                        <polygon opacity="0.7" points="45,11 36,11 35.5,1 "/>
                        <polygon points="35.5,1 25.4,14.1 39,21 "/>
                        <polygon opacity="0.4" points="17,9.8 39,21 17,26 "/>
                        <polygon opacity="0.7" points="2,12 17,26 17,9.8 "/>
                        <polygon opacity="0.7" points="17,26 39,21 28,36 "/>
                        <polygon points="28,36 4.5,44 17,26 "/>
                        <polygon points="17,26 1,26 10.8,20.1 "/>
                    </svg>

                </a>

                <!-- Nav items -->
                <ul class="d-flex nav navbar-nav flex-row flex-xl-column flex-grow-1 justify-content-between justify-content-xl-center align-items-center w-100 py-4 py-lg-2 px-lg-3" role="tablist">
                    <!-- Invisible item to center nav vertically -->
                    <li class="nav-item d-none d-xl-block invisible flex-xl-grow-1">
                        <a class="nav-link py-0 py-lg-8" href="#" title="">
                            <div class="icon icon-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div>
                        </a>
                    </li>


                </ul>
            </nav>

            <!-- Navigation -->

            <!-- Sidebar -->
            <aside class="sidebar bg-light">
                <div class="tab-content h-100" role="tablist">

                    <!-- Chats -->
                    <div class="tab-pane fade h-100 show active" id="tab-content-chats" role="tabpanel">
                        <div class="d-flex flex-column h-100 position-relative">
                            <div class="hide-scrollbar">

                                <div class="container py-8">
                                    <!-- Title -->
                                    <div class="mb-8 row">
                                        <div class="col-10">
                                        <h2 class="fw-bold m-0">Chats</h2>
                                        </div>
                                        <div class="col-1">
                                        <a class="" id="tab-create-chat" href="{{route('chat.index')}}" title="Create chat" aria-selected="true">
                                            {{-- data-bs-toggle="tab" role="tab" --}}
                                            <div class="icon-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </div>
                                        </a>
                                    </div>
                                    </div>

                                    <!-- Chats -->
                                    <div class="card-list" id="card-list">
                                        <!-- Card -->
                                        @foreach ($chats as $chat )

                                        <a href="{{route('chat.show',$chat->id)}}" class="card border-0 text-reset {{$selected_chat && $selected_chat->id == $chat->id ? 'active' : '' }}">
                                            <div class="card-body">
                                                <div class="row gx-5">
                                                    <div class="col">
                                                        <div class="d-flex align-items-center">
                                                            <div class="line-clamp me-auto">
                                                                {{$chat->message}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .card-body -->
                                        </a>
                                        @endforeach

                                        <!-- Card -->

                                    </div>
                                    <!-- Chats -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- Sidebar -->

            <!-- Chat -->
            <main class="main is-visible" data-dropzone-area="">
                <div class="container h-100">
                    <div class="d-flex flex-column h-100 position-relative">

                        <!-- Chat: Header -->
                        <div class="chat-header border-bottom py-4 py-lg-7">
                            <div class="row align-items-center">

                                <!-- Mobile: close -->
                                <div class="col-2 d-xl-none">
                                    <a class="icon icon-lg text-muted" href="#" data-toggle-chat="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    </a>
                                </div>
                                <div class="col-10 w-100">
                                    <select id="microphoneSelect" class="form-control">
                                      <option value="">Select a microphone</option>
                                    </select>
                                </div>
                                <!-- Mobile: more -->

                            </div>
                        </div>
                        <!-- Chat: Content -->
                        <div id="scroller" class="chat-body hide-scrollbar flex-1 h-100">
                            <div class="chat-body-inner py-lg-12">
                                <div id="chat-body" class="py-6 py-lg-12">

                                    @isset($selected_chat)
                                    @foreach ($selected_chat->contexts as $context )

                                      <!-- Message OUT-->
                                    <div class="message message-out">
                                        <div class="message-inner">
                                            <div class="message-body">
                                                <div class="message-content">
                                                    <div class="message-text">
                                                        <p>{{$context->user_response}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Message IN -->
                                    <div class="message">
                                        <div class="message-inner">
                                            <div class="message-body">
                                                <div class="message-content">
                                                    <div class="message-text">
                                                        <p>{{$context->asisstant_response}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    @endforeach
                                    @endisset


                                </div>
                            </div>
                        </div>
                        <!-- Chat: Content -->

                        <!-- Chat: Footer -->
                        <div class="chat-footer pb-3 pb-lg-7 position-absolute bottom-0 start-0">
                            <!-- Chat: Files -->
                            <div class="dz-preview bg-dark" id="dz-preview-row" data-horizontal-scroll="">
                            </div>
                            <form class="chat-form rounded-pill bg-dark" data-emoji-form="">
                                <div class="row align-items-center gx-0">

                                    <div class="col">
                                        <div class="input-group">
                                            <textarea class="form-control px-0" id="text-input" placeholder="Type your message..." rows="1" data-emoji-input="" data-autosize="true"></textarea>

                                            <a href="#" class="input-group-text text-body pe-0 d-none" data-emoji-btn="">
                                                <span class="icon icon-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" id='text-button' class="btn btn-icon btn-primary rounded-circle ms-5" onclick="sendText()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        </button>
                                        <button class="btn btn-icon btn-primary rounded-circle ms-5" type=button onclick="toggleListening()" id="mic-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon feather feather-mic-on"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                                        </button>
                                        {{-- <button class="btn btn-icon btn-primary rounded-circle ms-5" type=button onclick="stopListening()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mic-off"><line x1="1" y1="1" x2="23" y2="23"></line><path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6"></path><path d="M17 16.95A7 7 0 0 1 5 12v-2m14 0v2a7 7 0 0 1-.11 1.23"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                                        </button> --}}
                                    </div>
                                </div>
                            </form>
                            <!-- Chat: Form -->
                        </div>
                        <!-- Chat: Footer -->
                    </div>

                </div>
            </main>
            <!-- Chat -->
        </div>
        <!-- Layout -->

        <script src="https://cdn.jsdelivr.net/npm/hark@1.2.3/hark.bundle.min.js"></script>
    <script>
    var divElement = document.getElementById("scroller");
    divElement.scrollTop = divElement.scrollHeight + 50;
        let isStart = false;
        let isNewChat = true;
        let inProgress = false;
        let mediaRecorder;
        let chat_id = "{{$selected_chat ?$selected_chat->id : null}}";
        let recordedChunks = [];
        let user_input = false;
        let silenceTimeout;
        let speechEvents;
        let mediaStream;
        let selectedDeviceId;
        let stream;



        async function startRecording() {

            recordedChunks = [];
                stream = await navigator.mediaDevices.getUserMedia({ audio: { deviceId: selectedDeviceId } });
                // return;


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
                // if(user_input){
                sendAudioToBackend(audioBlob);
                // }


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
            let text = "";

            try {
                const response = await fetch("{{ route('upload') }}", {
                    method: "POST",
                    body: formData,
                });

                if (response.ok) {
                    let res = await response.json();
                    let old_chat_id = chat_id
                    chat_id = res.chat_id;
                    text = res.text;
                    let old_text = text;
                    // let temp = document.getElementById('chat-body');

                    const child = document.createElement("div");
                    child.classList.add("message");
                    child.classList.add("message-out");
                    child.innerHTML = '<div class="message-inner"><div class="message-body"><div class="message-content"><div class="message-text"><p>'+text+'</p></div></div></div></div>'

                    document.getElementById('chat-body').appendChild(child);



                    // here again
                    const formData2 = new FormData();
                    formData2.append("text", text);
                    formData2.append("chat_id", chat_id);
                const response2 = await fetch("{{ route('get-answer') }}", {
                    method: "POST",
                    body: formData2,
                });

                if (response2.ok) {
                    let res = await response2.json();
                    text = res.text;
                    chat_id = res.chat_id;
                    history.pushState(null, "", `/chat/${chat_id}`);
                    console.log(old_chat_id,'old id')
                    if(old_chat_id == null || old_chat_id == '' || old_chat_id == ' '){
                        newChat(old_text,`/chat/${chat_id}`)
                    }


                    // let temp = document.getElementById('chat-body');

                    const child = document.createElement("div");
                    child.classList.add("message");
                    child.innerHTML = '<div class="message-inner"><div class="message-body"><div class="message-content"><div class="message-text"><p>'+text+'</p></div></div></div></div>'

                    document.getElementById('chat-body').appendChild(child);


                    console.log("Answer Fetched Sucessfully!");
                } else {
                    console.error("Answer Fetched Failed");
                }


                    // here die
                    divElement.scrollTop = divElement.scrollHeight + 50;


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
            inProgress = false;
            recordedChunks = [];

            if (mediaRecorder) {
                mediaRecorder.stop();
            }
            if(speechEvents){
                speechEvents.stop();
            }
                     if(stream){
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            user_input = false;
        }

        async function sendText () {
            text = document.getElementById('text-input').value;

                    // let temp = document.getElementById('chat-body');
                    const child = document.createElement("div");
                    child.classList.add("message");
                    child.classList.add("message-out");
                    child.innerHTML = '<div class="message-inner"><div class="message-body"><div class="message-content"><div class="message-text"><p>'+text+'</p></div></div></div></div>'

                    document.getElementById('chat-body').appendChild(child);
                    document.getElementById('text-input').value = "";



                    // here again
                    const formData3 = new FormData();
                    formData3.append("text", text);
                    formData3.append("chat_id", chat_id);
                const response3 = await fetch("{{ route('get-answer') }}", {
                    method: "POST",
                    body: formData3,
                });

                if (response3.ok) {
                    let res = await response3.json();
                    let old_text = text;
                    let old_chat_id = chat_id
                    text = res.text;
                    chat_id = res.chat_id;
                    history.pushState(null, "", `/chat/${chat_id}`);
                    console.log(old_chat_id,'old id')
                    if(old_chat_id == null || old_chat_id == '' || old_chat_id == ' '){
                        newChat(old_text,`/chat/${chat_id}`)
                    }

                    // let temp = document.getElementById('chat-body');

                    const child = document.createElement("div");
                    child.classList.add("message");
                    child.innerHTML = '<div class="message-inner"><div class="message-body"><div class="message-content"><div class="message-text"><p>'+text+'</p></div></div></div></div>'

                    document.getElementById('chat-body').appendChild(child);


                    console.log("Answer Fetched Successfully!");
                } else {
                    console.error("Failed to get answer.",);
                }

                    divElement.scrollTop = divElement.scrollHeight + 50;

        }
        function toggleListening(){
            isStart = !isStart;
            let mic_icon = document.getElementById('mic-button');
            if(isStart){
                if(selectedDeviceId){
                    mic_icon.classList.add('active')

                    startListening();
                }else{
                    isStart = false
                    alert('Please select a microphone first')
                }
            }else{
                mic_icon.classList.remove('active')
                stopListening();
            }

        }
        function newChat(message,url){
            console.log('here');
            let ele = document.getElementById('card-list');
            let temp = `
            <a href="${url}" class="card border-0 text-reset active">
                <div class="card-body">
                    <div class="row gx-5">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div class="line-clamp me-auto">
                                    ${message}
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .card-body -->
            </a>`+ele.innerHTML
            document.getElementById('card-list').innerHTML = temp
        }
        document.addEventListener("DOMContentLoaded", async function() {
  const microphoneSelect = document.getElementById("microphoneSelect");

  try {
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      stream.getTracks().forEach(track => track.stop());

      const devices = await navigator.mediaDevices.enumerateDevices();

      const audioInputDevices = devices.filter(device => device.kind === "audioinput");

      audioInputDevices.forEach((device, index) => {
        const option = document.createElement("option");
        option.value = device.deviceId;
        option.text = device.label || `Microphone ${index + 1}`;
        microphoneSelect.appendChild(option);
      });

      microphoneSelect.disabled = false;
    } catch (error) {
      console.error("Error requesting permission or enumerating devices:", error);
    }
  microphoneSelect.addEventListener("change", function() {
    selectedDeviceId = microphoneSelect.value;
    stopListening();
    if(isStart){
        startListening();
    }
  });
});
        const textArea = document.getElementById('text-input');
        // Add an event listener to the text area for the "keydown" event
        textArea.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default behavior of the "Enter" key (e.g., line break)
            document.getElementById('text-button').click(); // Simulate a click on the button
        }
        });
    </script>
    <script src="{{asset('assets/js/vendor.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    </body>
</html>
<style>
    .card-list .active{
        border:1px solid black!important;
    }
    .icon {
  font-size: 24px;
  transition: transform 0.2s ease-in-out;
}

.active .icon {
  animation: pulse 1s infinite;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
}
</style>
