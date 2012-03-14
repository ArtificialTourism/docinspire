<?php if (isset($categories)&&isset($colours)){
     echo("<style type='text/css'>\n");
     foreach ($categories as $id=>$val){
         echo(".cat-$id{ color: #$colours[$id]!important;}\n");
         echo("#gallery .box.cat-$id a{ border-bottom: 1px solid #$colours[$id]!important;}\n");
     }
     echo("</style>\n");
 }?>
 <div class="container_4 push-up">
    <script type="text/javascript">
    /* <![CDATA[ */
    $(document).ready(function() {
        $('a.clue').aToolTip();
    });
    /* ]]> */
    </script>
	<!-- BEGIN GALLERY -->
		<div class="grid-wrap">
	<div class="grid_4">
	    <div class="panel">
			<h2 class="cap-static">Inspiration</h2>
			<?php if (isset($event_cards)&&count($event_cards)>0){?>
			    <div id="gallery" class="content transitions-enabled infinite-scroll clearfix">
				<?php $last_event_cards = array_reverse($event_cards); 
				foreach (array_slice($last_event_cards, 0, 24) as $card) { 
				    if (isset($card->image)){
                        $img = UPLOADS_URL.$card->image.'_t.jpg';
                        $img_headers = @get_headers($img);
                        if($img_headers[0] == 'HTTP/1.1 404 Not Found') {
                           $img = BASE_URL.'assets/images/no-image.gif';
                        }
                    } else{
                        $img = BASE_URL.'assets/images/no-image.gif';
                    }
				?>
				<!-- GALLERY ITEM -->
				<div class="box <?php echo("cat-".$card->category_id); ?>">
					<a title="<?php echo $card->name; ?>" href="index.php?do=view&card_id=<?php echo $card->id ?>"><img src="<?php echo $img; ?>" alt="" /><p class="title"><span class="name"><?php echo($card->name); ?></span><br /><span class="s-cat-tag <?php echo("cat-".$card->category_id); ?>"><?php echo($categories[$card->category_id]); ?></span></p></a>
				</div>
				<!-- END GALLERY ITEM -->
				<?php unset($card); unset($img); } ?>
			</div>
			<?php }?>
			<!-- END GALERY -->
			<nav id="page-nav">
              <a href="create.php"></a>
            </nav>
		</div>
		<!-- END PANEL -->
	</div>
	<!-- END GRID_4/GALLERY -->
	</div>
</div>
 <!-- Masonry and infinite scroll -->
<script src="assets/js/jquery.masonry.min.js"></script>
<script src="assets/js/jquery.infinitescroll.min.js"></script>
<script>
  $(function(){
    
    var $container = $('#gallery');
    
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.box',
        columnWidth: 260,
        gutterWidth: 16
      });
    });
    
    $container.infinitescroll({
      navSelector  : '#page-nav',    // selector for the paged navigation 
      nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
      itemSelector : '.box',     // selector for all items you'll retrieve
      loading: {
          finishedMsg: 'No more pages to load.',
          img: 'http://i.imgur.com/6RMhx.gif'
        }
      },
      // trigger Masonry as a callback
      function( newElements ) {
        // hide new items while they are loading
        var $newElems = $( newElements ).css({ opacity: 0 });
        // ensure that images load before adding to masonry layout
        $newElems.imagesLoaded(function(){
          // show elems now they're ready
          $newElems.animate({ opacity: 1 });
          $container.masonry( 'appended', $newElems, true ); 
        });
      }
    );
    
  });
</script>