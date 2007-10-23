/*
 * Script: pentagoo-air.js - AIR-specific code
 * Author: Lim Chee Aun
 */

var SAVED_FILE = 'last-game.sav';

window.addEvent('load',function(e){
	set_window_bounds();
	getVersion();
	monitor_http();
	fix_airlinks();
	read_saved_game.delay(100);
});

// Set window bounds
function set_window_bounds(){
	// Set window stage (inner window) width and height
	nativeWindow.stage.stageWidth = $('container').getStyle('width').toInt();
	nativeWindow.stage.stageHeight = $('container').getStyle('height').toInt();

	// Set centered window position
	nativeWindow.x = (air.Capabilities.screenResolutionX - nativeWindow.width) / 2;
	nativeWindow.y = (air.Capabilities.screenResolutionY - nativeWindow.height) / 2;

	// Show the window
	nativeWindow.activate();
}

// Display version of app
// http://www.davidtucker.net/2007/09/03/air-tip-3-what-version-is-my-application/
var xmlhttp;
var appXML;
function getVersion() {
	var url = "app-resource:/application.xml";

	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4) {
			appXML = xmlhttp.responseXML;
			var x = appXML.getElementsByTagName('application');
			var versionNum = x[0].getAttribute('version');

			var version = new Element('div',{'id':'version'});
			version.injectTop($('sidebar'));
			version.setText(versionNum);
		}
	}
	xmlhttp.send(null);
}

// Monitor HTTP connectivity
var monitor = null;
function monitor_http(){
	var request = new air.URLRequest('http://google.com'); // I love Google!
	request.method = "HEAD"; // Tip from http://www.davidtucker.net/2007/08/21/air-tip-1-%E2%80%93-monitoring-your-internet-connection/

	monitor = new air.URLMonitor(request);
	monitor.addEventListener(air.StatusEvent.STATUS, function init_status(){
		if(monitor.available){
			$('p1-c-l').disabled = $('p2-c-l').disabled = false;
			$('network-error').removeClass('panel-error').empty();
			if(game_type>0) set_status();
		}
		else{
			$('p1-c-l').disabled = $('p2-c-l').disabled = true;
			$('network-error').addClass('panel-error').setHTML('Sorry, a working Internet connection is needed to enable Computer player.');
			if(game_type>0) set_status('Ooops! There\'s a connection problem. The computer is unable to play.');
		}
	});
	monitor.start();
}

// Fix web links to open in default browser
function fix_airlinks(){
	$$('a[href]').addEvent('click',function(e){
		e.preventDefault(); // prevent open INSIDE the nativeWindow
		air.navigateToURL(new air.URLRequest(this.href));
	});
}

// Saved game
var file = air.File.applicationStorageDirectory.resolvePath(SAVED_FILE);
var unique_data; // store changes in game to be saved/unsaved

// Read saved game
function read_saved_game(){
	if(file.exists){
		if(confirm('Do you want to continue your saved game?')){
			stream = new air.FileStream();
			try{
				// Read the file
				stream.open(file, air.FileMode.READ);
				var str = stream.readUTFBytes(stream.bytesAvailable);
				stream.close();
				var inData = str.split(air.File.lineEnding);
				
				// Load the board matrix
				var temp_matrix = inData[0].split(',');
				for(var y=0; y<SIZE; y++)
					for(var x=0; x<SIZE; x++){
						board_matrix[y][x] = temp_matrix.shift().toInt();
						$('s-'+y+x).className = (board_matrix[y][x]) ? 'p-'+board_matrix[y][x] : 'space';
					}

				// Load the move history
				move_history = inData[1].split(',');
				var temp_last_move = move_history.getLast().charAt(0);
				if(temp_last_move == 'p') rotate_buttons(1);
	
				// Load the last marble history
				last_marble_history = inData[2].split(',');
				last_marble = last_marble_history.getLast();
				$('s-'+last_marble).addClass('last');

				// Load game type and computer level
				game_type = inData[3].toInt();
				computer_level = inData[4].split(',').map(function(item){return item.toInt()});

				// Set current player
				var last_index = move_history.length;
				var even_index = last_index - (last_index%2);
				var linear_index = even_index/2;
				player = (linear_index%2) ? 2 : 1;
				if(player == 2){
					$('player-2-label').addClass('current');
					$('player-1-label').removeClass('current');
				}

				// Enable undo link
				if(game_type == 0) $('undo-link').removeClass('disabled');
				
				// Assign unique data
				unique_data = move_history.length + move_history.getLast();
	
				// Deploy an effect, which fixes the AIR bug as well, same with dummy
				for(var i=1 ; i<=4 ; i++) subboard_rotation_fx(i,'r');
			}
			catch(error){
				ioErrorHandler()
			}
		}
		else file.deleteFile();
	}
}//).delay(100);

// Write to save game before window closing
nativeWindow.addEventListener(air.Event.CLOSING,function(e){
	if(!game && game_type == 0 && move_history.length
		&& unique_data != move_history.length + move_history.getLast()
		&& confirm('Do you want to save the game in progress?')){
		try{
			stream = new air.FileStream();
			stream.open(file, air.FileMode.WRITE);
			var br = air.File.lineEnding;
			var outData = board_matrix.toString() + br +
				move_history.toString() + br +
				last_marble_history.toString() + br +
				game_type + br +
				computer_level.toString();
			stream.writeUTFBytes(outData);
		}
		catch(error){
			ioErrorHandler();
		}
	}
	else if(file.exists) file.deleteFile();
});

// Sounds
var place_sound = new air.Sound(new air.URLRequest("sounds/place.mp3"));
var rotate_sound = new air.Sound(new air.URLRequest("sounds/rotate.mp3"));
var status_sound = new air.Sound(new air.URLRequest("sounds/status.mp3"));
var pop_sound = new air.Sound(new air.URLRequest("sounds/pop.mp3"));

// Temporary fix for AIR bug with 'unchanged' child elements
// I know, this is stupid. What the heck, I'm lazy.
function dummy(){ $$('.subboard td span').removeClass('dummy'); }
document.addEvents({
	keydown: dummy,
	click: dummy
});

// Temporary fix for AIR bug with unsupported animated GIFs
// Faux animation. How ugly.
var k = 0;
(function(){
	$$('#player-labels li.current').setStyle('background-position','bottom '+k+'px')
	k = (k == 20) ? 0 : (k+2);
}).periodical(60);