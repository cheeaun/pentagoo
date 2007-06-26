var history_list; // history buffer
var move; // 1: place ; 2: rotate
var game; // 0: not game yet ; 1: player 1 wins ; 2: player 2 wins ; 3: player 1 and 2 wins ; 4: draw
var game_type; // 0: human VS human ; 1: human VS computer (vice versa) ; 2: computer VS computer

// Event load
window.addEvent('load', function() {
	generate_markup();
	initial();
	preload_stuff();
});

// Generate markup
function generate_markup(){
	$$('.panel').setStyle('height','0');
	$$('.panel').setOpacity('0');

	$('new-game').innerHTML += '<p class="panel-button"><a href="javascript:newgame();"><strong>Start Game</strong></a> <a href="javascript:slide_panel(\'new-game\');">Cancel</a></p>';

	$('about').innerHTML += '<p class="panel-button"><a href="javascript:slide_panel(\'about\');">Close</a></p>';

	$('history').innerHTML = '<h2>History</h2><div class="section"><ol id="history-list"></ol></div>';
	$('history').innerHTML += '<p class="panel-button"><a href="javascript:slide_panel(\'history\');">Close</a></p>';

	for(var m=0; m<6; m++)
		for(var n=0; n<6; n++){
			$('c'+m+n).className = 'hole';
			$('c'+m+n).onclick = function(){place(this);};
		}
}

// Initial State
function initial(){
	game = 0;
	game_type = 0;
	history_list = [];
	generate_history();

	board_cover(false);

	$('player-1').checked = true;
	$('player-1-label').setStyle('font-size', '4em');
	$('player-2-label').setStyle('font-size', '1.2em');

	$$('.rotation-buttons').setOpacity(0);
	$$('.rotation-buttons').setStyle('z-index','3');

	$$('.table-block').setOpacity(1);

	display_status('');
}

// Preload Stuff
function preload_stuff(){
	var path = 'images/';
	var images = [
		path + 'pentago-subboard-15deg.png',
		path + 'pentago-subboard-30deg.jpg',
		path + 'pentago-subboard-45deg.png',
		path + 'pentago-subboard-60deg.jpg',
		path + 'pentago-subboard-75deg.png'
	];

	new Asset.images(images, {
		onProgress: function(){
			display_status('Loading...');
//			board_cover(true);
		}/*,
		onComplete: function(){
			board_cover(false);
		}*/
	});
}

// Slide panels
function slide_panel(panel){
	var panel_effect = $(panel).effects({duration: 200, onComplete:function(){$(panel).setStyle('overflow','auto');}});

	// all panels except the CURRENT panel. Cool.
	var panels = $$('.panel[id!='+panel+']');

	panels.setStyle('height','0');
	panels.setOpacity('0');
	panels.setStyle('overflow','hidden');

	$$('#menu a').removeClass('focus');

	$(panel).setStyle('overflow','hidden');
	if($(panel).getStyle('height').toInt() == 0){
		$(panel+'-link').addClass('focus');
		board_cover(true);
		panel_effect.start({
			'height': [380],
			'opacity': [.5,.9]
		});
	}
	else{
		$(panel+'-link').removeClass('focus');
		board_cover(false);
		panel_effect.start({
			'height': [0],
			'opacity': [0]
		});
	}
}

// New game
function newgame(){
	for(var m=0; m<6; m++)
		for(var n=0; n<6; n++)
			$('c'+m+n).className = 'hole';

	initial();

	slide_panel('new-game');

	if($('p1-c-l').checked == true && $('p2-c-l').checked == true){
		game_type = 2;
		computer_action();
	}
	else if($('p1-c-l').checked == true){
		game_type = 1;
		computer_action();
	}
	else if($('p2-c-l').checked == true){
		game_type = 1;
	}
	else{
		game_type = 0;
	}
}

// Place marble
function place(piece){
	var valid_move = move_place(piece);
	update_history(piece.getProperty('id'));
	check_win();
	if(game == 0 && valid_move) rotate_arrow_fx(1);
}

// Place move
function move_place(piece){
	move = 1;

	if(piece.hasClass('hole')){
		// Remove 'last' move
		for(var m=0; m<6; m++)
			for(var n=0; n<6; n++)
				$('c'+m+n).removeClass('last');

		// Add the marble piece for current player
		var player = player_turn();
		if(player == 1)
			piece.className = 'p1';
		else if(player == 2)
			piece.className = 'p2';

		// Indicate 'last' move
		piece.addClass('last');
		return true;
	}
	
	return false;
}

// Rotate sub-board
function rotate(table, direction){
	move_rotate(table, direction);
	update_history(table+direction);
	rotate_arrow_fx(0);
	var time = table_rotate_fx(table,direction);
	(function(){
		check_win();
		if(game == 0){
			switch_player();
			if(game_type == 1) computer_action();
		}
	}).delay(time);
}

// Rotate move
function move_rotate(table, direction){
	var matrix = [];
	var rotated_matrix = [];
	var trs = $(table).getElementsByTagName('TR');

	for (var i=0; i<trs.length; i++) {
		var cells = trs[i].cells;
		matrix[i] = [];
		rotated_matrix[i] = [];
		for (var j=0; j<cells.length; j++)
			matrix[i][j] = cells[j].className;
	}

	if(direction == 'r'){
		for(var r=0 ; r<=2 ; r++ )
			for(var rr=0 ; rr<=2 ; rr++ )
				rotated_matrix[r][rr] = matrix[(2-rr)][r];
	}
	else if(direction == 'l'){
		for(var r=0 ; r<=2 ; r++ )
			for(var rr=0 ; rr<=2 ; rr++ )
				rotated_matrix[r][rr] = matrix[rr][(2-r)];
	}

	for (var i=0; i<trs.length; i++) {
		var cells = trs[i].cells;
		for (var j=0; j<cells.length; j++)
			cells[j].className = rotated_matrix[i][j];
	}
}

// Update history list after move
function update_history(move_type){
	var last_index = history_list.length;
	var this_move = move_type.substring(0,1);

	// the validation:
	// 1. history index is EVEN (0,2,4...) and the move is PLACE (c)
	// 2. history index is ODD (1,2,3...) and the move is ROTATE (t)
	// the moves are always alternating
	if((last_index%2 == 0 && this_move == 'c') || (last_index%2 != 0 && this_move == 't'))
		history_list.push('p' + player_turn() + '-' + move_type);
	else{ // ERROR occurs!
		board_cover(true);
		display_status('Sorry, an error has occured. Please start a new game.');
	}

	generate_history();
}

// Switch players
function switch_player(){
	var player1label_effect = new Fx.Style('player-1-label', 'font-size', {duration: 500, unit: 'em'});
	var player2label_effect = new Fx.Style('player-2-label', 'font-size', {duration: 500, unit: 'em'});

	var player = player_turn();
	if(player == 1){
		$('player-2').checked = true;
		player1label_effect.start(1.2);
		player2label_effect.start(4);
	}
	else if(player == 2){
		$('player-1').checked = true;
		player1label_effect.start(4);
		player2label_effect.start(1.2);
	}
}

// Get player's turn
function player_turn(){
	if($('player-1').checked == true)
		return 1;
	else if($('player-2').checked == true)
		return 2;
	return 0;
}

// Table rotation effects
function table_rotate_fx(table,direction){
	var div = $(table).getParent();
	var i = 0;
	var deg;
	var opac = [ .4 , .1 , 0 , .1 , .4 , 1 ];
	var ori_bg = div.getStyle('background-image');
	var PERIOD = 35;

	board_cover(true,true);

	var rotate_bg = (function(){
		$(table).setOpacity(opac[i]);
		i++;
		
		if(i == 6){
			$clear(rotate_bg);
			div.setStyle('background-image',ori_bg);
			board_cover(false,true);
			return;
		}

		deg = (direction == 'l') ? i*15 : (6-i)*15;

		div.setStyle('background-image','url(images/pentago-subboard-'+deg+'deg.png)');
	}).periodical(PERIOD);

	return PERIOD*6;
}

// Toggle rotate arrows effects
function rotate_arrow_fx(state){
	var rotation_button = $$('.rotation-buttons');
	var opac = rotation_button[0].getStyle('opacity');

	if(state == 1 && opac == 0){
		rotation_button.setOpacity(.4);
		rotation_button.setStyle('z-index','5');
	}
	else if(state == 0 && opac > 0){
		rotation_button.setOpacity(0);
		rotation_button.setStyle('z-index','3');
	}
}

// Enable|disable the board for user input
function board_cover(state,comp){
	var cover = $('board-cover');

	if(!comp)
		if(state == true)
			cover.setStyle('z-index','100');
		else
			cover.setStyle('z-index','0');
}

// Generate history list
function generate_history(){
	var h = history_list.length;
	$('history-list').empty();

	for(var i=0, j=h ; i<h, j>0 ; i++, j--){
		var item = history_list[i];
		if(item){
			var player = 'Player' + item.substring(1,2);
			var action_1 = item.substring(3,4);
			var action_2 = item.substring(4,5);
			var action_3 = item.substring(5,6);
			var player_action;

			if(action_1 == 'c'){
				player_action = 'Placed a marble on space ( row ' + (action_2.toInt()+1) + ', column ' + (action_3.toInt()+1) + ' )';
			}
			else if(action_1 == 't'){
				player_action = 'Rotated sub-board ' + action_2 + ' to the ';
				if(action_3 == 'l')
					player_action += 'left ( counter-clockwise )';
				else
					player_action += 'right ( clockwise )';
			}

			$('history-list').innerHTML += '<li>' + player + ' : ' + player_action + '.</li>';
		}
	}
}

// Undo last move
function undo(){
	var last_action = history_list.getLast();

	if(game_type == 0 && last_action){
		var player = last_action.substring(0,2);
		var action_string = last_action.substring(3);
		var action = action_string.substring(0,1);

		if(game>0){
			game = 0;
			board_cover(false);
			for(var m=0; m<6; m++)
				for(var n=0; n<6; n++)
					$('c'+m+n).removeClass('win');
		}

		if(action == 'c'){
			$(action_string).className = 'hole';
			rotate_arrow_fx(0);
		}
		else if(action == 't'){
			var t = action_string.substring(0,2);
			var d = action_string.substring(2);
			var r_d = (d == 'l') ? 'r' : 'l';

			move_rotate(t, r_d);
			var time = table_rotate_fx(t,r_d);
			(function(){rotate_arrow_fx(1);}).delay(time);
		}

		history_list.pop();
		generate_history();
		display_status('');
	}
}

// Check winnnings or draws
function check_win(){
	board_cover(true,true);

	// Check all horizontal and vertical wins
	for(var i=0; i<6; i++)
		for(var j=0; j<2; j++){
			check_5marbles(i,j,'horizontal');
			check_5marbles(j,i,'vertical');
		}

	// Check diagonal wins
	for(var k=0; k<2; k++)
		for(var l=0; l<2; l++){
			check_5marbles(k,l,'l-diagonal');
			check_5marbles(k,(l+4),'r-diagonal');
		}

	// Check for draw game
	var draw = 1;
	outer:for(var m=0; m<6; m++)
		for(var n=0; n<6; n++)
			if($('c'+m+n).hasClass('hole')){
				draw = 0;
				break outer;
				// Cutting down on loop iterations with labels
				// http://www.wait-till-i.com/index.php?p=274
			}
	if(draw == 1 && move == 1) draw = 0; // dont draw yet! wait till the player rotates!
	if(draw == 1 && game == 0) game = 4;

	var status;
	switch(game){
		case 1: status = 'Player 1 wins!'; break;
		case 2: status = 'Player 2 wins!'; break;
		case 3: status = 'Player 1 and 2 wins! A draw?'; break;
		case 4: status = 'It\'s a draw!'; break;
		default: status = '';
	}

	display_status(status, true);

	if(game == 0) board_cover(false,true);
	else board_cover(true);
}

// Check validity for 5 straight marbles
function check_5marbles(x,y, direction){
	var valid = false;
	var cell = $('c'+x+y);
	var state = cell.getProperty('class').substring(0,2);

	if(state.contains('p')){
		switch(direction){
			case 'horizontal':
				for(var i=1; i<5; i++){
					if(!$('c'+x+(y+i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=y; j<y+5; j++)
						$('c'+x+j).addClass('win');
				break;

			case 'vertical':
				for(var i=1; i<5; i++){
					if(!$('c'+(x+i)+y).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=x; j<x+5; j++)
						$('c'+j+y).addClass('win');
				break;

			case 'l-diagonal':
				for(var i=1; i<5; i++){
					if(!$('c'+(x+i)+(y+i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=x, k=y; j<x+5, k<y+5; j++, k++)
						$('c'+j+k).addClass('win');
				break;

			case 'r-diagonal':
				for(var i=1; i<5; i++){
					if(!$('c'+(x+i)+(y-i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=x, k=y; j<x+5, k>y-5; j++, k--)
						$('c'+j+k).addClass('win');
				break;
		}
	}

	if(valid){
		for(var m=0; m<6; m++)
			for(var n=0; n<6; n++)
				$('c'+m+n).removeClass('last');

		if(state.contains('1') == true){
			if(game == 0 || game == 1)
				game = 1;
			else if(game == 2)
				game = 3;
		}
		else if(state.contains('2') == true){
			if(game == 0 || game == 2)
				game = 2;
			else if(game == 1)
				game = 3;
		}
	}
}

// Status display
function display_status(text,state){
	var status_effect = new Fx.Style('status', 'opacity', {duration: 200});

	if(text == '' || !text) {
		status_effect.hide();
		$('status').empty();
	}
	else{
		$('status').innerHTML = text;
		status_effect.start(1);
		if(!state){
			status_effect.start.pass(0,status_effect).delay(2000);
		}
	}
}

// Computer action
function computer_action(){
	var player = player_turn();
	var valid_move;
	var TIME = 1000;

	board_cover(true);

	(function(){

		do{
			var x = $random(0,5);
			var y = $random(0,5);
			if(valid_move = move_place($('c'+x+y))){
				update_history($('c'+x+y).getProperty('id'));
				check_win();
			}
		}
		while(!valid_move);

		if(game == 0)
			(function(){
				if(game == 0){
		//			board_cover(false);
					var t = 't' + $random(1,4);
					var d = $random(0,1) ? 'l' : 'r';
					move_rotate(t,d);
					update_history(t+d);
					var time = table_rotate_fx(t,d);
					(function(){
						check_win();
						if(game == 0){
							switch_player();
							board_cover(false);
							if(game_type == 2) computer_action();
						}
					}).delay(time);
				}
			}).delay(TIME);
	}).delay(TIME);

}

// Easter egg
function easter_egg(){
	var i = 0;
	var t = [ 1, 2, 4, 3];

	var ee = (function(){
/*		table_rotate_fx('t1','r');
		table_rotate_fx('t2','l');
		table_rotate_fx('t3','l');
		table_rotate_fx('t4','r');
*/
		table_rotate_fx('t'+t[i],'r');
		i++;
		if(i == 4) i = 0;
	}).periodical(260);
}