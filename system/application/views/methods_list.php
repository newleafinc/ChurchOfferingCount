<?=$this->load->view('header')?>

<script language="javascript" src="<?=base_url()?>assets/js/jquery.jeditable.mini.js"></script>
<script>
$(document).ready(function() {
	$('.edit_name').editable('<?=base_url()?>methods/update', {
		indicator	: 'Saving...',
		style		: "display: inline; margin: 0; padding: 0;",
		tooltip		: 'Click to edit...'
	});

//Delete method function
	$(".delete").click(function() {
		var row = $(this).parents('tr:first');
		var id = $(this).attr('id');
		//var method_id = id.split('_');
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>methods/delete/"+id,
			//data: "id="+ id,
			beforeSend:function(){
				// this is where we append a loading image
				$('#ajax-panel').html('<div class="loading"><img src="<?=base_url()?>assets/img/loading.gif" alt="Loading..." /></div>');
			},
			success: function(response){
				// successful request; do something with the data
				$('#ajax-panel').empty();
				
				//Process response
				if( response == 'true' ) {
					$(row).slideUp(6000);
					$(row).remove();
					alert("Method deleted successfully.");
				} else {
					alert("There are records using this method. So, you can't delete it or the world will end.");
				}
			},
			error:function(){
				// failed request; give feedback to user
				$('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
			}
			
		});
	});
});
</script>

</head>

<body>

<?=$this->load->view('main_menu')?>
<?=$this->load->view('local_menu_methods')?>

<div class="content">

<?php if (isset($message)): ?>
 
    <div id="message_confirm"><?=$message?></div>
 
<?php endif; ?>

<?php if (isset($results)): ?>

<table class="lister" id="methods_list" cellpadding="0" cellspacing="0">

	<tr>
		<th class="a_left">Giving Method</th>
		<th class="a_left"></th>
	</tr>

<?php foreach ($results as $row): ?>
 	
	<tr>
		<td id="name_<?=$row['method_id']?>" class="edit_name"><?=$row['name']?></td>
		<td id="actions">
			<a href="#" class="delete link_button" id="<?=$row['method_id']?>" title="Delete this method">Delete</a>
		</td>
	</tr>

<?php endforeach; ?>

</table>

<?php else: ?>

    <h2>Nothing found</h2>
 
<?php endif; ?>

</div>

</body>
</html>