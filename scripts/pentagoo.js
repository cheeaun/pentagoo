/*
 * Script: pentagoo.js - main code for the Pentagoo game
 * Author: Lim Chee Aun
 */

// Static variables
var SIZE = 6; // board size (width and length)
var SB_SIZE = 3; // subboard size
var WIN_LEN = 5; // number of straight marbles to indicate winning
var AI_URL = 'http://phoenity.com/pentagoo/pentagoo_ai.php';

// Global variables
var move_history; // move history
var last_marble_history; // last marble history
var current_history; // current pointer for history
var last_marble; // current last marble
var move; // 'p': place ; 'r': rotate
var game; // 0: not game yet ; 1: player 1 wins ; 2: player 2 wins ; 3: player 1 and 2 wins (draw)
var game_type; // 0: human VS human ; 1: human VS computer (vice versa) ; 2: computer VS computer
var player; // 1: player 1 ; 2: player 2
var player_type; // 1: human ; 2: computer
var computer_level; // computer levels
var board_matrix;
var board_matrix_copy;
var cmove = [];
var highlight_marble, highlight_rotate;
var board_state; // 0: board enabled state ; 1: disabled state
var move_state; // 0: place state ; 1: rotate state
var saved_game;

// Event load
window.addEvent('load', function() {
	initialize();
	generate_events();
	preload_stuff();
});

// Initial State
function initialize(){
	// Init values for saved/unsaved game variables
	board_matrix = [];
	for(var y=0; y<SIZE; y++){
		board_matrix[y] = [];
		for(var x=0; x<SIZE; x++)
			board_matrix[y][x] = 0;
	}
	move_history = [];
	last_marble_history = [];
	last_marble = null;
	game_type = 0;
	computer_level = [0,0];
	
	// Default values for variables
	game = 0;
	current_history = null;
	board_matrix_copy = [];
	highlight_marble = highlight_rotate = '00';
	board_state = 0;
	move_state = 0;

	// Set disabled links
	$('undo-link').addClass('disabled');
	$('history-link').addClass('disabled');

	// Clear all marbles
	$$('.subboard td').setProperty('class','space');

	// Open up the cover
	board_cover(false);

	// Set players
	player = 1;
	$('player-1-label').addClass('current');
	$('player-2-label').removeClass('current');
	player_type = 1;

	// Styles for rotation buttons
	$$('.rotation-buttons').setOpacity(0);

	// Styles for sub-boards
	$$('.subboard').setOpacity(1);

	// Styles for panels
	if(!window.ie) $$('.panel').setOpacity('.85');

	// Clear status
	set_status();
}

// Generate events
function generate_events(){
	// Links
	$('new-game-link').addEvent('click',function(){
		if(!this.hasClass('disabled')) slide_panel('new-game');
	});
	$('cancel-game-link').addEvent('click',function(){
		slide_panel('new-game');
	});
	$('start-game-link').addEvent('click',function(){
		slide_panel('new-game');
		new_game();
	});
	$('undo-link').addEvent('click',function(){
		if(!this.hasClass('disabled')){
			slide_panel();
			history_back('undo');
		}
	});
	$('history-link').addEvent('click',function(){
		if(!this.hasClass('disabled')) slide_panel('history');
	});
	$('history-start-link').addEvent('click',function(){
		if(!this.disabled) history_start();
	});
	$('history-back-link').addEvent('click',function(){
		if(!this.disabled) history_back();
	});
	$('history-forward-link').addEvent('click',function(){
		if(!this.disabled) history_forward();
	});
	$('history-end-link').addEvent('click',function(){
		if(!this.disabled) history_end();
	});
	$('close-history-link').addEvent('click',function(){
		if(!this.disabled){
			history_end();
			slide_panel('history');
		}
	});
	$('rules-link').addEvent('click',function(){
		if(!this.hasClass('disabled')) slide_panel('rules');
	});
	$('close-rules-link').addEvent('click',function(){
		slide_panel('rules');
	});
	$('download-link').addEvent('click',function(){
		if(!this.hasClass('disabled')) slide_panel('download');
	});
	$('close-download-link').addEvent('click',function(){
		slide_panel('download');
	});
	$('about-link').addEvent('click',function(){
		if(!this.hasClass('disabled')) slide_panel('about');
	});
	$('close-about-link').addEvent('click',function(){
		slide_panel('about');
	});

	// Board spaces
	$$('.subboard td').addEvent('click',function(){
		if(highlight_marble) $('s-'+highlight_marble).removeClass('highlight');
		var y = this.id.charAt(2).toInt();
		var x = this.id.charAt(3).toInt();
		place(x,y);
		highlight_marble = ''+y+x;
	}).addEvent('mousemove',function(){
		if(this.hasClass('space')){
			if(highlight_marble) $('s-'+highlight_marble).removeClass('highlight');
			var y = this.id.charAt(2);
			var x = this.id.charAt(3);
			highlight_marble = ''+y+x;
			$('s-'+highlight_marble).addClass('highlight');
		}
	}).addEvent('mouseleave',function(){
		if(highlight_marble) $('s-'+highlight_marble).removeClass('highlight');
	});

	// Rotation buttons
	$$('.rotate-left').each(function(elem,i){
		elem.addEvent('click',function(){
			rotate((i+1),'l');
		});
	});
	$$('.rotate-right').each(function(elem,i){
		elem.addEvent('click',function(){
			rotate((i+1),'r');
		});
	});
	$$('.rotate-left','.rotate-right').addEvent('mousemove',function(){
		if(highlight_rotate) $('rb-'+highlight_rotate).removeClass('highlight');
		var y = this.id.charAt(3);
		var x = this.id.charAt(4);
		highlight_rotate = ''+y+x;
		$('rb-'+highlight_rotate).addClass('highlight');
	}).addEvent('mouseleave',function(){
		if(highlight_rotate) $('rb-'+highlight_rotate).removeClass('highlight');
	});

	// Set keyboard shortcuts
	document.addEvent('keydown', function(e){
		var e = new Event(e);
		var arrows = ['up', 'down', 'left', 'right'];

		if(e.key == 'u'){
			e.stop();
			$('undo-link').fireEvent('click');
		}
		else if(arrows.contains(e.key)){
			e.stop();
			if(player_type == 1 && !game && board_state == 0){
				if(highlight_marble) $('s-'+highlight_marble).removeClass('highlight');
				if(highlight_rotate) $('rb-'+highlight_rotate).removeClass('highlight');

				if(move_state == 0){
					var y = highlight_marble.charAt(0).toInt();
					var x = highlight_marble.charAt(1).toInt();

					switch(e.key){
						case arrows[0]: (y==0) ? y=SIZE-1 : y--; break; // up
						case arrows[1]: (y==SIZE-1) ? y=0 : y++; break; // down
						case arrows[2]: (x==0) ? x=SIZE-1 : x--; break; // left
						case arrows[3]: (x==SIZE-1) ? x=0 : x++; break; // right
					}

					highlight_marble = ''+y+x;

					$('s-'+highlight_marble).addClass('highlight');
				}
				else{
					var y = highlight_rotate.charAt(0).toInt();
					var x = highlight_rotate.charAt(1).toInt();

					switch(e.key){
						case arrows[0]: (y==0) ? y=1 : y--; break; // up
						case arrows[1]: (y==1) ? y=0 : y++; break; // down
						case arrows[2]: (x==0) ? x=3 : x--; break; // left
						case arrows[3]: (x==3) ? x=0 : x++; break; // right
					}

					highlight_rotate = ''+y+x;

					$('rb-'+highlight_rotate).addClass('highlight');
				}
			}
		}
		else if(e.key == 'enter'){
			e.stop();
			if(player_type == 1 && !game && board_state == 0){
				if(highlight_marble) $('s-'+highlight_marble).removeClass('highlight');
				if(highlight_rotate) $('rb-'+highlight_rotate).removeClass('highlight');

				if(move_state == 0)
					$('s-'+highlight_marble).fireEvent('click');
				else
					$('rb-'+highlight_rotate).fireEvent('click');
			}
		}
	});
}

// Preload Stuff
function preload_stuff(){
	// Image paths
	var path = 'styles/images/';
	var images = [
		path + 'white-marble.png',
		path + 'black-marble.png',
		path + 'space-select.png',
		path + 'rotate-arrows.png',
		path + 'pentago-subboard-15deg.png',
		path + 'pentago-subboard-30deg.png',
		path + 'pentago-subboard-45deg.png',
		path + 'pentago-subboard-60deg.png',
		path + 'pentago-subboard-75deg.png',
		path + 'marble-select.png',
		path + 'pointer.png'
	];

	// Close the cover
	board_cover(true);

	// Preload images and loading status
	new Asset.images(images, {
		onProgress: function(i){
			var load_percent = Math.round((i+1)/images.length*100);
			if(!window.runtime && i < images.length) set_status('Loading... (' + load_percent + '%)');
		},
		onComplete: function(){
			set_status();
			board_cover(false);
		}
	});
}

// Slide panels
function slide_panel(panel){
	// Remove all 'focus' state first
	$$('#menu a').removeClass('focus');

	// Panel effects
	if(panel){
		var panel_effect = new Fx.Style(panel, 'width', {duration: 150});

		if($(panel).getStyle('width').toInt() == 0){
			// Add 'focus' to panel's link
			$(panel+'-link').addClass('focus');

			// Close the cover
			board_cover(true);
			
			// Pop sound
			if(window.runtime) pop_sound.play();

			panel_effect.start(520);
		}
		else{
			// Remove 'focus' to panel's link
			$(panel+'-link').removeClass('focus');

			// Open up the cover if not game
			if(!game) board_cover(false);

			panel_effect.start(0);
		}
	}

	// Select all panels except the CURRENT panel. Cool.
	var panels = $$('.panel[id!='+panel+']');

	// Styles for all panels
	panels.setStyle('width',0);
}

// New game
function new_game(){
	// Stop all timers EXCEPT the rotate effects timer
	cmove.each(function(move){$clear(move);});

	// Initialization
	initialize();

	// Set default players and game type
	game_type = 0;
	$('player-1-type').setText('Human');
	$('player-2-type').setText('Human');

	// Player selection & Computer levels
	if($('p1-c-l').checked){
		game_type = 1;
		player_type = 2;
		computer_level[0] = $('p1-cl').selectedIndex;
		$('player-1-type').setText('Computer');
		computer_move();
	}
	if($('p2-c-l').checked){
		computer_level[1] = $('p2-cl').selectedIndex;
		game_type = (game_type == 1) ? 2 : 1;
		$('player-2-type').setText('Computer');
	}
}

// Place marble
function place(x,y){
	var valid_move = move_place(x,y) && update_history(move+y+x);

	if(valid_move){
		// Check win
		check_win();

		if(!game && player_type == 1){
			// Show rotation buttons
			rotate_buttons(1);

			// Enable undo link if history is not empty
			if(move_history.length && game_type == 0)
				$('undo-link').removeClass('disabled');
		}
	}
}

// Place move
function move_place(x,y){
	move = 'p';
	var space = $('s-'+y+x);

	if(board_matrix[y][x] == 0){
		// Remove last highlighted marble
		if(last_marble) $('s-'+last_marble).removeClass('last');

		// Add the marble for current player
		board_matrix[y][x] = player;
		space.className = 'p'+player;

		// Indicate last marble
		last_marble = ''+y+x;
		space.addClass('last');
		
		// Place sound effect
		if(window.runtime) place_sound.play();

		return true;
	}

	return false;
}

// Unplace move - opposite of move_place
function move_unplace(x,y){
	var space = $('s-'+y+x);

	if(board_matrix[y][x] != 0){
		// Remove the marble for current player
		board_matrix[y][x] = 0;
		space.className = 'space';

		// Indicate last marble, using current_history
		last_marble = last_marble_history[current_history-1];
		if(last_marble) $('s-'+last_marble).addClass('last');

		return true;
	}

	return false;
}

// Rotate sub-board
function rotate(subboard, direction){
	// Close the cover
	board_cover(true);

	// Disable undo link
	$('undo-link').addClass('disabled');

	// Hide rotation buttons
	if(player_type == 1) rotate_buttons(0);

	var time = move_rotate(subboard, direction);

	(function(){
		// Update history
		var valid_move = update_history(move+subboard+direction);

		if(valid_move){
			// Check win
			check_win();

			if(!game){
				// Switch player
				switch_player();

				if(player_type == 1){
					if(game_type == 0){
						// Open up the cover
						board_cover(false);

						// Enable undo link
						$('undo-link').removeClass('disabled');
					}
					else if(game_type == 1){
						player_type = 2;
						computer_move();
					}
				}
				else if(player_type == 2){
					if(game_type == 1){
						player_type = 1;

						// Open up the cover
						board_cover(false);
					}
					else if(game_type == 2) computer_move();
				}
			}
		}
	}).delay(time);
}

// Rotate move
function move_rotate(subboard, direction){
	move = 'r';
	var matrix = []; // stores sub-board matrix
	var init_last = false; // flag to specify initialized last marble

	// Shift coordinates for specific subboards
	var sx = (subboard == 2 || subboard == 4) ? SB_SIZE : 0;
	var sy = (subboard == 3 || subboard == 4) ? SB_SIZE : 0;

	// Extract the subboard matrix
	for(var y=0; y<SB_SIZE; y++){
		matrix[y] = [];
		for(var x=0; x<SB_SIZE; x++)
			matrix[y][x] = board_matrix[y+sy][x+sx];
	}

	// Rotate and put back into the board matrix, also rotate the last marble
	if(direction == 'r'){
		for(var y=0 ; y<SB_SIZE ; y++ )
			for(var x=0 ; x<SB_SIZE ; x++ ){
				board_matrix[y+sy][x+sx] = matrix[(2-x)][y];

				if(last_marble == ''+(2-x+sy)+(y+sx) && !init_last){
					last_marble = ''+(y+sy)+(x+sx);
					init_last = true;
				}
			}
	}
	else if(direction == 'l'){
		for(var y=0 ; y<SB_SIZE ; y++ )
			for(var x=0 ; x<SB_SIZE ; x++ ){
				board_matrix[y+sy][x+sx] = matrix[x][(2-y)];

				if(last_marble == ''+(x+sy)+(2-y+sx) && !init_last){
					last_marble = ''+(y+sy)+(x+sx);
					init_last = true;
				}
			}
	}

	return subboard_rotation_fx(subboard,direction);
}

// Unrotate move - opposite of move_rotate
function move_unrotate(subboard, direction){
	// Reverse the rotation direction
	var reverse_direction = (direction == 'l') ? 'r' : 'l';

	return move_rotate(subboard, reverse_direction);
}

// Sub-board rotation effects
function subboard_rotation_fx(subboard, direction){
	var div = $('sb-'+subboard).getParent(); // parent element of the sub-board
	var FRAMES = 6; // number of rotation frames
	var PERIOD = 32; // frame period
	var opac; // opacity
	var mid_frame = FRAMES/2; // mid frame
	
	// Rotate sound effect
	if(window.runtime) rotate_sound.play();

	// Shift coordinates for specific quadrants
	var sx = (subboard == 2 || subboard == 4) ? SB_SIZE : 0;
	var sy = (subboard == 3 || subboard == 4) ? SB_SIZE : 0;

	// Sub-board rotation effects
	var k = 1;
	var rotate_bg = (function(){
		if(k == FRAMES){
			$clear(rotate_bg);

			// Clear subboard rotation image
			div.className = '';

			// Set back the subboard opacity
			$('sb-'+subboard).setOpacity(1);

			return;
		}
		else{
			// Set subboard rotation images
			div.className = 'subboard-' + ((direction == 'l') ? k : FRAMES-k);

			// Set opacity for sub-board (fading effect)
			opac = Math.abs(mid_frame-k)/mid_frame;
			$('sb-'+subboard).setOpacity(opac);

			// Rotate the marbles during half-time of animation
			if(k == Math.round(mid_frame)){
				for(var y=sy; y<SB_SIZE+sy; y++)
					for(var x=sx; x<SB_SIZE+sx; x++)
						$('s-'+y+x).className = (board_matrix[y][x]) ? 'p' + board_matrix[y][x] : 'space';
				// Indicate last marble
				if(last_marble) $('s-'+last_marble).addClass('last');
			}
		}

		k++;

	}).periodical(PERIOD);

	return PERIOD*FRAMES;
}

// Update history list after move and validation
function update_history(move_type){
	var last_index = move_history.length;
	var this_move = move_type.charAt(0);

	// The validation:
	// 1. Validate the moves
	//    a. history index is EVEN (0,2,4...) and the move is PLACE (p)
	//    b. history index is ODD (1,3,5...) and the move is ROTATE (r)
	// 2. Validate the current player, with the following algorithm:
	//    move_history index:    01 23 45 67 89  <-- last_index
	//    even_index        :    00 22 44 66 88
	//    linear_index      :    00 11 22 33 44
	//    player            :    11 22 11 22 11  <-- (last) current player
	var even_index = last_index - (last_index%2);
	var linear_index = even_index/2;
	var current_player = (linear_index%2) ? 2 : 1;

	// Start validation
	if(((last_index%2 == 0 && this_move == 'p') || (last_index%2 != 0 && this_move == 'r'))
		&& player == current_player){
		// Update move history
		move_history.push(move_type);

		// Update last marble history
		last_marble_history.push(last_marble);

		return true;
	}
	// Invalidity found
	else{
		// Close the cover
		board_cover(true);

		// Disable undo link
		$('undo-link').addClass('disabled');

		// Error status
		set_status('Sorry, an error has occured. Please start a new game.');

		return false;
	}
}

// Switch players
function switch_player(){
	if(player == 1){
		player = 2;
		$('player-2-label').addClass('current');
		$('player-1-label').removeClass('current');
	}
	else if(player == 2){
		player = 1;
		$('player-1-label').addClass('current');
		$('player-2-label').removeClass('current');
	}
}

// Toggle rotation buttons
function rotate_buttons(show){
	var rotation_button = $$('.rotation-buttons');
	var opac = rotation_button[0].getStyle('opacity');

	if(show && opac == 0){
		rotation_button.setOpacity('.4');
		move_state = 1;
	}
	else if(!show && opac > 0){
		rotation_button.setOpacity(0);
		move_state = 0;
	}
}

// Open/Close the cover on the board
function board_cover(state){
	var cover = $('board-cover');

	cover.setStyle('z-index', (state) ? 100 : 0);
	board_state = (state) ? 1 : 0;
}

// The starting point of history
function history_start(){
	if(current_history != -1){
		// Set pointer to history
		current_history = -1;

		// Clear status
		set_status();

		// Disable all other menu links except history link
		$$('#menu a[id!=history-link]').addClass('disabled');

		// Back from a win-state game
		if(game){
			game = 0;

			// Backup board matrix
			if(!board_matrix_copy.length)
				for(var y=0; y<SIZE; y++){
					board_matrix_copy[y] = [];
					for(var x=0; x<SIZE; x++)
						board_matrix_copy[y][x] = board_matrix[y][x];
				}
		}

		// Clear board matrix and all marbles
		for(var y=0; y<SIZE; y++)
			for(var x=0; x<SIZE; x++)
				board_matrix[y][x] = 0;

		// Clear all marbles
		$$('.subboard td').setProperty('class','space');

		// Set current player
		player = 1;
		$('player-1-label').addClass('current');
		$('player-2-label').removeClass('current');

		// Update visual history pointer
		update_history_pointer();
	}
}

// Back to the past (in history), including undo
function history_back(action){
	// Set pointer to history
	var current_action;
	if(action == 'undo'){
		current_history = move_history.length-1; // to be used for move_unplace
		current_action = move_history.getLast();
	}
	else{
		if(current_history == null) current_history = move_history.length-1;
		current_action = move_history[current_history];
	}

	if(current_action && current_history != null){
		var prev_game;

		// Clear status
		set_status();

		// Disable undo link
		$('undo-link').addClass('disabled');

		if(!$defined(action)){
			// Disable history buttons
			$$('.history-buttons button').setProperty('disabled','disabled');

			// Disable all other menu links except history link
			$$('#menu a[id!=history-link]').addClass('disabled');
		}

		// Get move properties
		var move_type = current_action.split('');
		var this_move = move_type[0];
		var move_action1 = move_type[1];
		var move_action2 = move_type[2];

		// Back from a win-state game
		if(game){
			game = 0;
			prev_game = 1;

			// Remove all winning marbles
			$$('.subboard td').removeClass('win');

			if(action == "undo"){
				// Open up the cover
				board_cover(false);

				// Disable history link
				 $('history-link').addClass('disabled');
			}
			// Backup board matrix
			else if(!board_matrix_copy.length){
				for(var y=0; y<SIZE; y++){
					board_matrix_copy[y] = [];
					for(var x=0; x<SIZE; x++)
						board_matrix_copy[y][x] = board_matrix[y][x];
				}
			}

			// Set current player because when 'game', current player is removed
			$('player-'+player+'-label').addClass('current');
		}

		// Execute the 'un'-move
		if(this_move == 'p'){
			var y = move_action1.toInt();
			var x = move_action2.toInt();

			var valid_move = move_unplace(x,y);

			if(valid_move){
				if(action == 'undo'){
					// Hide rotation buttons
					rotate_buttons(0);

					// Enable undo link
					$('undo-link').removeClass('disabled');
				}
				else
					// Enable history buttons
					$$('.history-buttons button').removeProperty('disabled');
			}
		}
		else if(this_move == 'r'){
			var t = move_action1.toInt();
			var d = move_action2;

			var time = move_unrotate(t,d);

			(function(){
				// Switch player
				if(!prev_game) switch_player();

				if(action == 'undo'){
					// Show rotation buttons
					rotate_buttons(1);

					// Enable undo link
					$('undo-link').removeClass('disabled');
				}
				else
					// Enable history buttons
					$$('.history-buttons button').removeProperty('disabled');
			}).delay(time);
		}
		
		if(action == "undo"){
			// Clear history pointer
			current_history = null;

			// Remove last history item after undo
			move_history.pop();
			last_marble_history.pop();
			
			// Disable undo link if history is empty
			if(!move_history.length) $('undo-link').addClass('disabled');
		}
		// Update pointer to history list after back
		else if(current_history >= 0)
			current_history--;

		// Update visual history pointer
		update_history_pointer();
	}
}

// Forward to the future (in history)
function history_forward(){
	// Sets pointer to history
	var last_index = move_history.length-1;
	if(current_history != null && current_history < last_index) current_history++;
	var current_action = move_history[current_history];

	if(current_action && current_history != null){
		// Clear status
		set_status();

		// Disable all other menu links except history link
		$$('#menu a[id!=history-link]').addClass('disabled');

		// Disables history buttons
		$$('.history-buttons button').setProperty('disabled','disabled');

		// Get move properties
		var move_type = current_action.split('');
		var this_move = move_type[0];
		var move_action1 = move_type[1];
		var move_action2 = move_type[2];

		// Executes the move
		if(this_move == 'p'){
			var y = move_action1.toInt();
			var x = move_action2.toInt();

			var valid_move = move_place(x,y);

			if(valid_move){
				// Check win
				check_win();

				// Clear history pointer
				if(game) current_history = null;

				// Enable history buttons
				$$('.history-buttons button').removeProperty('disabled');
			}
		}
		else if(this_move == 'r'){
			var t = move_action1.toInt();
			var d = move_action2;

			var time = move_rotate(t,d);

			(function(){
				// Check win
				check_win();

				// Clear history pointer
				if(game) current_history = null;
				// Switch player
				else switch_player();

				// Enable history buttons
				$$('.history-buttons button').removeProperty('disabled');
			}).delay(time);
		}

		// Update visual history pointer
		update_history_pointer();
	}
}

// The ending point of history
function history_end(){
	if(board_matrix_copy.length){
		// Copy back the original matrix
		for(var y=0; y<SIZE; y++)
			for(var x=0; x<SIZE; x++){
				board_matrix[y][x] = board_matrix_copy[y][x];
				$('s-'+y+x).className = board_matrix[y][x] ? 'p' + board_matrix[y][x] : 'space';
			}

		// Clear the matrix copy
		board_matrix_copy = [];

		// Clear history pointer
		current_history = null;

		// Check win so that winning marbles are highlighted
		// move is assigned so that a draw can be determined as well
		move = (move_history.getLast().charAt(0) == 'r') ? 'r' : 'p';
		check_win();

		// Enable all menu links including undo link if no computers
		$$('#menu a').removeClass('disabled');
		if(game_type>0) $('undo-link').addClass('disabled');

		// Set back current player using the algorithm from update_history
		var last_index = move_history.length-1;
		var even_index = last_index - (last_index%2);
		var linear_index = even_index/2;
		player = (linear_index%2) ? 2 : 1;

		// Update visual history pointer
		update_history_pointer();
	}
}

// Update visual pointer to history bar
function update_history_pointer(){
	if(current_history == null)
		$('history-pointer').setStyle('left','100%');
	else{
		var pointer_position = (current_history+1)/move_history.length * 100;
		$('history-pointer').setStyle('left',pointer_position+'%');
	}
}

// History play
var play_steps;
function history_play(state){
	var PERIOD = 1000;

	if(state && current_history != null)
		play_steps = history_forward.periodical(PERIOD);
	else
		$clear(play_steps);
}

// Check winnnings or draws
function check_win(){
	var check_points = SIZE - WIN_LEN + 1;

	// Check all horizontal and vertical wins
	for(var i=0; i<SIZE; i++)
		for(var j=0; j<check_points; j++){
			check_winning_marbles(j,i,'horizontal');
			check_winning_marbles(i,j,'vertical');
		}

	// Check diagonal wins
	for(var k=0; k<check_points; k++)
		for(var l=0; l<check_points; l++){
			check_winning_marbles(k,l,'l-diagonal');
			check_winning_marbles((k+4),l,'r-diagonal');
		}

	// Check for draw game, after the player rotates
	var draw = (move == 'r' && !board_matrix.toString().contains(0)) ? 1 : 0;
	if(draw && !game) game = 4;

	// Update game status
	var status;
	switch(game){
		case 1: status = 'Player 1 wins!'; break;
		case 2: status = 'Player 2 wins!'; break;
		case 3: status = 'Player 1 and 2 wins! A draw?'; break;
		case 4: status = 'It\'s a draw!'; break;
	}

	if(game){
		// Display game status
		set_status(status);

		// Close the cover
		board_cover(true);

		// Remove last highlighted marble
		if(last_marble) $('s-'+last_marble).removeClass('last');

		// Hide current player states
		$('player-2-label').removeClass('current');
		$('player-1-label').removeClass('current');

		// Enable history link
		$('history-link').removeClass('disabled');
		
		// Enable undo link
		if(game_type == 0) $('undo-link').removeClass('disabled');
	}
}

// Check validity for 5 straight marbles
function check_winning_marbles(x,y, direction){
	var valid = false; // flag for valid straight same marbles
	var state = board_matrix[y][x];

	if(state){
		// Check for all directions
		switch(direction){
			case 'horizontal':
				for(var i=1; i<WIN_LEN && (valid = board_matrix[y][x+i] == state); i++);

				if(valid)
					for(var j=x; j<x+WIN_LEN; j++)
						$('s-'+y+j).addClass('win');
				break;

			case 'vertical':
				for(var i=1; i<WIN_LEN && (valid = board_matrix[y+i][x] == state); i++);

				if(valid)
					for(var j=y; j<y+WIN_LEN; j++)
						$('s-'+j+x).addClass('win');
				break;

			case 'l-diagonal':
				for(var i=1; i<WIN_LEN && (valid = board_matrix[y+i][x+i] == state); i++);

				if(valid)
					for(var j=y, k=x; j<y+WIN_LEN && k<x+WIN_LEN; j++, k++)
						$('s-'+j+k).addClass('win');
				break;

			case 'r-diagonal':
				for(var i=1; i<WIN_LEN && (valid = board_matrix[y+i][x-i] == state); i++);

				if(valid)
					for(var j=y, k=x; j<y+WIN_LEN && k>x-WIN_LEN; j++, k--)
						$('s-'+j+k).addClass('win');
				break;
		}

		if(valid){
			// Define the winning game
			if(state == 1)
				game = (game == 2) ? 3 : 1;
			else if(state == 2)
				game = (game == 1) ? 3 : 2;
		}
	}
}

// Status display
function set_status(text){
	if($defined(text)) {
		$('status').setText(text);
		$('status').setStyle('visibility','visible');
		if(window.runtime) status_sound.play();
	}
	else{
		$('status').empty();
		$('status').setStyle('visibility','hidden');
	}
}

// Computer move
function computer_move(){
	var TIME = 1000;

	// Close the cover
	board_cover(true);
	
	var dummy = $time() + $random(0, 100); // from http://demos.mootools.net/Ajax_Timed

	if(player_type == 2){
		// Convert board matrix into a string
		var matrix = board_matrix.toString().replace(/\,/g,'');
		
		// AI parameters
		ai_parameters = Object.toQueryString({
			'm': matrix,
			'p': player,
			'ai': 0,
			'l': computer_level[player-1]
		});
		
		// Request AI's moves
		new Ajax(AI_URL + '?' + ai_parameters,
		{
			method: 'get',
			onComplete: function(response){
				var rmove = response.split(''); //x,y,t,d

				cmove[0] = (function(){
					// Computer place
					place(rmove[0].toInt(),rmove[1].toInt()); // x,y
					if(window.runtime) document.fireEvent('click');

					if(!game)
						cmove[1] = (function(){
							// Computer rotate
							rotate(rmove[2].toInt(),rmove[3]); // t,d
						}).delay(TIME,rmove);
				}).delay(TIME,rmove);
			}
		}).request(dummy);
	}
}

// Debug
function debug(text){
	var sitejunks = new Element('div',{'id':'debug'}).injectInside(document.body);
	(function(){
		sitejunks.setText(text);
	}).periodical(1000);
}