// orbWorker.js
let canvas, ctx;
let ww, wh, camera;
let STARS = [];
const MAX_STARS = 152;
const SEPARATION = 1.4;
let time = 0;
let devicePixelRatio = 1;

class Vector {
  constructor(x, y, z) {
    this.x = x;
    this.y = y;
    this.z = z;
  }
  rotate(dir, ang) {
    const { x: X, y: Y, z: Z } = this;
    const SIN = Math.sin(ang);
    const COS = Math.cos(ang);

    if (dir === "x") {
      this.y = Y * COS - Z * SIN;
      this.z = Y * SIN + Z * COS;
    } else if (dir === "y") {
      this.x = X * COS - Z * SIN;
      this.z = X * SIN + Z * COS;
    }
  }
  project() {
    const ZP = this.z + camera.z;
    const DIV = ZP / wh;
    const XP = (this.x + camera.x) / DIV;
    const YP = (this.y + camera.y) / DIV;
    return [XP + ww / 2, YP + wh / 2, ZP];
  }
}

class Char {
  constructor(letter, pos) {
    this.letter = letter;
    this.pos = pos;
    this.start = Math.random() * 1000;
  }
  rotate(dir, ang) {
    this.pos.rotate(dir, ang);
  }
  render() {
    const PIXEL = this.pos.project();
    const XP = PIXEL[0];
    const YP = PIXEL[1];
    // const MAX_SIZE = 50 / devicePixelRatio;
    const MAX_SIZE = ww / 15;
    const SIZE = (1 / PIXEL[2] * MAX_SIZE) | 0;
    const BRIGHTNESS = SIZE / MAX_SIZE;
    const COL = `rgba(255, 255, ${255 * BRIGHTNESS | 0 + 150}, ${BRIGHTNESS * BRIGHTNESS})`;

    const skewX = this.pos.x * this.pos.x * this.pos.x;
    const skewY = this.pos.y * this.pos.y * this.pos.y;

    ctx.save();
    let anim = ((time + this.start) % 10) / 5;
    anim = anim > 1 ? 2 - anim : anim;
    anim = anim * anim * anim;
    let starGradient = ctx.createRadialGradient(XP, YP, 0, XP, YP, SIZE * anim);
    starGradient.addColorStop(0, COL);
    starGradient.addColorStop(1, `hsla(360, 100%, 100%, 0)`);
    ctx.fillStyle = starGradient;
    ctx.beginPath();
    ctx.arc(XP, YP, SIZE, 0, 2 * Math.PI);
    ctx.fill();

    ctx.beginPath();
    ctx.fillStyle = COL;
    drawStar(ctx, XP, YP, Math.max(MAX_SIZE * 0.1, SIZE / 3 * anim), this.start + time % 1000 / 1000);
    ctx.restore();
  }
}

function drawStar(ctx, x, y, r, a) {
  ctx.save();
  ctx.translate(x, y);
  ctx.beginPath();
  ctx.rotate((Math.PI * 2) * a);
  ctx.moveTo(r, 0);
  for (let i = 0; i < 9; i++) {
    ctx.rotate(Math.PI / 5);
    if (i % 2 === 0) {
      ctx.lineTo((r / 0.525731) * 0.200811, 0);
    } else {
      ctx.lineTo(r, 0);
    }
  }
  ctx.closePath();
  ctx.fill();
  ctx.restore();
}

function update() {
  //ctx.clearRect(0, 0, ww, wh);

  const centerX = ww / 2;
  const centerY = wh / 2;
  const radius = Math.min(ww / 2, wh / 2);
  let anim = (time % 20 / 10);
  anim = anim > 1 ? 2 - anim : Math.max(anim, 0.001);
  const deepBlue = 32 + (36 * anim);
  ctx.restore();
  ctx.beginPath();
  ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
  ctx.save();
  ctx.clip();
  
  ctx.beginPath();
  ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
  let palantirGradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, Math.max(radius*0.5, radius * anim * 1.5));
  palantirGradient.addColorStop(0, "#640909b7");
  palantirGradient.addColorStop(1, `rgba(27, 13, ${deepBlue}, 1.0)`);
  ctx.fillStyle = palantirGradient;
  ctx.fill();

  ctx.beginPath();
  ctx.strokeStyle = `rgba(0,0,0,1.0)`;
  ctx.lineWidth = ww / 33;
  ctx.arc(centerX, centerY, radius-(ww / 66), 0, 2 * Math.PI);
  ctx.stroke();

  for (let i = 0; i < STARS.length; i++) {
    const DX = 0.001 * Math.sin(time * 0.001);
    const DY = 0.001 * Math.cos(time * 0.001);
    STARS[i].rotate("x", DX);
    STARS[i].rotate("y", DY);
  }

  ctx.beginPath();
  let specGradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, radius * 0.9);
  specGradient.addColorStop(0.95, `rgba(255, 255, 255, 0)`);
  specGradient.addColorStop(1, `rgba(255, 255, 255, 0.5)`);
  ctx.fillStyle = specGradient;
  ctx.arc(centerX, centerY, radius * 0.9, -Math.PI / 2.5, -Math.PI / 7);
  ctx.fill();

  ctx.beginPath();
  let spec2Gradient = ctx.createRadialGradient(centerX + (radius * 0.5), centerY - (radius * 0.5),
    0, centerX + (radius * 0.25), centerY - (radius * 0.25), radius);
  spec2Gradient.addColorStop(0, `rgba(255, 255, 255, 0.1)`);
  spec2Gradient.addColorStop(0.5, `rgba(255, 255, 255, 0.2)`);
  spec2Gradient.addColorStop(1, `rgba(0, 0, 55, 0.2)`);
  ctx.fillStyle = spec2Gradient;
  ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
  ctx.fill();

  ctx.beginPath();
  let edgeGradient = ctx.createRadialGradient(centerX, centerY + (radius * 0.2), 0, centerX, centerY, radius);
  edgeGradient.addColorStop(0.9, `rgba(0, 0, 0, 0)`);
  edgeGradient.addColorStop(1, `rgba(0, 0, 33, 0.5)`);
  ctx.fillStyle = edgeGradient;
  ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
  ctx.fill();

  
  ctx.beginPath();
  ctx.strokeStyle = `rgba(255,255,255,0.66)`;
  ctx.lineWidth = ww / 50;
  ctx.arc(centerX, centerY, radius-(ww / 100), 0, 2 * Math.PI);
  ctx.stroke();

  //time = performance.now() / 1000;
}

let fpsLastTime = 0;
let frameCount = 0;
let lastFrameTime = 0;
const targetFPS = 60;
const frameDuration = 1000 / targetFPS;
function render() {
  for (let i = 0; i < STARS.length; i++) {
    if (STARS[i].pos.project()[2] > 0) {
      STARS[i].render();
    }
  }
}

function loop(now = performance.now()) {
  if (now - lastFrameTime >= frameDuration) {
    const delta = (now - lastFrameTime) / 1000;
    lastFrameTime = now;
    time += delta;
    update();
    render();
  }
  // Debug: log FPS every 2 seconds
  frameCount++;
  if (now - fpsLastTime > 2000) {
    const fps = (frameCount / ((now - fpsLastTime) / 1000)).toFixed(1);
    //console.log(`FPS: ${fps}`);
    fpsLastTime = now;
    frameCount = 0;
  }

  requestAnimationFrame(loop);
}
function signedRandom() {
  return Math.random() - Math.random();
}

function createSTARS() {
  for (let i = 0; i < MAX_STARS; i++) {
    const CHARACTER = "✦";
    const X = signedRandom() * SEPARATION;
    const Y = signedRandom() * SEPARATION;
    const Z = signedRandom() * SEPARATION;
    const POS = new Vector(X, Y, Z);
    const CHAR = new Char(CHARACTER, POS);
    STARS.push(CHAR);
  }
}

function initCamera() {
  camera = new Vector(0, 0, SEPARATION + 1);
}

// Receive canvas and dimensions
onmessage = function (e) {
  const { type, canvas: offscreenCanvas, width, height, pixelRatio  } = e.data;

  if (type === 'init') {
    canvas = offscreenCanvas;
    ctx = canvas.getContext('2d');
    devicePixelRatio = e.data.pixelRatio;
    setup(e.data);
  }

  if (type === 'resize') {
    resizeCanvas(e.data);
    render();
  }
};

function setup({ width, height, pixelRatio }) {
  canvas.width = width;
  canvas.height = height;
  ctx.scale(pixelRatio, pixelRatio);

  // rest of your init:
  ww = (width) / pixelRatio;
  wh = (height) / pixelRatio;
  initCamera();
  createSTARS();
  loop();
}

function resizeCanvas({width, height, pixelRatio}) {
  canvas.width = width * pixelRatio;
  canvas.height = height * pixelRatio;

  ctx.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);

  ww = width / pixelRatio;
  wh = height / pixelRatio;
}