var w = window.innerWidth;
var h = window.innerHeight;
var fr = 300, rad = 10, x, y, vx, vy, r = 0, g = 0, b = 0, rspeed, gspeed, bspeed;

function resize() {
  w = window.innerWidth;
  h = window.innerHeight;
  resizeCanvas(w, h);
}

function setup() {
  createCanvas(w, h);
  frameRate(fr);
  //rad = random(1,400);
  x = random(rad / 2, w - rad / 2);
  y = random(rad / 2, h - rad / 2);
  vx = random(-10, 10);
  vy = random(-10, 10);
  rspeed = random(0, 5);
  gspeed = random(0, 5);
  bspeed = random(0, 5);
  noStroke();
  background(220);
  fill(r, g, b);
  ellipse(x, y, rad, rad);
}

function draw() {
  //resize(); resize afuchebs backgrounds
  x = x + vx;
  y = y + vy;
  ellipse(x, y, rad, rad);
  if (x < rad / 2 || x > w - rad / 2) { vx = (-1) * vx; }
  if (y < rad / 2 || y > h - rad / 2) { vy = (-1) * vy; }
  r = r + rspeed;
  g = g + gspeed;
  b = b + bspeed;
  if (r <= 0 || r >= 255) { rspeed = rspeed * (-1); }
  if (g <= 0 || g >= 255) { gspeed = gspeed * (-1); }
  if (b <= 0 || b >= 255) { bspeed = bspeed * (-1); }
  fill(r, g, b);
}