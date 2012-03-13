<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function() {
    $('a.clue').aToolTip();
});
/* ]]> */
</script>
<!-- BEGIN HOMEPAGE -->
<div class="container_4">
    <div class="grid-wrap push-up">
  	<div class="grid_3 push-down">
		<?php echo nl2br($event->description) ?>
		<div>
    </div>
</div>
</div>
<div class="container_4">
    <div class="grid-wrap">
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap-static">Insights</h2>
			<!-- Be sure you're keeping to this exact structure! -->
			<div class="content">
			    <?php if (isset($event_cards)&&count($event_cards)>0){?>
				<?php $last_event_cards = array_reverse($event_cards); 
				foreach (array_slice($last_event_cards, 0, 24) as $card) { 
				    if (isset($card->image)){
                        $img = UPLOADS_URL.$card->image.'_t.jpg';
                        $img_headers = @get_headers($card_front);
                        if($img_headers[0] == 'HTTP/1.1 404 Not Found') {
                           $img ="false";
                        }
                    }
				?>
				<!-- GALLERY ITEM -->
				<div class="img">
					<a class="clue" title="<?php echo $card->name; ?>" href="index.php?do=view&card_id=<?php echo $card->id ?>"><img src="<?php echo $img; ?>" alt="" /></a>
				</div>
				<!-- END GALLERY ITEM -->
				<?php unset($card); unset($img); } ?>
				<?php } else {echo("No insights added yet."); }?>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END PANEL -->	
	</div>
</div>
</div>
<!-- END CONTAINER -->