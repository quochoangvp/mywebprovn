<!--
> Muaz Khan     - https://github.com/muaz-khan 
> MIT License   - https://www.webrtc-experiment.com/licence/
> Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>RecordRTC to PHP ® Muaz Khan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
        <meta name="author" content="Muaz Khan">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="stylesheet" href="https://cdn.webrtc-experiment.com/style.css">
        
        <style>
            audio {
                vertical-align: bottom;
                width: 10em;
            }

            video { vertical-align: top;max-width: 100%; }

            input {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                font-size: 2em;
                margin: .2em;
                width: 30%;
            }

            p, .inner { padding: 1em; }

            li {
                border-bottom: 1px solid rgb(189, 189, 189);
                border-left: 1px solid rgb(189, 189, 189);
                padding: .5em;
            }

            label {
                display: inline-block;
                width: 8em;
            }
        </style>
        <script>
            document.createElement('article');
            document.createElement('footer');
        </script>
        
        <!-- script used for audio/video/gif recording -->
        <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"> </script>
    </head>

    <body>
        <article>
            <header style="text-align: center;">
                <h1>
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a> to <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-to-PHP" target="_blank">PHP</a> ® 
                    <a href="https://github.com/muaz-khan" target="_blank">Muaz Khan</a>
                </h1>            
                <p>
                    <a href="https://www.webrtc-experiment.com/">HOME</a>
                    <span> &copy; </span>
                    <a href="http://www.MuazKhan.com/" target="_blank">Muaz Khan</a>
                    
                    .
                    <a href="http://twitter.com/WebRTCWeb" target="_blank" title="Twitter profile for WebRTC Experiments">@WebRTCWeb</a>
                    
                    .
                    <a href="https://github.com/muaz-khan?tab=repositories" target="_blank" title="Github Profile">Github</a>
                    
                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/issues?state=open" target="_blank">Latest issues</a>
                    
                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/commits/master" target="_blank">What's New?</a>
                </p>
            </header>

			<div class="github-stargazers"></div>
            
            <section class="experiment">  
                <h2 class="header">Record and POST to Server!</h2>
			
				<p style="text-align:center;">
					<video id="preview" controls style="border: 1px solid rgb(15, 158, 238); height: 240px; width: 320px;"></video> 
				</p>
				<hr />

				<button id="record">Record</button>
				<button id="stop" disabled>Stop</button>
				<button id="delete" disabled>Delete your webm/wav files from Server</button>

				<div id="container" style="padding:1em 2em;"></div>
            </section>
            
            <section class="experiment">  
                <h2 class="header">Try <a href="https://www.webrtc-experiment.com/RecordRTC/AudioVideo-on-Firefox.html">Audio+Video Recording on Firefox</a></h2>
                <ol>
                    <li>
                        <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/PHP-and-FFmpeg">RecordRTC / PHP / FFmpeg</a> (synced audio/video in single file!)
                    </li>
                    <li><a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-to-Nodejs" target="_blank">RecordRTC-to-Nodejs</a> (used ffmpeg to merge wav/webm in single WebM container)</li>
                    <li><a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-to-PHP" target="_blank">RecordRTC-to-PHP</a> (audio/video recording and uploading to server)</li>
                    <li><a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-to-ASPNETMVC" target="_blank">RecordRTC-to-ASP.NET MVC</a> (audio/video recording and uploading to server)</li>
                    <li><a href="https://www.webrtc-experiment.com/RecordRTC/Canvas-Recording/" target="_blank">Canvas Recording!</a> (webpage recording)</li>
                    <li><a href="https://www.webrtc-experiment.com/RecordRTC/MRecordRTC/" target="_blank">MRecordRTC and writeToDisk/getFromDisk!</a></li>
                    <li><a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-over-Socketio" target="_blank">RecordRTC-to-Socket.io</a> (used ffmpeg to merge wav/webm in single WebM container)</li>
                    <li><a href="https://www.webrtc-experiment.com/ffmpeg/" target="_blank">RecordRTC and ffmpeg-asm.js</a> (ffmpeg inside the browser!)</li>
                </ol>
            </section>
			
            <script>
                // PostBlob method uses XHR2 and FormData to submit 
                // recorded blob to the PHP server
                function PostBlob(blob, fileType, fileName) {
                    // FormData
                    var formData = new FormData();
                    formData.append(fileType + '-filename', fileName);
                    formData.append(fileType + '-blob', blob);

                    // progress-bar
                    var hr = document.createElement('hr');
                    container.appendChild(hr);
                    var strong = document.createElement('strong');
                    strong.id = 'percentage';
                    strong.innerHTML = fileType + ' upload progress: ';
                    container.appendChild(strong);
                    var progress = document.createElement('progress');
                    container.appendChild(progress);

                    // POST the Blob using XHR2
                    xhr('save.php', formData, progress, percentage, function(fileURL) {
                        container.appendChild(document.createElement('hr'));
                        var mediaElement = document.createElement(fileType);
                        
                        var source = document.createElement('source');
                        var href = location.href.substr(0, location.href.lastIndexOf('/') + 1);
                        source.src = href + fileURL;
                        
                        if(fileType == 'video') source.type = 'video/webm; codecs="vp8, vorbis"';
                        if(fileType == 'audio') source.type = !!navigator.mozGetUserMedia ? 'audio/ogg': 'audio/wav';
                        
                        mediaElement.appendChild(source);
                        
                        mediaElement.controls = true;
                        container.appendChild(mediaElement);
                        mediaElement.play();

                        progress.parentNode.removeChild(progress);
                        strong.parentNode.removeChild(strong);
                        hr.parentNode.removeChild(hr);
                    });
                }

                var record = document.getElementById('record');
                var stop = document.getElementById('stop');
                var deleteFiles = document.getElementById('delete');

                var audio = document.querySelector('audio');

                var recordVideo = document.getElementById('record-video');
                var preview = document.getElementById('preview');

                var container = document.getElementById('container');
                
                // if you want to record only audio on chrome
                // then simply set "isFirefox=true"
                var isFirefox = !!navigator.mozGetUserMedia;

                var recordAudio, recordVideo;
                record.onclick = function() {
                    record.disabled = true;
                    navigator.getUserMedia({
                            audio: true,
                            video: true
                        }, function(stream) {
                            preview.src = window.URL.createObjectURL(stream);
                            preview.play();

                            // var legalBufferValues = [256, 512, 1024, 2048, 4096, 8192, 16384];
                            // sample-rates in at least the range 22050 to 96000.
                            recordAudio = RecordRTC(stream, {
                                //bufferSize: 16384,
                                //sampleRate: 45000,
                                onAudioProcessStarted: function() {
                                    if(!isFirefox) {
                                        recordVideo.startRecording();
                                    }
                                }
                            });
                            
                            if(isFirefox) {
                                recordAudio.startRecording();
                            }
                            
                            if(!isFirefox) {
                                recordVideo = RecordRTC(stream, {
                                    type: 'video'
                                });
                                recordAudio.startRecording();
                            }

                            stop.disabled = false;
                        }, function(error) {
                            alert( JSON.stringify (error, null, '\t') );
                        });
                };

                var fileName;
                stop.onclick = function() {
                    record.disabled = false;
                    stop.disabled = true;
                    
                    preview.src = '';

                    fileName = Math.round(Math.random() * 99999999) + 99999999;
                    
                    if(!isFirefox) {
                        recordAudio.stopRecording(function() {
                            PostBlob(recordAudio.getBlob(), 'audio', fileName + '.wav');
                        });
                    }
                    else {
                        recordAudio.stopRecording( function(url) {
                            preview.src = url;
                            PostBlob(recordAudio.getBlob(), 'video', fileName + '.webm');
                        });
                    }

                    if(!isFirefox) {
                        recordVideo.stopRecording(function() {
                            PostBlob(recordVideo.getBlob(), 'video', fileName + '.webm');
                        });
                    }

                    deleteFiles.disabled = false;
                };

                deleteFiles.onclick = function() {
                    deleteAudioVideoFiles();
                };

                function deleteAudioVideoFiles() {
                    deleteFiles.disabled = true;
                    if (!fileName) return;
                    var formData = new FormData();
                    formData.append('delete-file', fileName);
                    xhr('delete.php', formData, null, null, function(response) {
                        console.log(response);
                    });
                    fileName = null;
                    container.innerHTML = '';
                }

                function xhr(url, data, progress, percentage, callback) {
                    var request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            callback(request.responseText);
                        }
                    };
                    
                    if(url.indexOf('delete.php') == -1) {
                        request.upload.onloadstart = function() {
                            percentage.innerHTML = 'Upload started...';
                        };
                        
                        request.upload.onprogress = function(event) {
                            progress.max = event.total;
                            progress.value = event.loaded;
                            percentage.innerHTML = 'Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%";
                        };
                        
                        request.upload.onload = function() {
                            percentage.innerHTML = 'Saved!';
                        };
                    }
                    
                    request.open('POST', url);
                    request.send(data);
                }

                window.onbeforeunload = function() {
                    if (!!fileName) {
                        deleteAudioVideoFiles();
                        return 'It seems that you\'ve not deleted audio/video files from the server.';
                    }
                };
            </script>
			
			<section class="experiment">
				<ol>
					<li>Both files are recorded and uploaded individually (wav/webm)</li>
					<li>You can merge/mux them in single format like avi or mkv — using tools like ffmpeg/avconv</li>
				</ol>
			</section>
        
            <section class="experiment">
                <h2 class="header" id="feedback">Feedback</h2>
                <div>
                    <textarea id="message" style="border: 1px solid rgb(189, 189, 189); height: 8em; margin: .2em; outline: none; resize: vertical; width: 98%;" placeholder="Have any message? Suggestions or something went wrong?"></textarea>
                </div>
                <button id="send-message" style="font-size: 1em;">Send Message</button><small style="margin-left: 1em;">Enter your email too; if you want "direct" reply!</small>
            </section>
			
			<section class="experiment">
				<h2>
					How to save recorded wav/webm file to PHP server?</h2>
				<ol>
					<li>Write a PHP file to write recrded blob on disk</li>
					<li>Write Javascript to POST recorded blobs to server using XHR2/FormdData</li>
				</ol>
			</section>
			
            <section class="experiment">
        <h2>PHP Code</h2>
        <pre>
&lt;?php
foreach(array('video', 'audio') as $type) {
    if (isset($_FILES["${type}-blob"])) {

        $fileName = $_POST["${type}-filename"];
        $uploadDirectory = "uploads/$fileName";

        if (!move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $uploadDirectory)) {
            echo("problem moving uploaded file");
        }

        echo($uploadDirectory);
    }
}
?&gt;
</pre>
            </section>
			<section class="experiment">
			<h2>Javascript Code</h2>
			<pre>
var fileType = 'video'; // or "audio"
var fileName = 'ABCDEF.webm';  // or "wav"

var formData = new FormData();
formData.append(fileType + '-filename', fileName);
formData.append(fileType + '-blob', blob);

xhr('save.php', formData, function (fName) {
    window.open(location.href + fName);
});

function xhr(url, data, callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            callback(location.href + request.responseText);
        }
    };
    request.open('POST', url);
    request.send(data);
}
</pre></section>
            <section class="experiment">
                <h2 class="header">
                    How to use <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>?</h2>
                <pre>
&lt;script src="https://www.webrtc-experiment.com/RecordRTC.js"&gt;&lt;/script&gt;
</pre>
            </section>
            <section class="experiment">
                <h2 class="header">
                    How to record audio using <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>?</h2>
                <pre>
var recordRTC = <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>(mediaStream);
recordRTC.<strong>startRecording</strong>();
recordRTC.<strong>stopRecording</strong>(function(<strong>audioURL</strong>) {
   window.open(audioURL);
});
</pre>

            </section>
		
		
            <section class="experiment">
                <h2 class="header">
                    How to record video using <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>?</h2>
                <pre>
var options = {
   <strong>type</strong>: 'video',
   <strong>video</strong>: {
      width: 320,
      height: 240
   },
   <strong>canvas</strong>: {
      width: 320,
      height: 240
   }
};
var recordRTC = <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>(mediaStream, options);
recordRTC.<strong>startRecording</strong>();
recordRTC.<strong>stopRecording</strong>(function(<strong>videoURL</strong>) {
   window.open(videoURL);
});
</pre>

            </section>
		
            <section class="experiment">
        
                <h2 class="header">
                    How to record animated GIF using <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>?</h2>
                <pre>
var options = {
   <strong>type</strong>: 'gif',
   <strong>video</strong>: {
      width: 320,
      height: 240
   },
   <strong>canvas</strong>: {
      width: 320,
      height: 240
   },
   <strong>frameRate</strong>: 200,
   <strong>quality</strong>: 10
};
var recordRTC = <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">RecordRTC</a>(mediaStream, options);
recordRTC.<strong>startRecording</strong>();
recordRTC.<strong>stopRecording</strong>(function(<strong>gifURL</strong>) {
   window.open(gifURL);
});
</pre>
            </section>
		
            <section class="experiment">
                <h2>
                    Possible <a href="https://github.com/muaz-khan/WebRTC-Experiment/issues" target="_blank">
                                 issues</a>/<a href="https://github.com/muaz-khan/WebRTC-Experiment/issues" target="_blank">failures</a>:
                </h2>
                <p>
                    The biggest issue is that RecordRTC is <strong>unable to record</strong> both audio and video streams in single file.<br /><br />
                    Do you know "RecordRTC" fails recording audio because following conditions fails:
                    <ol>
                        <li>Sample rate and channel configuration must be the same for input and output sides
                            on Windows i.e. audio input/output devices must match</li>
                        <li>Only the Default microphone device can be used for capturing.</li>
                        <li>The requesting scheme is must be one of the following: http, https, chrome, extension's,
                            or file (only works with --allow-file-access-from-files)</li>
                        <li>The browser must be able to create/initialize the metadata database for the API
                            under the profile directory</li>
                    </ol>
                </p>
            </section>
            <section class="experiment">
                <p>
                    RecordRTC is MIT licensed on Github! <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC" target="_blank">Documentation</a>
                </p>
            </section>
			
			<section class="experiment own-widgets latest-commits">
				<h2 class="header" id="updates" style="color: red;padding-bottom: .1em;"><a href="https://github.com/muaz-khan/WebRTC-Experiment/commits/master" target="_blank">Latest Updates</a></h2>
				<div id="github-commits"></div>
			</section>  
        </article>
        
        <a href="https://github.com/muaz-khan/WebRTC-Experiment/tree/master/RecordRTC/RecordRTC-to-PHP" class="fork-left"></a>
        
        <footer>
            <p>
                <a href="https://www.webrtc-experiment.com/">WebRTC Experiments</a>
                © <a href="https://plus.google.com/+MuazKhan" rel="author" target="_blank">Muaz Khan</a>
                <a href="mailto:muazkh@gmail.com" target="_blank">muazkh@gmail.com</a>
            </p>
        </footer>
    
        <!-- commits.js is useless for you! -->
        <script src="https://cdn.webrtc-experiment.com/commits.js" async> </script>
    </body>
</html>
