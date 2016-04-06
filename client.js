// Draw a set of dots to the canvas

function drawDots(dots) {
  for (var i=0; i<dots.length; i++) drawDot(dots[i][0], dots[i][1]);
}

// Draw a dot to the canvas

function drawDot(x, y) {
  stimulus_context.beginPath();
  stimulus_context.arc(x, y, 10, 0, 2 * Math.PI, false);
  stimulus_context.fillStyle = 'black';
  stimulus_context.fill();
  stimulus_context.lineWidth = 1;
  stimulus_context.strokeStyle = 'black';
  stimulus_context.stroke();
}

// Generate a set of non-overlapping dots

function generateDots(n) {
  var dots = [];
  while (dots.length < n) {
    var candidate_dot = [Math.floor(Math.random() * 480) + 10, Math.floor(Math.random() * 480) + 10];
    for (var i=0; i<dots.length; i++) if (euclidianDistance(dots[i], candidate_dot) < 20) break;
    if (i == dots.length) dots.push(candidate_dot);
  }
  return dots;
}

// Calculate the Euclidean distance between two points

function euclidianDistance(a, b) {
  return Math.sqrt(Math.pow(a[0] - b[0], 2) + Math.pow(a[1] - b[1], 2));
}

// Generate a random order in which to do the trials

function generateTrialOrder() {
  var array = [1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 9, 9, 9, 9, 9];
  var temp, index;
  var n = array.length;
  while (n > 0) {
    index = Math.floor(Math.random() * n);
    n--;
    temp = array[n];
    array[n] = array[index];
    array[index] = temp;
  }
  return array;
}

// Present a new trial

function newTrial() {
  if (trial_num == targets.length) {
    endExperiment();
  }
  else {
    var dots = generateDots(targets[trial_num]);
    drawDots(dots);
    start_time = Date.now();
    trial_num ++;
    accept_input = true;
    setTimeout(function() {
      stimulus_context.clearRect(0, 0, 500, 500);
    }, 200);
  }
}

// Translate keycode to number

function determineKeyPress(keycode) {
  switch (keycode) {
    case 49: return 1;
    case 50: return 2;
    case 51: return 3;
    case 52: return 4;
    case 53: return 5;
    case 54: return 6;
    case 55: return 7;
    case 56: return 8;
    case 57: return 9;
  }
  return 0;
}

// End the experiment and submit the results to the server

function endExperiment() {
  var targets_json = JSON.stringify(targets);
  var responses_json = JSON.stringify(responses);
  var reactions_json = JSON.stringify(reactions);
  window.location.replace('?submit=true&id=' + id + '&targets=' + targets_json + '&responses=' + responses_json + '&reactions=' + reactions_json);
}

// ------------------------------------------------------
// Globals
// ------------------------------------------------------

// Set up the stimulus canvas
var stimulus_canvas = document.getElementById('stimulus_canvas');
var stimulus_context = stimulus_canvas.getContext('2d');

var targets = generateTrialOrder(); // Generate a random trial order
var trial_num = 0; // Current trial number
var accept_input = false; // Allow keyboard input
var responses = []; // Store number entries
var reactions = []; // Store reaction times
var start_time, id; // Initialize start_time and id variables

// ------------------------------------------------------
// Event handlers
// ------------------------------------------------------

// Listen for keyboard input when input is allowed

$(document).keypress( function(event) {
  if (accept_input == true) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    var response = determineKeyPress(keycode);
    if (response > 0) {
      accept_input = false;
      var reaction = Date.now() - start_time;
      responses.push(response);
      reactions.push(reaction);
      setTimeout(function() {
        newTrial();
      }, 500);
    }
  }
});

$('#enter_experiment').on('click', function() {
  id = $('#id').val();
  if (id.length > 4) {
    $('#entry').css('visibility', 'hidden');
    $('#instructions').css('visibility', 'visible');
  }
});

$('#start_experiment').on('click', function() {
  $('#experiment').css('visibility', 'visible');
  $('#instructions').css('visibility', 'hidden');
  setTimeout(function() {
    newTrial();
  }, 1000);
});

$('#id').focus();
