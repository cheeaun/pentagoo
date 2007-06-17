var turn;
var history_list;
var undo_flag = false;
var game;

// Event load
window.addEvent('load', function() {
	$('about').setStyle('height','0');
	$('about').setOpacity(0);
	$('about-link').addEvent('click', about);
	$('about').innerHTML += '<p class="close"><a href="javascript:about();">Close</a></p>';

	$('undo-history').setStyle('height','0');
	$('undo-history').setOpacity(0);
	$('undo-history').innerHTML = '<ol id="undo-list"></ol>';
	$('undo-history').innerHTML += '<p class="close"><a href="javascript:undo_history();">Close</a></p>';

	for(var m=0; m<6; m++)
		for(var n=0; n<6; n++){
			$('c'+m+n).className = 'off';
			$('c'+m+n).setAttribute('onclick','javascript:place(this);');
		}

	initial();

	//Preload images
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
	    }
	});
});

// Initial State
function initial(){
	game = 0;
	history_list = [];

	set_turn(1);

	$('player-1').checked = true;
	$('player-1-label').setStyle('font-size', '4em');
	$('player-2-label').setStyle('font-size', '1.2em');

	$$('.rotation-buttons a').setOpacity(0);

	$$('.table-block').setOpacity(1);

	display_status('');
}

// About panel
function about(){
	var about_effect = $('about').effects({duration: 200, onComplete:function(){$('about').setStyle('overflow','auto');}});

	$('about').setStyle('overflow','hidden');
	if($('about').getStyle('height').toInt() == 0)
		about_effect.start({
			'height': [320],
			'opacity': [.5,.8]
		});
	else
		about_effect.start({
			'height': [0],
			'opacity': [0]
		});
}

// New game button
function newgame(){
	$$('.table-block').each(function(block,i){
		var trs = block.getElementsByTagName('TR');
		for (var i=0; i<trs.length; i++) {
			var cells = trs[i].cells;
			for (var j=0; j<cells.length; j++) {
				var c = cells[j];
				c.setAttribute('class','off');
			}
		}
	});

	initial();

	ask_gametype();
}

function ask_gametype(){
	
}

// Place a marble
function place(piece){
	if(turn == 1){
		if(piece.hasClass('off')){
			var player = player_turn();
			if(player == 1){
				piece.className = 'player-1-on';
				history_list.push('p1-' + piece.getProperty('id'));
			}
			else if(player == 2){
				piece.className = 'player-2-on';
				history_list.push('p2-' + piece.getProperty('id'));
			}
		display_status('');

			set_turn(0);

			check_win();
			if(game == 0){
				toggle_rotate_arrow_fx();
			}

		}
		else
			display_status('Invalid Move!');
	}
	else if(game==0)
		display_status('Please rotate one of the sub-boards first.');
}

// Rotate a sub-board
function rotate(t,direction){
	var matrix = [];
	var rotated_matrix = [];
	var rotate = false;
	var hist;
	
	var trs = $(t).getElementsByTagName('TR');
	for (var i=0; i<trs.length; i++) {
		var cells = trs[i].cells;
		matrix[i] = [];
		rotated_matrix[i] = [];
		for (var j=0; j<cells.length; j++) {
			matrix[i][j] = cells[j].getAttribute('class');
		}
	}

	if(direction == 'right'){
		rotated_matrix[0][0] = matrix[2][0];
		rotated_matrix[0][1] = matrix[1][0];
		rotated_matrix[0][2] = matrix[0][0];
		rotated_matrix[1][0] = matrix[2][1];
		rotated_matrix[1][2] = matrix[0][1];
		rotated_matrix[2][0] = matrix[2][2];
		rotated_matrix[2][1] = matrix[1][2];
		rotated_matrix[2][2] = matrix[0][2];
	}
	else{
		rotated_matrix[0][0] = matrix[0][2];
		rotated_matrix[0][1] = matrix[1][2];
		rotated_matrix[0][2] = matrix[2][2];
		rotated_matrix[1][0] = matrix[0][1];
		rotated_matrix[1][2] = matrix[2][1];
		rotated_matrix[2][0] = matrix[0][0];
		rotated_matrix[2][1] = matrix[1][0];
		rotated_matrix[2][2] = matrix[2][0];
	}
	rotated_matrix[1][1] = matrix[1][1];

	for (var i=0; i<trs.length; i++) {
		var cells = trs[i].cells;
		for (var j=0; j<cells.length; j++) {
			var ce = cells[j];
			ce.setAttribute('class',rotated_matrix[i][j]);
		}
	}

	set_turn(1);

	display_status('');

	switch(t){
		case 'table-block-1': hist = 'r1'; break;
		case 'table-block-2': hist = 'r2'; break;
		case 'table-block-3': hist = 'r3'; break;
		case 'table-block-4': hist = 'r4'; break;
	}

	switch(direction){
		case 'left': hist += 'l'; break;
		case 'right': hist += 'r'; break;
	}

	var player = player_turn();
	if(player == 1)
		hist = 'p1-' + hist;
	else if(player == 2)
		hist = 'p2-' + hist;

	if(!undo_flag)
		history_list.push(hist);

	toggle_rotate_arrow_fx();
	table_rotate_fx(t,direction)

	check_win();
	if(game>0){
		turn = 0;
		$('main-pentago').addClass('noturn');
	}
	else
		switch_player();
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

// Toggle turns (turn = 1 when the player rotated the subboard, turn = 0 when no yet rotate)
function set_turn(t){
	turn = t;
	if(t == 1)
		$('main-pentago').removeClass('noturn');
	else if(t == 0)
		$('main-pentago').addClass('noturn');
}

// Table rotation effects
function table_rotate_fx(table,direction){
	var div = $(table).getParent();
	var i = 0;
	var deg;
	var opac = [ .4 , .1 , 0 , .1 , .4 , 1 ];

	var ori_bg = div.getStyle('background-image');

	var rotate_bg = (function(){
		$(table).setOpacity(opac[i]);
		i++;
		
		if(i == 6){
			$clear(rotate_bg);
			div.setStyle('background-image',ori_bg);
			return;
		}

		deg = (direction == 'left') ? i*15 : (6-i)*15;

		div.setStyle('background-image','url(images/pentago-subboard-'+deg+'deg.png)');
	}).periodical(35);
}

// Toggle rotate arrows effects
function toggle_rotate_arrow_fx(){
	var rotation_button = $$('.rotation-buttons a');

	if(rotation_button[0].getStyle('opacity') == 0)
		rotation_button.setOpacity(.4);
	else
		rotation_button.setOpacity(0);
}

// Undo history panel
function undo_history(){
	var undo_effect = $('undo-history').effects({duration: 200, onComplete:function(){$('undo-history').setStyle('overflow','auto');}});

	$('undo-history').setStyle('overflow','hidden');
	if($('undo-history').getStyle('height').toInt() == 0){
		undo_effect.start({
			'height': [320],
			'opacity': [.5,.8]
		});

		update_undo_history();
	}
	else
		undo_effect.start({
			'height': [0],
			'opacity': [0]
		});
}

function update_undo_history(){
	$('undo-list').innerHTML = '';

	var h = history_list.length;
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
			else if(action_1 == 'r'){
				player_action = 'Rotated sub-board ' + action_2 + ' to the ';
				if(action_3 == 'l')
					player_action += 'left ( counter-clockwise )';
				else
					player_action += 'right ( clockwise )';
			}

			$('undo-list').innerHTML += '<li><a href="javascript:undo('+j+');">' + player + ' : ' + player_action + '.</a></li>';
		}
	}
}

// Undo button
function undo(steps){
	if(steps == undefined)
		steps = 1;

	for( var i=0 ; i<steps ; i++ ){
		var last_action = history_list.getLast();

		if(last_action){
			var player = last_action.substring(0,2);
			var action_string = last_action.substring(3);
			var action = action_string.substring(0,1);
			undo_flag = true;

			if(game>0){
				game = 0;
				for(var m=0; m<6; m++)
					for(var n=0; n<6; n++)
						$('c'+m+n).removeClass('win');
			}

			if(action == 'c'){
				$(action_string).className = 'off';

				set_turn(1);

				toggle_rotate_arrow_fx();
			}
			else if(action == 'r'){
				var rotate_quad = action_string.substring(1,2);
				var rotate_direction = action_string.substring(2);
				var r_dir;

				if(rotate_direction == 'l')
					r_dir = 'right';
				else
					r_dir = 'left';

				rotate('table-block-'+rotate_quad, r_dir);
			}

			history_list.pop();
			undo_flag = false;
		}
	}

	update_undo_history();
}

// Check winnnings or draws
function check_win(){
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
			if($('c'+m+n).hasClass('off')){
				draw = 0;
				break outer;
				// Cutting down on loop iterations with labels
				// http://www.wait-till-i.com/index.php?p=274
			}
	if(draw == 1 && turn == 0) draw = 0; // dont draw yet! wait till the player rotates!
	if(draw == 1 && game == 0) game = 4;

	var status;
	switch(game){
		case 1: status = 'Player 1 wins!'; break;
		case 2: status = 'Player 2 wins!'; break;
		case 3: status = 'Player 1 and 2 wins! A draw?'; break;
		case 4: status = 'It\'s a draw!'; break;
		default: status = '';
	}

	display_status(status);
}

function check_5marbles(x,y, direction){
	var valid = false;
	var state = $('c'+x+y).getProperty('class');

	if(state != 'off'){
		switch(direction){
			case 'horizontal':
				for(var i=1; i<5; i++){
					if(state != $('c'+x+(y+i)).getProperty('class')){
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
					if(state != $('c'+(x+i)+y).getProperty('class')){
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
					if(state != $('c'+(x+i)+(y+i)).getProperty('class')){
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
					if(state != $('c'+(x+i)+(y-i)).getProperty('class')){
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

function display_status(text){
	var status_effect = new Fx.Style('status', 'opacity', {duration: 200});

	if(text == '' || !text) {
		status_effect.hide();
		$('status').empty();
	}
	else{
		$('status').innerHTML = text;
		status_effect.start(1);
		if(!text.contains('wins') && !text.contains('draw') && !undo_flag){
			status_effect.start.pass(0,status_effect).delay(2000);
		}
	}
}