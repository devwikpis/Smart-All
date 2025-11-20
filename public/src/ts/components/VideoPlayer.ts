/**
 * Video Player Component
 * Handles custom video player with play button overlay
 */
export class VideoPlayer {
  private videoContainers: NodeListOf<Element>;

  constructor() {
    this.videoContainers = document.querySelectorAll('.info-service__video');
    this.init();
  }

  /**
   * Initialize video players
   */
  private init(): void {
    this.videoContainers.forEach((container) => {
      const video = container.querySelector('.info-service__video-player') as HTMLVideoElement;
      const playButton = container.querySelector('.info-service__video-play') as HTMLButtonElement;

      if (!video || !playButton) return;

      // Handle play button click
      playButton.addEventListener('click', () => {
        this.playVideo(video, playButton);
      });

      // Handle video ended
      video.addEventListener('ended', () => {
        this.resetVideo(video, playButton);
      });

      // Handle video pause
      video.addEventListener('pause', () => {
        if (video.currentTime === 0 || video.ended) {
          this.resetVideo(video, playButton);
        }
      });
    });
  }

  /**
   * Play video and show controls
   */
  private playVideo(video: HTMLVideoElement, playButton: HTMLButtonElement): void {
    video.play();
    video.setAttribute('controls', 'true');
    video.classList.add('playing');
    playButton.classList.add('hidden');
  }

  /**
   * Reset video to initial state
   */
  private resetVideo(video: HTMLVideoElement, playButton: HTMLButtonElement): void {
    video.removeAttribute('controls');
    video.classList.remove('playing');
    playButton.classList.remove('hidden');
  }
}
