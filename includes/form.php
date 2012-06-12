<?php //var_dump($edit_event);?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Add event</h2>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=admin" class="button medium">Back to Listing</a>
    		</div>
	    </div>
    </div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
<div class="grid-wrap">
	<!-- BEGIN FORM STYLING -->
	<div class="grid_3">
		<div class="panel form">
		    <span class="message"></span>
			<div class="content no-cap">
				<!-- Any form you want to use this custom styling with must have the class "styled" -->
				<form id="event" class="styled">
					<fieldset>
						<!-- Text Field -->
						<label class="align-left">
							<span>Event name<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($edit_event->name)){echo($edit_event->name);}?>" />
						</label>
							<!-- Text Field -->
    						<label class="align-left">
    							<span>Event subtitle<strong class="red"></strong></span>
    							<input class="textbox l editable" name="summary" id="summary" type="text" value="<?php if(isset($edit_event->summary)){echo($edit_event->summary);}?>" />
    						</label>
							<!-- Text Field -->
    						<label class="align-left" for="textField">
    							<span>Event url</span>
    						    <input class="l readonly" id="url" type="text" value="<?php if(isset($edit_event->name)){echo(BASE_URL.'index.php?event='.$edit_event->id);}?>" readonly="readonly" />
    						</label>
						   	<!-- Collection -->
        					<label class="align-left m" for="collection_id">
    							<span>Categories</span>
    							<select class="chosen" name="collection_id">  
    							    <?php foreach ($collections as $key=>$collection){ 
    							        $sel = "";
    							        if ($key == $edit_event->collection_id){
    							            $sel = " SELECTED";
    							        }
    							        echo('<option value='.$key.$sel.'>'.$collection['name'].'</option>');}?>
    							</select>
    						</label>
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Event description</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($edit_event)){echo($edit_event->description);}?></textarea>
						</label>
						<!-- date -->
						<label class="align-left" for="startpicker">
							<span>Date from<strong class="red">*</strong></span>
							<input type="text" id="startpicker" value="" class="editable" />
							<input type="hidden" id="start" name='start' value="">
						</label>
						<label class="align-left" for="endpicker">
							<span>Date to</span>
							<input type="text" id="endpicker" value="" class="editable" />
							<input type="hidden" id="end" name='end' value="">
						</label>
						<!-- Tick box -->
						<div class="non-label-section">
						    <p class="check-pair">
                                <label>
                                    <input type="hidden" name="auto_close" value="false" />
                                    <input type="checkbox" name="auto_close" value="true" <?php if(isset($edit_event) && $edit_event->auto_close){echo 'checked';}?> class="editable" /> Close event automatically after end date</label></p>
							  <p class="check-pair">
							      <label>
							    <input type="hidden" name="allow_anon" value="false" />
							    <input type="checkbox" name="allow_anon" value="true" <?php if(isset($edit_event) && $edit_event->allow_anon){echo 'checked';}?> class="editable" />
							    Allow anonymous card submissions
							    </label>
							</p>
							 <p class="check-pair">
 							      <label>
 							    <input type="hidden" name="auto_publish" value="false" />
							    <input type="checkbox" name="auto_publish" value="true" <?php if(isset($edit_event) && $edit_event->auto_publish){echo 'checked';}?> class="editable" />
							    Auto-publish submitted cards
							</label>
							</p>
						</div>
						<!-- Pass Field -->
						<label class="align-left" for="password">
							<span>Secret code</span>
							<input type="hidden" name="private" id="private" value="false" />
							<input class="textbox s editable" name="password" id="password" type="text" value="<?php if(isset($edit_event)){echo($edit_event->password);}?>" /> <?php if(isset($edit_event)&&$edit_event->private){echo("(private event)");}?>
						</label>
						
						<!-- Buttons -->
						<div class="non-label-section">
						    <input type="button" id="save" class="button medium blue" value="Save" />
							<a href="index.php?do=admin" class="button medium">Cancel</a>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	
	<!-- END FORM STYLING -->
	<div class="grid_1">
		<div class="panel">
		    <h2 class="cap">Lorem Ipsum</h2>
		    	<div class="content">
		    	    <p><strong class="red">*</strong> Indicates required fields</p>
    				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    			</div>
		</div>
	</div>
	<?php if (isset($event_cards)){?>
	<div class="grid_4">
	    <div class="panel">	
	        <h2 class="cap">Event cards</h2>
			<!-- gallery -->
			<div class="content gallery">
				<div class="gallery-wrap">
					<div class="gallery-pager">
						<?php foreach (array_reverse($event_cards) as $card) { ?>
						<!-- GALLERY ITEM -->
						<div class="gallery-item">
							<a class="clue" title="<?php echo $card->name; ?>" href="index.php?do=view&card_id=<?php echo $card->id ?>"><img src="<?php if (isset($card->card_front)){ echo (UPLOADS_URL."fronts/".$card->card_front."_t.jpg");}?>" alt="" /></a>
						</div>
						<!-- END GALLERY ITEM -->
						<?php unset($card); } ?>
					</div>
				</div>
			
				<!-- The gallery pagination/options area. -->
				<div class="pager">
				
					<!-- Gallery options - these should probably become active once you've checked an image or more. -->
					<!-- <div class="gallery-options">
					                       <a class="button red small" href="#">Delete</a>
					                       <a class="button blue small" href="#">Edit</a>
					                   </div> -->
					
					<!-- Gallery pagination -->
					<form action="">
						<a class="button small first"><img src="assets/images/table_pager_first.png" alt="First" /></a>
						<a class="button small prev"><img src="assets/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small next"><img src="assets/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small last"><img src="assets/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>
			
			</div>
			<!-- END CONTENT -->
			
		</div>
		<!-- END PANEL -->
	</div>
	<?php }?>
 </div>
</div>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<?php if(!isset($edit_event_id)){$edit_event_id=0;} ?>
<script type="text/javascript">//<![CDATA[
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var edit_event = <?php echo($edit_event_id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
    //setup datepickers
    function milsToSecs(picker, altField){
        var date = picker.datepicker('getDate');
        var epoch = date.valueOf() / 1000;
        altField.val(epoch);
        //alert(altField.val());
    }
	$( "#startpicker" ).datepicker({
	  dateFormat: 'dd/mm/yy',
      altField: '#start',
      altFormat: '@',
      onSelect: function(dateText, inst) {
          milsToSecs($(this),$('#start'));
          handleFormChanged();
          }
    });
    $( "#endpicker" ).datepicker({
      dateFormat: 'dd/mm/yy',
      altField: '#end',
      beforeShow: customRange,
      altFormat: '@',
      onSelect: function(dateText, inst) {
         milsToSecs($(this),$('#end'));
         handleFormChanged();
        }
    });
    function customRange(a) {//start second one always from first date
        var b = new Date();
        var c = new Date(b.getFullYear(), b.getMonth(), b.getDate());
        if (a.id == 'endpicker') {
            if ($('#startpicker').datepicker('getDate') != null) {
                c = $('#startpicker').datepicker('getDate');
            }
        }
        return {
            minDate: c
        }
    }
    //if adding event edit_event == 0
    if (edit_event != 0){
        var action = 'controller=event&action=put&id='+edit_event;
        var dstart = '<?php if(isset($edit_event)){echo($edit_event->start);}?>';
        var dend = '<?php if(isset($edit_event)){echo($edit_event->end);}?>';
        if (dstart!='0'&&dstart!=''){
            $('#startpicker').datepicker('setDate', $.datepicker.parseDate('@',dstart+'000'));
            $('#start').val(dstart);
        }
        if (dend!='0'&&dend!=''){
            $('#endpicker').datepicker('setDate', $.datepicker.parseDate('@',dend+'000'));
            $('#end').val(dend);
        }
    } else{
        var action = 'controller=event&action=post&eventtype=3&owner='+owner;
        $('#startpicker').datepicker('setDate', new Date());
    }
    
    $("#event").validate({
        rules: { name: "required", startpicker:"required"},
        messages: { name: "Event name is required", startpicker: "Please enter a start date"}
    });
    
    $('#event input.editable, #event textarea.editable').each(function (i) {
         $(this).data('initial_value', $(this).val());
    });

    $('#event input.editable, #event textarea.editable').keyup(function() {
         if ($(this).val() != $(this).data('initial_value')) {
              handleFormChanged();
         }
    });
    
    //if something is edited, show save button, and display alert on page leave

    $('#event .editable').bind('change paste', function() {
         handleFormChanged();
    });
    $('#startpicker').bind('change paste', function() {
         milsToSecs($(this),$('#start'));
         handleFormChanged();
    });
    $('#endpicker').bind('change paste', function() {
         milsToSecs($(this),$('#end'));
         handleFormChanged();
    });
    
    //automatically apend url on name change
    $('#name').keyup(function () {
     var value = $(this).val();
     $('#url').val(baseurl + value);
    });
    
    //set value of private on password change
    $('#password').keyup(function() {
     var value = $(this).val();
     if (value){
         $('#private').val('true');
     } else{
         $('#private').val('false');
     }
    });
    
    //bind save button
    $("#save").click(function() {
      if($("#event").valid()){
          $(window).unbind("beforeunload");
          //alert(action+'&'+$("#event").serialize());    
           $.post('includes/load.php', action+'&'+$("#event").serialize(), function(data) {
                displayAlertMessage(data);
             }).error(function() { alert("There was an error saving your event, please try again later."); })
      }
      return false;
    });
});

   function handleFormChanged() {
        $(window).bind('beforeunload', confirmNavigation);
        formChanged = true;
   }
   function confirmNavigation() {
        if (formChanged) {
             return ('One or more forms on this page have changed. Your changes will be lost!');
        } else {
             return true;
        }
   }
//]]></script>