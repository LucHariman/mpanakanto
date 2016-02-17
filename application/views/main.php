<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<title>Ilay mpanakanto mitovy aminao</title>
<link href="<?php echo getResources("images/mpanakanto.ico"); ?>" type="image/x-icon" rel="icon" />
<link rel="stylesheet" type="text/css" href="<?php echo getResources("css/style.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo getResources("css/redmond/jquery-ui-1.8.21.custom.css"); ?>" />
<script src="<?php echo getResources("js/jquery-1.7.2.min.js"); ?>"></script>
<script src="<?php echo getResources("js/jquery-ui-1.8.21.custom.min.js"); ?>"></script>
<script src="<?php echo getResources("js/script.js"); ?>"></script>
<script>

	function partagerImage() {

		jQuery("#globalLoading").toggle();
		jQuery.ajax({
			type : "POST",
			url : "<?php echo base_url("home/partagerImage"); ?>",
			data: jQuery("#partageImageFrm").serialize(),
			success : function(msg) {
				jQuery("#globalLoading").toggle();

				jQuery("#partageImageFrm").toggle(false);
				jQuery("#successMsg").toggle(true);
				lien = "https://www.facebook.com/photo.php?fbid=" + msg;
				jQuery("#lienPhoto").attr("href", "https://www.facebook.com/photo.php?fbid=" + msg);
				jQuery("#lienPhoto").text(lien);
				popupInvitation();
			},
			error: function (xhr, status, e) {
				jQuery("#globalLoading").toggle();
				jQuery("#errMsg").toggle(true);
			}
		});
		
	}

</script>

<meta property="og:title" content="Ilay mpanakanto mitovy aminao" />
<meta property="og:type" content="album" />
<meta property="og:url" content="http://mpanakanto.luc-hariman.net76.net/" />
<meta property="og:image" content<?php echo getResources("images/vignette.jpg"); ?>" />
<meta property="og:site_name" content="Mpanakanto - Luc Hariman" />
<meta property="fb:app_id" content="388576011208637" />

</head>

<body bgcolor="#f7f7f7" style="font-family: 'Lucida Grande',Tahoma,Verdana,Arial,sans-serif; margin: 0px">
	<div id="globalLoading"
		style="display: none; height: 100%; width: 100%;
		 	position: fixed; left: 0ox; top: 0px">
		<div class="ui-overlay">
			<div class="ui-widget-overlay"></div>
		</div>
		<div style="position: absolute; margin-left: auto; margin-right: auto;
			left: 0; right: 0; top: 45%; text-align: center;">
			<img src="<?php echo getResources("images/loading.gif"); ?>" />
		</div>
	</div>
	<div id="fb-root"></div>
	<script src="http://connect.facebook.net/en_US/all.js">
	 </script>
	<script>
	      FB.init({
	         appId:'<?php echo FB_APP_ID; ?>',
	         cookie:true,
	         status:true,
	         xfbml:true
	      });

	      function popupInvitation() {
		      FB.ui({
		         method: 'apprequests',
		         message: 'Fantaro ilay mpanakanto mitovy aminao'
		     });
	      }

	      (function(d, s, id) {
	        var js, fjs = d.getElementsByTagName(s)[0];
	        if (d.getElementById(id)) return;
	        js = d.createElement(s); js.id = id;
	        js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=388576011208637";
	        fjs.parentNode.insertBefore(js, fjs);
	      }(document, 'script', 'facebook-jssdk'));

	</script>

	<center>
		<span style="font-family: Callie; font-weight: bold; font-size: 40; color: #203360" >
			Ilay mpanakanto mitovy aminao
		</span>
		<div>
			<img src="<?php echo getResources("temp/" . $tempFileName); ?>" />
		</div>
		<div>
			<img src="<?php echo getResources("images/box_shadow_lower.png"); ?>"
				style="width: 600px" />
		</div>
		
		<table style="width: 600px">
			<tr><td>
				<div class="form-div">
					<div class="form-title" style="text-align: center" title="Publier sur votre mur">Afaka zarainao eo amin'ny rindrina facebook'nao ity sary ity</div>
					
					<form id="partageImageFrm">
						<input type="hidden" value="<?php echo $tempFileName ?>" name="tempFileName"/>
						<table style="text-align: left" cellspacing="5">
							<tr>
								<td>
									<img src="http://graph.facebook.com/<?php echo $userId; ?>/picture"
								</td>
							
								<td width="300">
								<textarea id="messageInput" name="message" title="Fihetse-po"></textarea>
							</td></tr>
							<tr><td align="right" colspan="2">
								<a class="boutonFb" onClick="partagerImage()">&nbsp;&nbsp;Zaraina&nbsp;&nbsp;</a>
							</td></tr>
						</table>
					</form>
					
					<div style="font-size: 12px; text-align: center; display: none" id="successMsg">
						<br/>
						Voazara ny sarinao, afaka tsidihinao ato amin'ity rohy ity :<br/>
						<a id="lienPhoto" target="_blank"></a>
					</div>
		
					
					
					<div style="display: none; color: red" id="errMsg">
						Nisy sampona ara-teknika !!!<br/>
					</div>
		
				</div>
			</td>
			<td align="right">
				<div class="fb-like" data-href="https://mpanakanto.luc-hariman.net76.net/" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true"></div>
			</td></tr>
		</table>
		<br/>
		<div style="font-size: 14px">
			<p>Tsindrio <a class="lienFb" onClick="popupInvitation()">ETO</a> raha han&agrave;sa ny namanao ianao mba hamantatra ny mpanakanto mitovy aminy.</p>
		</div>
		<div style="font-size: 13px">
			<p>Miisa <?php echo $totalVisiteur; ?> ny nitsidika.</p>
			<table><tr>
				<?php foreach ($hasard as $ha) {?>
					<img src="http://graph.facebook.com/<?php echo $ha->userid; ?>/picture"
						style="padding-left: 5px"/>
				<?php } ?>
			</tr></table>
			
		</div>
		<br/>
		<div><hr width="600px"/><font size="2">&copy; 2012 <a href="mailto:luchariman@hotmail.com" title="Luc Hariman Randrianomenjanahary">SPOT</a></font></div>
		<br/>
	</center>
	
</body>

</html>