export interface Vector2 {
  x: number;
  y: number;
}

export interface GameObject {
  id: string;
  position: Vector2;
  velocity: Vector2;
  width: number;
  height: number;
  color: string;
  isStatic: boolean;
}

export interface GameState {
  objects: GameObject[];
  score: number;
  gameOver: boolean;
  isPaused: boolean;
}
