 <link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui-1.8.16.custom.css" type="text/css" media="all" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
 <?php if ($card_id==0){  ?>
 <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
 <script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/branches/dev/ui/jquery.ui.button.js"></script>
 <?php } ?>
 <script src="assets/js/jquery.jeditable.mini.js" type="text/javascript" charset="utf-8"></script>
 <script src="assets/js/jquery.jeditable.ajaxupload.js" type="text/javascript" charset="utf-8"></script>
 <script src="assets/js/jquery.ajaxfileupload.js" type="text/javascript"></script>
 <link rel="stylesheet" type="text/css" href="assets/css/jquery.taghandler.css">
 <!-- Tagg-handler -->
 <script src="assets/js/jquery.taghandler.js" type="text/javascript" charset="utf-8"></script>
 
 <script type="text/javascript">
      /* <![CDATA[ */
      var base_url = "<?php echo BASE_URL;?>";
      var owner_id = "<?php echo $_SESSION['user']->id;?>";
      <?php if(isset($categories)){
        echo("var categories = new Array();\n");
        foreach ($categories as $cat_id=>$cat){ echo("categories[$cat_id]='$cat';\n");}}?>
      var event_id = "<?php echo $_SESSION['event_id']; ?>";
      var card_id = "<?php echo $card_id; ?>";
      var card_img = "<?php if (isset($card->image)){ echo ($card->image); } else{ echo(''); } ?>";
      var card_owner = '<?php if (isset($card->owner)){ echo ($card->owner); } else{ echo(''); } ?>';
        function togglebuttons(saving){
              $("#saving_message").html(saving);
              if(saving == "Card saved."){
                     $('.buttons-disab').hide();
                     $('.buttons-enab').show();
              } else{
                     $('.buttons-disab').show();
                     $('.buttons-enab').hide();
              }
          }
        function viewcard() {
             window.location.href = 'index.php?do=view&card_id='+card_id;
             return false;
        }
      $(document).ready(function() { 
          if (card_id!="0"){
                  togglebuttons("Card saved.");
              }     
              $('#question').editable(base_url+'includes/load_jeditable.php',{
                  indicator : '<img src="assets/images/indicator.gif" alt="" />',
                  cancel    : 'Cancel',
                  submit    : 'OK',
                  tooltip   : 'Click to edit...',
                  placeholder : "Add Source (4)",
                  submitdata : function() {
                          togglebuttons("Saving...");
                          return {controller:'card', card_id : card_id };
                  },
                  data: function(value) {
                      return (value);
                  },
                  callback: function(value, settings) { 
                     togglebuttons("Card saved.");
                     var completed = (value != '') ? $("#question_info").addClass("completed") : $("#question_info").removeClass("completed");
                  }
              });
              $('#name').editable(base_url+'includes/load_jeditable.php',{
                   indicator : '<img src="assets/images/indicator.gif" alt="" />',
                   cancel    : 'Cancel',
                   submit    : 'OK',
                   tooltip   : 'Click to edit...',
                   submitdata : function() {
                           togglebuttons("Saving...");
                           return {controller:'card', card_id : card_id };
                   },
                   data: function(value) {
                       return (value);
                   },
                   callback: function(value, settings) { 
                      togglebuttons("Card saved.");
                   }
               });
              $('#description').editable(base_url+'includes/load_jeditable.php',{
                  type: 'textarea',
                  indicator : '<img src="assets/images/indicator.gif" alt="" />', 
                  cancel    : 'Cancel',
                  submit    : 'OK',
                  rows:'4',
                  placeholder : "Add Summary (5)",
                  submitdata : function() {
                          togglebuttons("Saving...");
                          return {controller:'card', card_id : card_id };
                  },
                  data: function(value) {
                    return (value == 'Add Summary (5)') ? '' : value;
                  },
                  callback: function(value, settings) { 
                      var completed = (value != '') ? $("#fact_info").addClass("completed") : $("#fact_info").removeClass("completed");
                      togglebuttons("Card saved.");
                   }
              }); 
              <?php if(isset($categories)){
                  echo("var data = {");
                  
                  //foreach ($categories as $cat_id=>$cat){ $safe_cat = dirify($cat); echo("'$cat_id':'$cat',");}
                  $string = array();
                     foreach ( $categories as $cat_id => $cat ) {
                         $string[] = '"'.$cat_id.'":"'.$cat.'"';

                     }
                     echo implode( ',', $string );
                     
                  echo("};");
               }?>
              $('.editable_select').editable(base_url+"includes/load_jeditable.php", {
                  type: 'select',
                  data: data,
                  indicator : '<img src="assets/images/indicator.gif" alt="" />',
                  tooltip   : 'Click to edit...',
                  cancel    : 'Cancel',
                  submit : "OK",
                  style  : "inherit",

                  submitdata : function() {
                      togglebuttons("Saving...");
                      return {controller:'card', id:"category_id",card_id : card_id};
                  },
                  callback: function(value, settings) {
                      var newcat = data[value].toLowerCase();
                      $(this).html(newcat);
                      $(this).parent().removeClass().addClass('category '+newcat);
                      $(this).val(value);
                      togglebuttons("Card saved.");
                  }
              });

               $(".ajaxupload").editable(base_url+"includes/upload.php", { 
                       indicator : '<img src="<?php echo(BASE_URL) ?>assets/images/indicator.gif" alt="" />',
                       type      : 'ajaxupload',
                       submit    : 'Upload',
                       cancel    : 'Cancel',
                       tooltip   : "Click to upload...",
                       submitdata : function() {
                           togglebuttons("Saving...");
                           return {card_id: card_id, img: card_img };
                       },
                       callback: function(value) {
                           if (value=='true'){
                               togglebuttons("Card saved.");
                               $("#img_info").addClass("completed");
                           } else {
                               togglebuttons("Card saved.")
                           }
                       }
              });
      });
      /* ]]> */
 </script>
 
 <script>
	    $(function(){
	    var sampleTags = new Array("<?php echo implode('","',$_SESSION['tags']); ?>");
	    var cardTags = new Array(<?php if (count($_SESSION['c_tags'])>0){echo "\"".implode('","',$_SESSION['c_tags'])."\"";} ?>);
	    //var tags = $('#tags');
         $('#tags').tagHandler({
             assignedTags:cardTags,
             availableTags: sampleTags,
             autocomplete: true,
             minChars: 2,
             updateData: { card_id: "<?php echo $card_id?>" },
             updateURL: 'includes/load_tags.php',
             autoUpdate: true,
             delimiter: " ",
             sortTags: false,
             //initLoad: false,
            //onAdd: function(tag) { alert('Added tag: ' + tag); },
            //onDelete: function(tag) { alert('Deleted tag: ' + tag);}
         });
         
	    });
	</script>
  <?php if ($card_id == 0){  ?>
      <script type="text/javascript">
      /* <![CDATA[ */
      $(document).ready(function() {
      $( "#dialog" ).dialog({
                     modal: true,
                     width:530,
                     closeOnEscape: false,
                     open: function(event, ui) { 
                         $(this).parent().find('.ui-dialog-buttonpane button:first-child').next().addClass('ui-priority-secondary');
                         $(".ui-dialog-titlebar-close").hide();
                     },
                     resizable: false,
                     title: 'Your inspiration',
                     buttons: {
                         "create": function(){ 
                             if($("#newcard").valid()){
                                 var action = 'controller=card&action=post&'+$("#newcard").serialize()+"&type=Card&topic_id=1&owner="+owner_id;
                                 $(".ui-dialog-buttonset").html("<img src=\"assets/images/indicator.gif\" alt=\"\" /> Saving card...");
                                 $.post('includes/load.php', action, function(data) {
                                              var card = eval(jQuery.parseJSON(data));
                                              if(card.id) {
                                                   card_id = card.id;
                                                   action = "controller=eventcards&action=post&event_id="+event_id+"&card_id="+card.id+"&category_tag_id="+card.category_id;
                                                   $.post('includes/load.php', action, function(data) {
                                                          var eventcard = eval(jQuery.parseJSON(data));
                                                          if(eventcard.id) {
                                                          $("#dialog").dialog("close");
                                                          $("#dialog").remove();
                                                          $('#name').html(card.name);
                                                          $('#category_id .editable_select').html(categories[card.category_id]);
                                                          $('#category_id').removeClass().addClass('category '+categories[card.category_id]);
                                                          togglebuttons("Card saved.");
                                                          $("#issue_info").addClass("completed");
                                                          $("#steep_info").addClass("completed");
                                                      }
                                                   }).error(function() { alert("error"); })  
                                              }
                                      }).error(function() { alert("error"); }) 
                             }
                          },
                          "cancel": function(){ window.location.href=base_url; return false;}
                     }
       });
      $( "#radio" ).buttonset();
      $("#newcard").validate({
          rules: { name: "required", category_id:"required"},
          messages: { name: "Please enter your card's issue", category_id: "Please choose a category"},
          //errorElement: "span",

      });
 });
      /* ]]> */
</script>
 <?php } ?>
 <?php if ($card_id == 0){  ?>
 <div id="dialog" title="Basic dialog" style="display:none">
 	<form id="newcard" class="dialog">
 	    <h3>1. Title:</h3>
 	    <p>What would you call this insight? If there is a brand associated this would be a good place to put it.</p>
 	   <p><input class="textbox l required editable" name="name" type="text" value="<?php if(isset($edit_event->name)){echo($edit_event->name);}?>" /></p>
 	   <h3>2. Category:</h3>
 	   <p>Into which of the following categories does your insight best fit?</p>
 	   <p id="radio">
 	<?php foreach ($categories as $cat_id => $cat){
 	        $safe_name = dirify($cat);
	        echo('<input type="radio" name="category_id" id="'.$safe_name.'" value="'.$cat_id.'" /><span id="'.$safe_name.'"><label for="'.$safe_name.'">'.$cat.'</label></span>'); } ?>
 	   <label for="category_id" class="error" generated="true"></label>
 	  </p>
 	</form>
 </div>
  <?php }?>
  <?php
  if (isset($card->image)){
          $img = UPLOADS_URL.$card->image.'_l.jpg';
          $img_headers = @get_headers($img);
          if($img_headers[0] == 'HTTP/1.1 404 Not Found') {
             $img = BASE_URL.'assets/images/no-image.gif';
          }
      } else{
          $img = BASE_URL.'assets/images/no-image.gif';
      }
  ?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
		<div class="grid-wrap title-event">
		<div class="grid_3b title-crumbs">
		    <h2 id="name" class="editable"><?php if (isset($card->name)){ echo $card->name; } else{ echo'Untitled (1)';} ?></h1>
			<h2 id="category_id" class="category <?php if (isset($card)){ echo $categories[$card->category_id]; } else{ echo'grey';} ?>"><span class="editable_select"><?php if (isset($card)){ echo $categories[$card->category_id]; } else{ echo'category (2)';} ?></span></h2>
		</div>
		<div class="grid_1b align_right pad-h1  chi">
		    <span id="saving_message">Saving card...</span>&nbsp;&nbsp;
		    <span class="buttons-enab" style="display:none">
			<a id="viewcard" href="#" onClick="viewcard()" class="button blue small">View card</a> <a href="#" onClick="trashcard()" class="button red small">Move to trash</a>
			</span>
			<span class="buttons-disab">
			<p href="#" class="button disabled small">View card</p> <?php if(isset($card_id)){ ?><p href="" class="button disabled small">Move to trash</p><?php } ?>
			</span>
		</div>
	</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
    <div class="grid-wrap">
	<!-- BEGIN FORM STYLING -->
	<div id="insight" class="grid_3b">
		<div class="panel">
		    <div id="img"><img src="<?php echo $img?>" /></div>
		    <div class="ajaxupload content no-cap">
		    <?php if (isset($card->image)){ echo ( 'Wrong image? Click here to change it.'); } else{ echo('Upload Image (4)'); }?></div>
		    </p>
		</div>
		<div class="panel">
           <p id="question" class="content no-cap push-down editable"><?php if (isset($card)){ echo $card->question; } else{ echo'Add Source (4)';} ?></p>
        </div>
        <div class="panel">
             <p id="description" class="content no-cap push-down"><?php if (isset($card->description)){ echo $card->description; } else{ echo'Add Summary (5)';} ?></p>
        </div>
	</div>
	<!-- END FORM STYLING -->
	<!-- BEGIN PLAIN TEXT EXAMPLE
	 	 The simplest one of all, just some regular ol' text in a panel. -->
	<div class="grid_1b">
		<div class="panel card_info">
    		    <h2 class="cap">Card components</h2>
    		   <div class="content" >
    		    <div id="issue_info"<?php if (isset($card->name)&&$card->name!=""){ echo " class=\"completed\""; } ?>>
				<h4>1. Title</h4>
                <p>What would you call this insight? If there is a brand associated this would be a good place to put it.</p>
                </div>
                <div id="steep_info"<?php if (isset($card->category_id)&&$card->category_id!=""){ echo "class=\"completed\""; } ?>>
                <h4>2. Category</h4>
                <p>Into which category does your insight best fit? (<?php echo implode(", ",$categories) ?>). </p>
                </div>
                <div id="img_info"<?php if (isset($card->image)&&$card->image!=""){ echo "class=\"completed\""; } ?>>
                <h4>3. Image</h4>
                <p>upload an image, sketch or graphic, which illustrates  your innovation at a glance. (Up to 15Mb in file size).</p>
                </div>
                <div id="question_info"<?php if (isset($card->question)&&$card->question!=""){ echo "class=\"completed\""; } ?>>
                <h4>4. Source</h4>
                <p>Where can we find this information again and again? (copy and paste URL link here).
                </p>
                </div>
                <div id="fact_info"<?php if (isset($card->description)&&$card->description!=""){ echo "class=\"completed\""; } ?>>
                <h4>5. Summary</h4>
                <p>Tell us a bit more about your insight/innovation? What it is? What makes it so compelling you submitted it? (in about 40 words or less)</p>
                <!-- <form id="tag-it" action="javascript:void(0);">
                                    <h4>Tags</h4>
                                    <p>Additionally, you can add some <b>tags</b> or keywords below to describe your card's topic:</p>
                                    
                                </form> -->
                </div>
			</div>
		</div>
		<div class="panel tag_holder">
    		    <h2 class="cap">Tags</h2>
    		        <ul id="tags"> </ul>
    		        <p>Separate tags with commas, spaces or return.</p>
    	</div>
	</div>
	</div>	
</div>