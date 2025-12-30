<div class="pt-20">
    @if ($videoPath)
        <video id="fullscreenVideo" src="{{ $videoPath }}" autoplay loop controls style="width: 100vw; height: 100vh;"></video>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var video = document.getElementById('fullscreenVideo');
                
                if (video.requestFullscreen) {
                    video.requestFullscreen();
                } else if (video.webkitRequestFullscreen) {
                    video.webkitRequestFullscreen();
                } else if (video.msRequestFullscreen) {
                    video.msRequestFullscreen();
                }

                video.play();
            });
        </script>
    @else
        <p>No video available.</p>
    @endif
</div>
