var history_list; // history buffer
var move; // 1: place ; 2: rotate
var game; // 0: not game yet ; 1: player 1 wins ; 2: player 2 wins ; 3: player 1 and 2 wins ; 4: draw
var game_type; // 0: human VS human ; 1: human VS computer (vice versa) ; 2: computer VS computer
var player; // 1: player 1 ; 2: player 2
var computer_level;

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
	$('undo-link').addClass('disabled');

	board_cover(false);

	player = 1;
	$('player-1-label').addClass('current');
	$('player-2-label').removeClass('current');

	$$('.rotation-buttons').setOpacity(0);
	$$('.rotation-buttons').setStyle('z-index','3');

	$$('.table-block').setOpacity(1);

	display_status('');
}

// Preload Stuff
function preload_stuff(){
	var path = 'images/';
	var images = [
		path + 'hole-select.png',
		path + 'rotate-arrows.png',
		path + 'pentago-subboard-15deg.png',
		path + 'pentago-subboard-30deg.png',
		path + 'pentago-subboard-45deg.png',
		path + 'pentago-subboard-60deg.png',
		path + 'pentago-subboard-75deg.png'
	];
	var i;

	board_cover(true);

	new Asset.images(images, {
		onProgress: function(i){
			display_status('Loading (' + (i+1) + ' / ' + images.length + ')', true);
//			$('debug').innerHTML = (i+1) + ' / ' + images.length;
		},
		onComplete: function(){
			display_status('Done.');
			board_cover(false);
		}
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
	$('player-1-type').setHTML('Human');
	$('player-2-type').setHTML('Human');

	// Player selection
	if($('p1-c-l').checked == true && $('p2-c-l').checked == true){
		game_type = 2;
		computer_action();
		$('player-1-type').setHTML('Computer');
		$('player-2-type').setHTML('Computer');
	}
	else if($('p1-c-l').checked == true){
		game_type = 1;
		computer_action();
		$('player-1-type').setHTML('Computer');
	}
	else if($('p2-c-l').checked == true){
		game_type = 1;
		$('player-2-type').setHTML('Computer');
	}
	else{
		game_type = 0;
	}

	// Computer level selection
	//if($('c-1-l').checked == true) computer_level = 1;
	//else if($('c-2-l').checked == true) computer_level = 2;
	//else computer_level = 0;
}

// Place marble
function place(piece){
	var valid_move = move_place(piece);
	if(valid_move){
		update_history(piece.getProperty('id'));
		check_win();
		if(game == 0) rotate_arrow_fx(1);
	}
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
	board_cover(true);
	var time = table_rotate_fx(table,direction);
	check_win();
	if(game == 0){
		switch_player();
		(function(){
			board_cover(false);
			if(game_type == 1) computer_action();
		}).delay(time);
	}
}

// Rotate move
function move_rotate(table, direction){
	move = 2;
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
	// 2. history index is ODD (1,3,5...) and the move is ROTATE (t)
	if((last_index%2 == 0 && this_move == 'c') || (last_index%2 != 0 && this_move == 't'))
		history_list.push('p' + player + '-' + move_type);
	else{ // ERROR occurs!
		board_cover(true);
		display_status('Sorry, an error has occured. Please start a new game.');
	}

	if(history_list.length>0 && game_type == 0)
		$('undo-link').removeClass('disabled');

	generate_history();
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

// Table rotation effects
function table_rotate_fx(table,direction){
	var div = $(table).getParent();
	var i = 0;
	var deg;
	var opac = [ .1 , 0 , .1 , .2 , .3 , 1 ];
	var ori_bg = div.getStyle('background-image');
	var PERIOD = 35;

	var rotate_bg = (function(){
		$(table).setOpacity(opac[i]);
		i++;

		if(i == 6){
			$clear(rotate_bg);
			div.setStyle('background-image',ori_bg);
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
function board_cover(state){
	var cover = $('board-cover');

	if(state == true)
		cover.setStyle('z-index','100');
	else
		cover.setStyle('z-index','0');
}

// Generate history list
function generate_history(){
	var h = history_list.length;
	$('history-list').empty();

	if(h != 0)
		for(var i=0, j=h ; i<h, j>0 ; i++, j--){
			var item = history_list[i];
			if(item){
				var p = 'Player' + item.substring(1,2);
				var action_1 = item.substring(3,4);
				var action_2 = item.substring(4,5);
				var action_3 = item.substring(5,6);
				var player_action;

				if(action_1 == 'c'){
					player_action = 'Placed a marble on space ( column ' + (action_2.toInt()+1) + ', row ' + (action_3.toInt()+1) + ' )';
				}
				else if(action_1 == 't'){
					player_action = 'Rotated sub-board ' + action_2 + ' to the ';
					if(action_3 == 'l')
						player_action += 'left ( counter-clockwise )';
					else
						player_action += 'right ( clockwise )';
				}

				$('history-list').innerHTML += '<li>' + p + ' : ' + player_action + '.</li>';
			}
		}
}

// Undo last move
function undo(){
	var last_action = history_list.getLast();
	var prev_game;

	if(game_type == 0 && last_action){
		$('undo-link').addClass('disabled');
		var action_string = last_action.substring(3);
		var action = action_string.substring(0,1);

		if(game>0){
			game = 0;
			prev_game = 1;
			board_cover(false);
			for(var m=0; m<6; m++)
				for(var n=0; n<6; n++)
					$('c'+m+n).removeClass('win');
		}

		if(action == 'c'){
			$(action_string).className = 'hole';
			rotate_arrow_fx(0);
			$('undo-link').removeClass('disabled');
		}
		else if(action == 't'){
			var t = action_string.substring(0,2);
			var d = action_string.substring(2);
			var r_d = (d == 'l') ? 'r' : 'l';

			move_rotate(t, r_d);
			var time = table_rotate_fx(t,r_d);
			if(prev_game != 1) switch_player();
			(function(){
				rotate_arrow_fx(1);
				$('undo-link').removeClass('disabled');
			}).delay(time);
		}

		history_list.pop();
		generate_history();
		display_status('');
		if(history_list.length == 0) $('undo-link').addClass('disabled');
	}
}

// Check winnnings or draws
function check_win(){
	// Check all horizontal and vertical wins
	for(var i=0; i<6; i++)
		for(var j=0; j<2; j++){
			check_5marbles(j,i,'horizontal');
			check_5marbles(i,j,'vertical');
		}

	// Check diagonal wins
	for(var k=0; k<2; k++)
		for(var l=0; l<2; l++){
			check_5marbles(k,l,'l-diagonal');
			check_5marbles((k+4),l,'r-diagonal');
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

	if(game > 0) board_cover(true);
}

// Check validity for 5 straight marbles
function check_5marbles(x,y, direction){
	var valid = false;
	var cell = $('c'+y+x);
	var state = cell.getProperty('class').substring(0,2);

	if(state.contains('p')){
		switch(direction){
			case 'horizontal':
				for(var i=1; i<5; i++){
					if(!$('c'+y+(x+i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=x; j<x+5; j++)
						$('c'+y+j).addClass('win');
				break;

			case 'vertical':
				for(var i=1; i<5; i++){
					if(!$('c'+(y+i)+x).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=y; j<y+5; j++)
						$('c'+j+x).addClass('win');
				break;

			case 'l-diagonal':
				for(var i=1; i<5; i++){
					if(!$('c'+(y+i)+(x+i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=y, k=x; j<y+5, k<x+5; j++, k++)
						$('c'+j+k).addClass('win');
				break;

			case 'r-diagonal':
				for(var i=1; i<5; i++){
					if(!$('c'+(y+i)+(x-i)).hasClass(state)){
						valid = false;
						break;
					}
					else
						valid = true;
				}

				if(valid)
					for(var j=y, k=x; j<y+5, k>x-5; j++, k--)
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
	var valid_move;
	var TIME = 1000;

	board_cover(true);

	var matrix = '';
	for(var m=0; m<6; m++)
		for(var n=0; n<6; n++){
			if($('c'+m+n).hasClass('p1')) matrix += '1';
			else if($('c'+m+n).hasClass('p2')) matrix += '2';
			else matrix += '0';
		}

//	$('debug1').innerHTML = matrix;
computer_level = 1;
	var ajax_ai = new Ajax('pentagoo_ai.php?m=' + matrix + '&p=' + player + '&l=' + computer_level,
	{
		method: 'get',
//		update: $('debug'),
		onComplete: function(response){
			(function(){
				var x = response.substring(0,1);
				var y = response.substring(1,2);
/*
				do{
					var x = $random(0,5);
					var y = $random(0,5);
					if(valid_move = move_place($('c'+y+x))){
						update_history($('c'+y+x).getProperty('id'));
						check_win();
					}
				}
				while(!valid_move);
*/
				valid_move = move_place($('c'+y+x));
				update_history($('c'+y+x).getProperty('id'));
				check_win();

				if(valid_move && game == 0)
					(function(){
						var t = 't' + response.substring(2,3);
						var d = response.substring(3,4);
//						var t = 't' + $random(1,4);
//						var d = $random(0,1) ? 'l' : 'r';
						move_rotate(t,d);
						update_history(t+d);
						var time = table_rotate_fx(t,d);
						check_win();
						if(game == 0){
							switch_player();
							(function(){
								if(game_type == 2) computer_action();
								else board_cover(false);
							}).delay(time);
						}
					}).delay(TIME,response);
			}).delay(TIME,response);
		}
	}).request();
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