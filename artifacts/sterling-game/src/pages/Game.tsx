import React, { useEffect, useRef, useState } from 'react';
import { GameEngine } from '../lib/gameEngine';
import { GameRenderer } from '../lib/renderer';

export default function Game() {
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const engineRef = useRef<GameEngine>();
  const rendererRef = useRef<GameRenderer>();
  const requestRef = useRef<number>();

  useEffect(() => {
    if (!canvasRef.current) return;
    
    const canvas = canvasRef.current;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    engineRef.current = new GameEngine();
    rendererRef.current = new GameRenderer(ctx, canvas.width, canvas.height);

    // Add a test player
    engineRef.current.addObject({
      id: 'player',
      position: { x: 400, y: 100 },
      velocity: { x: 0, y: 0 },
      width: 50,
      height: 50,
      color: '#3b82f6',
      isStatic: false
    });

    // Add some floor blocks
    engineRef.current.addObject({
      id: 'floor1',
      position: { x: 0, y: 550 },
      velocity: { x: 0, y: 0 },
      width: 800,
      height: 50,
      color: '#4ade80',
      isStatic: true
    });

    const loop = (time: number) => {
      engineRef.current?.update(16);
      rendererRef.current?.render(engineRef.current!.state);
      requestRef.current = requestAnimationFrame(loop);
    };

    requestRef.current = requestAnimationFrame(loop);

    return () => {
      if (requestRef.current) cancelAnimationFrame(requestRef.current);
    };
  }, []);

  const handleTouch = (e: React.TouchEvent | React.MouseEvent) => {
    if (!engineRef.current) return;
    
    // Simple jump mechanic on tap
    const player = engineRef.current.state.objects.find(o => o.id === 'player');
    if (player) {
      player.velocity.y = -10;
    }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-slate-900 p-4">
      <div className="bg-white p-4 rounded-xl shadow-2xl">
        <canvas
          ref={canvasRef}
          width={800}
          height={600}
          onClick={handleTouch}
          onTouchStart={handleTouch}
          className="bg-slate-100 rounded-lg cursor-pointer touch-none"
        />
        <div className="mt-4 text-center text-slate-600">
          <p>Tap or click to jump!</p>
        </div>
      </div>
    </div>
  );
}
