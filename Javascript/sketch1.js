var w = window.innerWidth;
var h = window.innerHeight;

var rad1, rad2;

var x1;
var y1;
var x2;
var y2;
var m;
var M;
var vmx;
var vmy;
var vMx;
var vMy;

function resize() {
  w = window.innerWidth;
  h = window.innerHeight;
  resizeCanvas(w, h);
}


function setup() {
  createCanvas(w, h);
  rad1 = random(20, 60);
  rad2 = random(20, 60);
  vmx = random(-5, 5);
  vmy = random(-5, 5);
  vMx = random(-5, 5);
  vMy = random(-5, 5);
  m = random(1, 5);
  M = random(1, 5);
  x1 = random(rad1, w - rad1);
  y1 = random(rad1, h - rad1);
  x2 = random(rad2, w - rad2);
  y2 = random(rad2, h - rad2);
  while (dist(x1, y1, x2, y2) < rad1 + rad2) {
    x2 = random(rad2, w - rad2);
    y2 = random(rad2, h - rad2);
  }
  ellipse(x1, y1, 2 * rad1, 2 * rad1);
  ellipse(x2, y2, 2 * rad2, 2 * rad2);
}



function draw() {
  resize();
  background(220);
  x1 = x1 + vmx;
  y1 = y1 + vmy;
  x2 = x2 + vMx;
  y2 = y2 + vMy;
  ellipse(x1, y1, 2 * rad1, 2 * rad1);
  ellipse(x2, y2, 2 * rad2, 2 * rad2);
  if (dist(x1, y1, x2, y2) < rad1 + rad2) {
    var temp1 = vmx;
    vmx = ((m - M) / (m + M)) * vmx + ((2 * M) / (m + M)) * vMx;
    vMx = ((2 * m) / (m + M)) * temp1 + ((M - m) / (m + M)) * vMx;

    var temp2 = vmy;
    vmy = ((m - M) / (m + M)) * vmy + ((2 * M) / (m + M)) * vMy;
    vMy = ((2 * m) / (m + M)) * temp2 + ((M - m) / (m + M)) * vMy;
  }
  if (x1 < rad1 || x1 > w - rad1) { vmx = (-1) * vmx; }
  if (y1 < rad1 || y1 > h - rad1) { vmy = (-1) * vmy; }
  if (x2 < rad2 || x2 > w - rad2) { vMx = (-1) * vMx; }
  if (y2 < rad2 || y2 > h - rad2) { vMy = (-1) * vMy; }
}