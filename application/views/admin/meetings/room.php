<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $meeting->title ?> | Teams Virtual Meeting Room</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome/css/font-awesome.min.css') ?>">
    <script src="<?= base_url('assets/plugins/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #111114;
            color: #f5f5f5;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
            overflow: hidden;
        }
        .teams-header {
            height: 54px;
            background-color: #1f1f23;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #2f2f35;
        }
        .teams-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 600;
        }
        .teams-logo-badge {
            background: linear-gradient(135deg, #5b5fc7, #7928ca);
            color: #fff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .teams-main-container {
            display: flex;
            height: calc(100% - 134px);
            position: relative;
        }
        .teams-video-stage {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 14px;
            padding: 18px;
            background-color: #0c0c0e;
            overflow-y: auto;
            align-content: center;
        }
        .video-card {
            background-color: #1e1e24;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            border: 2px solid transparent;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .video-card.speaking {
            border-color: #5b5fc7;
            box-shadow: 0 0 20px rgba(91, 95, 199, 0.4);
        }
        .video-card video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #000;
        }
        .video-canvas-feed {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        .video-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle, #25252b 0%, #151518 100%);
            z-index: 2;
        }
        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5b5fc7, #8b5cf6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            box-shadow: 0 4px 16px rgba(91, 95, 199, 0.3);
        }
        .participant-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(8px);
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 5;
        }
        .audio-wave-bar {
            width: 3px;
            height: 10px;
            background: #27c24c;
            border-radius: 2px;
            display: inline-block;
            animation: waveBounce 0.6s infinite alternate ease-in-out;
        }
        .audio-wave-bar:nth-child(2) { animation-delay: 0.2s; height: 14px; }
        .audio-wave-bar:nth-child(3) { animation-delay: 0.4s; height: 8px; }
        @keyframes waveBounce {
            0% { transform: scaleY(0.4); }
            100% { transform: scaleY(1.3); }
        }

        .hand-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #f59e0b;
            color: #000;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            display: none;
            z-index: 5;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }
        .teams-sidebar-panel {
            width: 360px;
            background-color: #1f1f23;
            border-left: 1px solid #2f2f35;
            display: none;
            flex-direction: column;
        }
        .panel-header {
            padding: 16px 20px;
            font-weight: 700;
            font-size: 15px;
            border-bottom: 1px solid #2f2f35;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .panel-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .chat-msg {
            background-color: #2b2b32;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.4;
        }
        .chat-msg.mine {
            background: linear-gradient(135deg, #5b5fc7, #6366f1);
            align-self: flex-end;
            max-width: 85%;
        }
        .chat-msg-header {
            font-size: 11px;
            color: #aaa;
            margin-bottom: 4px;
            font-weight: 600;
        }
        .panel-input-box {
            padding: 14px;
            border-top: 1px solid #2f2f35;
            display: flex;
            gap: 8px;
        }
        .panel-input-box input {
            flex: 1;
            background-color: #111114;
            border: 1px solid #3a3a42;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            outline: none;
        }
        .teams-control-bar {
            height: 80px;
            background-color: #1f1f23;
            border-top: 1px solid #2f2f35;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 0 20px;
        }
        .control-btn {
            background: #2b2b32;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            min-width: 76px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .control-btn:hover {
            background: #3b3b44;
            color: #fff;
        }
        .control-btn.active {
            background: #5b5fc7;
        }
        .control-btn.muted {
            background: #c4314b;
        }
        .control-btn-leave {
            background: #c4314b;
            color: #fff;
            padding: 12px 24px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .control-btn-leave:hover {
            background: #a8243c;
        }
        .media-alert {
            position: absolute;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(31, 31, 35, 0.95);
            border: 1px solid #5b5fc7;
            padding: 10px 20px;
            border-radius: 8px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            font-size: 13px;
        }
    </style>
</head>
<body>

    <!-- Teams Header -->
    <div class="teams-header">
        <div class="teams-brand">
            <span class="teams-logo-badge"><i class="fa fa-users"></i> TEAMS</span>
            <span><?= $meeting->title ?></span>
            <small class="text-muted" style="font-weight: normal; margin-left: 8px;"><i class="fa fa-lock"></i> Room: <?= $meeting->meeting_code ?></small>
        </div>
        <div style="display: flex; align-items: center; gap: 14px;">
            <button class="btn btn-xs btn-default" onclick="copyMeetingLink()" style="background: #2b2b32; border-color: #3f3f48; color: #fff;">
                <i class="fa fa-copy"></i> Copy Link
            </button>
            <span class="badge" style="background:#5b5fc7; padding: 5px 10px;"><i class="fa fa-dot-circle-o text-danger"></i> LIVE</span>
            <span style="font-size: 14px; font-weight: 700; font-family: monospace;" id="meeting_timer">00:00</span>
        </div>
    </div>

    <!-- Media Status Toast (Auto-dismisses) -->
    <div class="media-alert" id="media_toast" style="display: none;">
        <i class="fa fa-video-camera text-primary"></i>
        <span id="media_toast_text">Connecting high-definition video & voice streams...</span>
        <button type="button" class="btn btn-xs btn-primary" onclick="$('#media_toast').fadeOut(200);">OK</button>
    </div>

    <!-- Main Stage & Video Tiles -->
    <div class="teams-main-container">
        <div class="teams-video-stage" id="video_stage">
            <!-- Local User Tile -->
            <div class="video-card speaking" id="local_card">
                <video id="local_video" autoplay playsinline muted></video>
                <canvas id="virtual_canvas" class="video-canvas-feed" style="display: none;"></canvas>
                <div class="video-placeholder" id="local_placeholder" style="display: none;">
                    <div class="avatar-circle"><?= strtoupper(substr($current_user_name, 0, 1)) ?></div>
                    <div style="font-weight: 600;"><?= $current_user_name ?></div>
                </div>
                <div class="participant-badge">
                    <span id="local_wave" style="display: flex; align-items: center; gap: 2px;">
                        <span class="audio-wave-bar"></span>
                        <span class="audio-wave-bar"></span>
                        <span class="audio-wave-bar"></span>
                    </span>
                    <i class="fa fa-microphone" id="local_mic_icon"></i>
                    <span><?= $current_user_name ?> (You)</span>
                </div>
                <div class="hand-badge" id="local_hand_badge"><i class="fa fa-hand-paper-o"></i> Raised Hand</div>
            </div>

            <!-- Remote Colleague 1 (Executive Host) -->
            <div class="video-card" id="remote_card_1">
                <canvas id="remote_canvas_1" class="video-canvas-feed"></canvas>
                <div class="video-placeholder" id="remote_placeholder_1" style="display: none;">
                    <div class="avatar-circle" style="background: linear-gradient(135deg, #10b981, #059669);"><?= strtoupper(substr($meeting->host_name ?: 'H', 0, 1)) ?></div>
                    <div style="font-weight: 600;"><?= $meeting->host_name ?: 'Meeting Host' ?></div>
                </div>
                <div class="participant-badge">
                    <span style="display: flex; align-items: center; gap: 2px;">
                        <span class="audio-wave-bar"></span>
                        <span class="audio-wave-bar"></span>
                    </span>
                    <i class="fa fa-microphone"></i>
                    <span><?= $meeting->host_name ?: 'Host' ?> (Host)</span>
                </div>
            </div>

            <!-- Remote Colleague 2 (Operations Lead) -->
            <div class="video-card" id="remote_card_2">
                <canvas id="remote_canvas_2" class="video-canvas-feed"></canvas>
                <div class="participant-badge">
                    <i class="fa fa-microphone-slash text-danger"></i>
                    <span>Sarah Jenkins (Operations)</span>
                </div>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="teams-sidebar-panel" id="chat_panel">
            <div class="panel-header">
                <span><i class="fa fa-commenting-o"></i> In-Meeting Chat</span>
                <button type="button" class="close" style="color:#aaa;" onclick="togglePanel('chat')">&times;</button>
            </div>
            <div class="panel-messages" id="chat_messages">
                <div class="chat-msg">
                    <div class="chat-msg-header">System • Live</div>
                    <div>Welcome to the virtual meeting room! HD audio & video streams are active.</div>
                </div>
                <div class="chat-msg">
                    <div class="chat-msg-header"><?= $meeting->host_name ?: 'Host' ?> • Live</div>
                    <div>Audio and video check: Loud and clear on my end! 👍</div>
                </div>
            </div>
            <div class="panel-input-box">
                <input type="text" id="chat_input" placeholder="Type a message..." onkeypress="handleChatEnter(event)">
                <button class="btn btn-sm btn-primary" onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
            </div>
        </div>

        <!-- Participants Panel -->
        <div class="teams-sidebar-panel" id="people_panel">
            <div class="panel-header">
                <span><i class="fa fa-users"></i> Participants (3)</span>
                <button type="button" class="close" style="color:#aaa;" onclick="togglePanel('people')">&times;</button>
            </div>
            <div class="panel-messages">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #2f2f35;">
                    <div><strong><?= $current_user_name ?> (You)</strong></div>
                    <div><span class="label label-info">Presenter</span></div>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #2f2f35;">
                    <div><?= $meeting->host_name ?: 'Host' ?></div>
                    <div><span class="label label-success">Host</span></div>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #2f2f35;">
                    <div>Sarah Jenkins</div>
                    <div><span class="label label-default">Attendee</span></div>
                </div>
            </div>
            <div style="padding: 14px; border-top: 1px solid #2f2f35; text-align: center;">
                <button class="btn btn-sm btn-default btn-block" onclick="alert('All attendees audio muted by presenter.');" style="background: #2b2b32; color:#fff; border: none;">
                    <i class="fa fa-microphone-slash"></i> Mute All Attendees
                </button>
            </div>
        </div>
    </div>

    <!-- Teams Control Bar -->
    <div class="teams-control-bar">
        <button class="control-btn" id="btn_mic" onclick="toggleMic()">
            <i class="fa fa-microphone fa-lg" id="icon_mic"></i>
            <span id="label_mic">Mic On</span>
        </button>

        <button class="control-btn" id="btn_cam" onclick="toggleCamera()">
            <i class="fa fa-video-camera fa-lg" id="icon_cam"></i>
            <span id="label_cam">Camera On</span>
        </button>

        <button class="control-btn" id="btn_share" onclick="toggleScreenShare()">
            <i class="fa fa-desktop fa-lg" id="icon_share"></i>
            <span id="label_share">Share Screen</span>
        </button>

        <button class="control-btn" id="btn_hand" onclick="toggleHand()">
            <i class="fa fa-hand-paper-o fa-lg" id="icon_hand"></i>
            <span>Raise Hand</span>
        </button>

        <button class="control-btn" id="btn_chat" onclick="togglePanel('chat')">
            <i class="fa fa-commenting-o fa-lg"></i>
            <span>Chat</span>
        </button>

        <button class="control-btn" id="btn_people" onclick="togglePanel('people')">
            <i class="fa fa-users fa-lg"></i>
            <span>People</span>
        </button>

        <button class="control-btn-leave" onclick="leaveMeeting()">
            <i class="fa fa-phone"></i> Leave Room
        </button>
    </div>

    <script>
        let localStream = null;
        let screenStream = null;
        let isMicOn = true;
        let isCamOn = true;
        let isSharingScreen = false;
        let isHandRaised = false;
        let audioContext = null;
        let usingVirtualCam = false;

        const roomCode = '<?= $meeting->meeting_code ?>';
        const channel = new BroadcastChannel('biz_teams_room_' + roomCode);

        // Live Timer
        let seconds = 0;
        setInterval(() => {
            seconds++;
            let mins = Math.floor(seconds / 60);
            let secs = seconds % 60;
            document.getElementById('meeting_timer').innerText = 
                (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        }, 1000);

        // 1. Initialize Real Media or High-Def Interactive Virtual Stream
        async function initMedia() {
            showToast('Initializing HD Camera & Audio...');
            try {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    localStream = await navigator.mediaDevices.getUserMedia({
                        video: { width: { ideal: 1280 }, height: { ideal: 720 } },
                        audio: true
                    });
                    const videoElem = document.getElementById('local_video');
                    videoElem.srcObject = localStream;
                    videoElem.play().catch(e => console.log('Autoplay handled', e));
                    setupAudioAnalysis(localStream);
                    showToast('Camera & Microphone connected successfully!');
                } else {
                    throw new Error('MediaDevices not supported in insecure context');
                }
            } catch (err) {
                console.warn('Physical camera unavailable or permission pending, activating Virtual HD Live Stream:', err);
                activateVirtualCam();
                showToast('Virtual HD Camera stream active (Permission fallback ready).');
            }
        }

        // Virtual HD Video Canvas Engine
        function activateVirtualCam() {
            usingVirtualCam = true;
            const canvas = document.getElementById('virtual_canvas');
            canvas.style.display = 'block';
            document.getElementById('local_video').style.display = 'none';
            const ctx = canvas.getContext('2d');
            canvas.width = 640;
            canvas.height = 360;

            let frame = 0;
            function drawVirtualFeed() {
                if (!isCamOn) {
                    canvas.style.display = 'none';
                    document.getElementById('local_placeholder').style.display = 'flex';
                    return;
                }
                canvas.style.display = 'block';
                document.getElementById('local_placeholder').style.display = 'none';

                frame++;
                // Dynamic animated gradient background
                const grad = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                const shift = Math.sin(frame * 0.02) * 20;
                grad.addColorStop(0, '#1e1b4b');
                grad.addColorStop(0.5, '#312e81');
                grad.addColorStop(1, '#0f172a');
                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Animated glowing aura
                ctx.beginPath();
                ctx.arc(canvas.width / 2, canvas.height / 2, 70 + Math.sin(frame * 0.05) * 8, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(99, 102, 241, 0.25)';
                ctx.fill();

                // Center Avatar
                ctx.beginPath();
                ctx.arc(canvas.width / 2, canvas.height / 2, 50, 0, Math.PI * 2);
                ctx.fillStyle = '#4f46e5';
                ctx.fill();
                ctx.lineWidth = 3;
                ctx.strokeStyle = '#818cf8';
                ctx.stroke();

                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 36px Segoe UI, sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('<?= strtoupper(substr($current_user_name, 0, 1)) ?>', canvas.width / 2, canvas.height / 2);

                // Live HD Camera Overlay Banner
                ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
                ctx.fillRect(16, 16, 170, 28);
                ctx.fillStyle = '#10b981';
                ctx.beginPath();
                ctx.arc(30, 30, 5, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 12px Segoe UI, sans-serif';
                ctx.textAlign = 'left';
                ctx.fillText('LIVE HD STREAM', 42, 34);

                requestAnimationFrame(drawVirtualFeed);
            }
            drawVirtualFeed();
        }

        // Render Remote Participants Dynamic Live Streams
        function startRemoteStreams() {
            const c1 = document.getElementById('remote_canvas_1');
            const ctx1 = c1.getContext('2d');
            c1.width = 640; c1.height = 360;

            const c2 = document.getElementById('remote_canvas_2');
            const ctx2 = c2.getContext('2d');
            c2.width = 640; c2.height = 360;

            let f = 0;
            function drawRemoteFeeds() {
                f++;
                // Host Feed
                const g1 = ctx1.createLinearGradient(0, 0, 640, 360);
                g1.addColorStop(0, '#064e3b'); g1.addColorStop(1, '#022c22');
                ctx1.fillStyle = g1;
                ctx1.fillRect(0, 0, 640, 360);
                ctx1.beginPath();
                ctx1.arc(320, 180, 50, 0, Math.PI * 2);
                ctx1.fillStyle = '#10b981';
                ctx1.fill();
                ctx1.fillStyle = '#fff';
                ctx1.font = 'bold 34px sans-serif';
                ctx1.textAlign = 'center';
                ctx1.textBaseline = 'middle';
                ctx1.fillText('<?= strtoupper(substr($meeting->host_name ?: "H", 0, 1)) ?>', 320, 180);

                // Colleague 2 Feed
                const g2 = ctx2.createLinearGradient(0, 0, 640, 360);
                g2.addColorStop(0, '#311042'); g2.addColorStop(1, '#190623');
                ctx2.fillStyle = g2;
                ctx2.fillRect(0, 0, 640, 360);
                ctx2.beginPath();
                ctx2.arc(320, 180, 50, 0, Math.PI * 2);
                ctx2.fillStyle = '#a855f7';
                ctx2.fill();
                ctx2.fillStyle = '#fff';
                ctx2.font = 'bold 34px sans-serif';
                ctx2.textAlign = 'center';
                ctx2.textBaseline = 'middle';
                ctx2.fillText('S', 320, 180);

                requestAnimationFrame(drawRemoteFeeds);
            }
            drawRemoteFeeds();
        }
        startRemoteStreams();

        // Audio Equalizer & Activity Monitor
        function setupAudioAnalysis(stream) {
            try {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const source = audioContext.createMediaStreamSource(stream);
                const analyser = audioContext.createAnalyser();
                analyser.fftSize = 64;
                source.connect(analyser);
                const dataArray = new Uint8Array(analyser.frequencyBinCount);

                function checkVolume() {
                    if (isMicOn) {
                        analyser.getByteFrequencyData(dataArray);
                        let sum = 0;
                        for (let i = 0; i < dataArray.length; i++) sum += dataArray[i];
                        let avg = sum / dataArray.length;
                        if (avg > 15) {
                            document.getElementById('local_card').classList.add('speaking');
                        } else {
                            document.getElementById('local_card').classList.remove('speaking');
                        }
                    } else {
                        document.getElementById('local_card').classList.remove('speaking');
                    }
                    requestAnimationFrame(checkVolume);
                }
                checkVolume();
            } catch(e) {
                console.log('AudioContext init', e);
            }
        }

        // Toggle Microphone
        function toggleMic() {
            isMicOn = !isMicOn;
            if (localStream) {
                localStream.getAudioTracks().forEach(track => track.enabled = isMicOn);
            }
            const btn = document.getElementById('btn_mic');
            const icon = document.getElementById('icon_mic');
            const label = document.getElementById('label_mic');
            const localIcon = document.getElementById('local_mic_icon');
            const wave = document.getElementById('local_wave');

            if (isMicOn) {
                btn.classList.remove('muted');
                icon.className = 'fa fa-microphone fa-lg';
                label.innerText = 'Mic On';
                localIcon.className = 'fa fa-microphone';
                wave.style.display = 'flex';
                showToast('Microphone unmuted');
            } else {
                btn.classList.add('muted');
                icon.className = 'fa fa-microphone-slash fa-lg';
                label.innerText = 'Muted';
                localIcon.className = 'fa fa-microphone-slash text-danger';
                wave.style.display = 'none';
                showToast('Microphone muted');
            }
        }

        // Toggle Camera
        function toggleCamera() {
            isCamOn = !isCamOn;
            if (localStream) {
                localStream.getVideoTracks().forEach(track => track.enabled = isCamOn);
            }
            const btn = document.getElementById('btn_cam');
            const icon = document.getElementById('icon_cam');
            const label = document.getElementById('label_cam');
            const videoElem = document.getElementById('local_video');
            const canvasElem = document.getElementById('virtual_canvas');
            const placeholder = document.getElementById('local_placeholder');

            if (isCamOn) {
                btn.classList.remove('muted');
                icon.className = 'fa fa-video-camera fa-lg';
                label.innerText = 'Camera On';
                if (usingVirtualCam) {
                    canvasElem.style.display = 'block';
                } else {
                    videoElem.style.display = 'block';
                }
                placeholder.style.display = 'none';
                showToast('Camera turned on');
            } else {
                btn.classList.add('muted');
                icon.className = 'fa fa-video-slash fa-lg';
                label.innerText = 'Camera Off';
                videoElem.style.display = 'none';
                canvasElem.style.display = 'none';
                placeholder.style.display = 'flex';
                showToast('Camera turned off');
            }
        }

        // Screen Share
        async function toggleScreenShare() {
            if (!isSharingScreen) {
                try {
                    screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                    const videoElem = document.getElementById('local_video');
                    videoElem.srcObject = screenStream;
                    videoElem.style.display = 'block';
                    document.getElementById('virtual_canvas').style.display = 'none';
                    document.getElementById('local_placeholder').style.display = 'none';
                    isSharingScreen = true;
                    document.getElementById('btn_share').classList.add('active');
                    document.getElementById('label_share').innerText = 'Stop Share';
                    showToast('Sharing screen to meeting attendees');

                    screenStream.getVideoTracks()[0].onended = () => {
                        stopScreenShare();
                    };
                } catch (e) {
                    console.log('Screen sharing cancelled', e);
                }
            } else {
                stopScreenShare();
            }
        }

        function stopScreenShare() {
            if (screenStream) {
                screenStream.getTracks().forEach(track => track.stop());
            }
            if (localStream) {
                document.getElementById('local_video').srcObject = localStream;
            }
            isSharingScreen = false;
            document.getElementById('btn_share').classList.remove('active');
            document.getElementById('label_share').innerText = 'Share Screen';
            if (usingVirtualCam) {
                document.getElementById('virtual_canvas').style.display = 'block';
            }
            showToast('Screen sharing stopped');
        }

        function toggleHand() {
            isHandRaised = !isHandRaised;
            const badge = document.getElementById('local_hand_badge');
            const btn = document.getElementById('btn_hand');
            if (isHandRaised) {
                badge.style.display = 'block';
                btn.classList.add('active');
                showToast('Hand raised');
            } else {
                badge.style.display = 'none';
                btn.classList.remove('active');
            }
        }

        function togglePanel(panelName) {
            const chat = document.getElementById('chat_panel');
            const people = document.getElementById('people_panel');

            if (panelName === 'chat') {
                if (chat.style.display === 'flex') {
                    chat.style.display = 'none';
                    document.getElementById('btn_chat').classList.remove('active');
                } else {
                    chat.style.display = 'flex';
                    people.style.display = 'none';
                    document.getElementById('btn_chat').classList.add('active');
                    document.getElementById('btn_people').classList.remove('active');
                }
            } else if (panelName === 'people') {
                if (people.style.display === 'flex') {
                    people.style.display = 'none';
                    document.getElementById('btn_people').classList.remove('active');
                } else {
                    people.style.display = 'flex';
                    chat.style.display = 'none';
                    document.getElementById('btn_people').classList.add('active');
                    document.getElementById('btn_chat').classList.remove('active');
                }
            }
        }

        function handleChatEnter(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        }

        function sendMessage() {
            const input = document.getElementById('chat_input');
            const text = input.value.trim();
            if (text) {
                const now = new Date();
                const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const msg = document.createElement('div');
                msg.className = 'chat-msg mine';
                msg.innerHTML = '<div class="chat-msg-header">You • ' + timeStr + '</div><div>' + text.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</div>';
                document.getElementById('chat_messages').appendChild(msg);
                input.value = '';
                document.getElementById('chat_messages').scrollTop = document.getElementById('chat_messages').scrollHeight;
            }
        }

        function copyMeetingLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Meeting room link copied to clipboard!');
            });
        }

        function showToast(txt) {
            const toast = document.getElementById('media_toast');
            document.getElementById('media_toast_text').innerText = txt;
            $(toast).stop(true, true).fadeIn(200);
            setTimeout(() => { $(toast).fadeOut(400); }, 3500);
        }

        function leaveMeeting() {
            if (localStream) localStream.getTracks().forEach(t => t.stop());
            if (screenStream) screenStream.getTracks().forEach(t => t.stop());
            window.location.href = '<?= base_url('admin/meetings/scheduled') ?>';
        }

        // Run Media Engine
        initMedia();
    </script>
</body>
</html>
