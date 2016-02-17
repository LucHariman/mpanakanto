<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo getResources("css/redmond/jquery-ui-1.8.21.custom.css"); ?>" />
	<script src="<?php echo getResources("js/jquery-1.7.2.min.js"); ?>"></script>
	<script>
		function getPhotos(userId) {
			jQuery("#globalLoading").toggle();
			jQuery.ajax({
				url : "<?php echo base_url("androany/getPhotos"); ?>/" + userId,
				success : function(msg) {
					jQuery("#globalLoading").toggle();
					try {
						data = jQuery.parseJSON(msg);
					} catch (e) {
						jQuery("#photosDiv").text(msg);
						return;
					}
					jQuery("#photosDiv").html("");
					for (i = 0; i < data.count; i++)
						jQuery("#photosDiv").append("<img style='width: 200px' src='<?php echo getResources('temp'); ?>/" + data.imgs[i] + "' />");
					
				},
				error: function (xhr, status, e) {
					jQuery("#globalLoading").toggle();
					alert("erreur");
				}
			});
			
		}
	</script>
</head>
<body style="margin: 0px;">
	<p>Total : <?php echo $total; ?></p>
	<table><tr><td>
	<div style="width: 250px; height: 700px; overflow: auto;">
<?php

	foreach ($users as $user) {
		
		$profile = $facebook->api('/' . $user->userid, 'GET', array('fields' => 'name,link'));
?>
		<div>
			<table>
				<tr><td rowspan="3">
					<img src="http://graph.facebook.com/<?php echo $user->userid; ?>/picture"
						style="cursor: pointer;"
						onClick="getPhotos('<?php echo $user->userid; ?>')" />
				</td><td>
					<a target="_blank" href="http://facebook.com/<?php echo $user->userid; ?>"><?php echo $profile['name']; ?></a>
				</td></tr>
				<tr><td>
					<?php echo $user->derniere_visite; ?>
				</td></tr>
				<tr><td>
					<?php echo $user->nb_partage; ?> publication(s)
				</td></tr>
			</table>
		</div>
<?php 
	}
?>
	</div>
	</td><td valign="top">
	<div id="photosDiv">
		
	</div>
	</td></tr>
	</table>
	
	<div id="globalLoading"
		style="display: none; height: 100%; width: 100%; position: fixed; left: 0ox; top: 0px">
		<div class="ui-overlay">
			<div class="ui-widget-overlay"></div>
		</div>
		<div style="position: absolute; margin-left: auto; margin-right: auto;
			left: 0; right: 0; top: 45%; text-align: center;">
			<img src="<?php echo getResources("images/loading.gif"); ?>" />
		</div>
	</div>
	
</body>
</html>