import { GameState, GameObject, Vector2 } from './types';

export class GameEngine {
  public state: GameState;
  private gravity: number = 0.5;
  private friction: number = 0.98;

  constructor() {
    this.state = {
      objects: [],
      score: 0,
      gameOver: false,
      isPaused: false
    };
  }

  public update(deltaTime: number) {
    if (this.state.isPaused || this.state.gameOver) return;

    for (const obj of this.state.objects) {
      if (obj.isStatic) continue;

      // Apply physics
      obj.velocity.y += this.gravity;
      
      obj.position.x += obj.velocity.x;
      obj.position.y += obj.velocity.y;

      // Apply friction
      obj.velocity.x *= this.friction;

      // Floor collision
      if (obj.position.y + obj.height > 600) {
        obj.position.y = 600 - obj.height;
        obj.velocity.y *= -0.5; // Bounce
      }
    }
  }

  public addObject(obj: GameObject) {
    this.state.objects.push(obj);
  }
}
