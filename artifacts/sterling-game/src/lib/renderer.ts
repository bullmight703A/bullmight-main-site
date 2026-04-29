import { GameState } from './types';

export class GameRenderer {
  private ctx: CanvasRenderingContext2D;
  private canvasWidth: number;
  private canvasHeight: number;

  constructor(ctx: CanvasRenderingContext2D, width: number, height: number) {
    this.ctx = ctx;
    this.canvasWidth = width;
    this.canvasHeight = height;
  }

  public render(state: GameState) {
    // Clear canvas
    this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);

    // Draw background
    this.ctx.fillStyle = '#f0f4f8';
    this.ctx.fillRect(0, 0, this.canvasWidth, this.canvasHeight);

    // Draw objects
    for (const obj of state.objects) {
      this.ctx.fillStyle = obj.color;
      this.ctx.fillRect(obj.position.x, obj.position.y, obj.width, obj.height);
      
      // Draw border
      this.ctx.strokeStyle = '#000000';
      this.ctx.lineWidth = 2;
      this.ctx.strokeRect(obj.position.x, obj.position.y, obj.width, obj.height);
    }

    // Draw UI
    this.ctx.fillStyle = '#333';
    this.ctx.font = '24px Arial';
    this.ctx.fillText(`Score: ${state.score}`, 20, 40);

    if (state.gameOver) {
      this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
      this.ctx.fillRect(0, 0, this.canvasWidth, this.canvasHeight);
      this.ctx.fillStyle = 'white';
      this.ctx.font = '48px Arial';
      this.ctx.textAlign = 'center';
      this.ctx.fillText('Game Over!', this.canvasWidth / 2, this.canvasHeight / 2);
    }
  }
}
