$(function() 
{
    var command_history = [];
    var command_counter = -1;
    var history_counter = -1;

    var conn = new WebSocket('ws://localhost:9000');

    conn.onopen = function(e) 
    {
		console.log("Connection established!");
    };

    conn.onmessage = function(e) 
    {
    	console.log(e);
		$('pre#console').append(e.data);
		$('body').scrollTop(1E10);
    };

    $('#input input').keyup(function(e)
    {
	var code = (e.keyCode ? e.keyCode : e.which);

	if(code === 13)
	{
	    command_history[command_counter++] = $('#input input').val();
	    history_counter = command_counter;
	    conn.send($('#input input').val());
	    $('#input input').select();
	}
	else if(code === 38)
	{
	    if(history_counter>=0)
	    {
		$('#input input').val(command_history[--history_counter]);
	    }
	}
	else if(code === 40)
	{
	    if(history_counter>=0)
	    {
		$('#input input').val(command_history[++history_counter]);
	    }
	}
    });
});
