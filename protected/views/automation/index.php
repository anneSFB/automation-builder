<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8"/>
		<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/> -->
        <title>Automation Builder</title>
        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/build/rappid.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/layout.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/paper.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/inspector.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/navigator.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/stencil.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/halo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/selection.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/toolbar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/statusbar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/freetransform.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css" />
		
		<style>		
		.inspector-container{ top: 50px; bottom: 0; z-index: 100;     display:none; }
		.navigator-container{ 
			bottom: 56px;
			right: 27px;
			border: 1px solid #ccc;
		}
		.paper-container{ 
			top: 50px; 
			bottom: 40px; 
			right: 0;
		}
		.paper-scroller {
			overflow: hidden;
		}
		.toolbar-container .btn{
			margin: 7px 2px 0;
			padding: 2px 8px;
			border: 1px solid #ccc;
			border-radius: 3px;
		}
		.toolbar-container{
			bottom: 0;
			top: auto;
			z-index: 0;
			background: white;
			border-top: 1px solid #e2e6ea;
			color: #243d61;
			text-shadow: none;
			height: 50px;
		}
		.header-container{
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			padding-left: 246px;
			height: 49px;
			border-bottom: 1px solid #ccc;
			background: white;
		}
		.header-container .header-title{
			border: 0 none;
			color: #2a4165;
			display: inline-block;
			font-size: 18px;
			font-weight: bold;
			margin: 12px 20px;
			width: 70%;
			outline: 0;
		}
		.header-container .btn-publish{
			float: right;
			padding: 9px 30px;
			font-size: 16px;
			margin: 5px 10px;
			padding: 9px 15px 9px 30px;
			background: #4ecdc4;
			border: 0;
			border-radius: 3px;
			color: white;
			outline: 0;
		}
		.inspector .group { padding-top: 0; }
		
		.stencil-container { top: 0; bottom: 0; z-index: 100; border-top: 0; width: 241px;}
		.stencil { top: 0; bottom: 0; z-index: 100; top: 50px; }
		.stencil .group {
			padding-left: 0;
		}
		.stencil .group .elements {
			margin: 0;
			background: #f6f8f9;
		}
		.stencil .group>.group-label {
			padding: 10px 15px;
			left: 0;
			background: #e8ecef;
			color: #2d4367;
			border: 0;
			font-size: 13px;
			font-weight: normal;
			margin-right: 0;
		}
		.stencil .group>.group-label:before {
			content: none;
		}
		.stencil > .content {
			background: #f6f8f9;
		}
		.stencil-tab-container{
			margin-left: 3px;
			width: 98%;
			display: inline-block;
		}
		ul.stencil-tabs{
			list-style: none;
			margin: 0;
			padding: 0;
		}
		ul.stencil-tabs li {
			display: inline-block;
			width: 49%;
			text-align: center;
			padding: 14px 0;			
		}
		ul.stencil-tabs li:hover {
			cursor: pointer;
			color:#2d4367;
			border-bottom: 2px solid #6bc4f5;
		}
		ul.stencil-tabs li.active {
		    border-bottom: 2px solid #6bc4f5;
			color:#2d4367;
		}
		ul.stencil-tabs li.active2 {
		    border-bottom: 2px solid #6bc4f5;
			color:#2d4367;
		}
		.stencil .elements .element.basic.Image text, .stencil .elements .element.devs.Atomic .inPorts text, .stencil .elements .element.devs.Atomic .outPorts text, .stencil .elements .element.pn.Transition text {
			display: initial;
		}
		.btn-editmode{
			border-top-right-radius: 0 !important;
			border-bottom-right-radius: 0 !important;
			font-size: 13px;
			padding: 2px 13px !Important;
			float: right;
			margin-right: 0 !important;
			margin-left: 2px !important;
		}
		.btn-livemode{
			border-top-left-radius: 0 !important;
			border-bottom-left-radius: 0 !important;
			font-size: 13px;
			padding: 2px 13px !Important;
			float: right;
			margin-right: 10px !important;
			margin-left: -1px !important;
		}
		.btn-editmode.active,.btn-livemode.active{
			background: #8493a8;
			color: white;			
		}
		.dialog .fg {
			border-radius: 2px;
			color: #2d4367;
			font-size: 14px;
			letter-spacing: 1px;
		}
		.dialog .titlebar {
			border-bottom: 0;
			color: #2d4367;
		}
		.dialog .body{
			font-size: 11px;
		}
		.dialog .body label {
			display: block;
			margin: 5px 0 10px;
		}
		.dialog .body input.delaynum {
			padding: 6px;
			border: 2px solid #ccc;
			border-radius: 2px;
			color: #2d4367;
			font-size: 14px;
			margin: 0;
			outline: 0;
			width: 30px;
			text-align: center;
		}
		.dialog .body button#delaybtn {
			float: right;
			background: #1ca5f0;
			border: 0;
			color: white;
			padding: 7px 15px;
			border-radius: 2px;
			margin-top: 15px;
			font-size: 11px;
			letter-spacing: 1px;
		}
		.connection-wrap:hover {
			opacity: 0;
		}
		.link .marker-arrowheads { display: none; }
		a#delayremove{ color:red;text-decoration:none }
		a#delayremove .delay-x{ border:1px solid red;padding:0 4px;border-radius:10px;display:inline-block;margin-top:20px}
		a#delayremove:hover{ text-decoration:underline }
		
		ul.list-conditions{ 
			padding: 0;
			list-style: none;
			border-left: 20px solid transparent;
			background: transparent;
		}	
		ul.list-conditions::before{ 
			content: " ";
			width: 0; 
			height: 0; 
			border-top: 5px solid transparent;
			border-bottom: 5px solid transparent; 			  
			border-right:6px solid #465a77;
			font-size: 0px;
			position: absolute;
			left: -5px;
			top: 10px;
		}		
		ul.list-conditions li:hover{
			opacity: .9;
		}
		ul.list-conditions li{ 
			background: #465a77;
			padding: 3px 20px 3px 10px;
			font-size: 11px;
			color: white
		}
		ul.list-conditions li:first-child{ padding-top:8px; border-top-right-radius: 3px; border-top-left-radius: 3px;}
		ul.list-conditions li:last-child{  padding-bottom:10px; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; }
		ul.list-conditions li div{     
			display: inline-block;
			width: 8px;
			height: 8px;
			background: white;
			border-radius: 5px;
			margin-right: 5px;
		}
		
		.halo.surrounding .handle.eRemove {
			background: url("<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/delete.jpg") no-repeat !important ;
			background-size: contain !important;
			position: relative;
			height: 20px !important;
			width: 100px;
			margin-left: 5px;
			top: 30px;
		}
		.halo.surrounding .handle.eAddport {
			background: url("<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/addport.jpg") no-repeat !important;
			background-size: contain !important;
			position: relative;
			height: 20px !important;
			width: 100px;
			margin-left: 5px;
			bottom: 15px;
		}
		.halo.surrounding .handle.eConfigure {
			position: relative;
			background: url("<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/configure.jpg") no-repeat !important;
			background-size: contain !important;
			height: 24px !important;
			width: 100px;
			margin-left: 3px;
			bottom: 60px;
		}				
		.halo.surrounding .handles{
			background: #465a77;
			border-radius: 3px;
			height: 77px;
			margin-left: calc(100% + 10px);
			width: 100px;
			border: 1px solid #465a77;
		}
		.handles::before{
			content: " ";
			width: 0; 
			height: 0; 
			border-top: 5px solid transparent;
			border-bottom: 5px solid transparent; 			  
			border-right:6px solid #465a77;
			margin-left: -6px;
			font-size: 0px;
		}
		.handle.eRemove::after {
			content: 'Delete';
		}
		.handle.eConfigure::after {
			content: 'Configure';
		}
		.handle.eAddport::after {
			content: 'Add Port';
		}
		.handle.eRemove::after, .handle.eConfigure::after, .handle.eAddport::after{
			color: white;
			font-size: 14px;
			font-weight: initial;
			padding-left: 25px;
			position: relative;
		}
		
		.link-tools .tool-options {
			display: none !important;
		}
		.action_exclam{ display:none}
		.paper .action_exclam{ display:block !important; cursor:pointer; }
		.delay_exclam{ display:none}
		.paper .delay_exclam{ display:block !important; cursor:pointer; }
		.trigger_exclam{ display:none}
		.paper .trigger_exclam{ display:block !important; cursor:pointer; }
		table.saveguide{
			width:100%
		}
		table.saveguide input, table.saveguide textarea, table.saveguide select{
			border: 2px solid #ccc;
			border-radius: 2px;
			color: #2d4367;
			font-size: 12px;
			margin: 0;
			outline: 0 none;
			padding: 6px;
			width:95%;
		}
		table.saveguide textarea{
			height: 100px;
		}
		button#saveguidebtn {
			background: #1ca5f0 none repeat scroll 0 0;
			border: 0 none;
			border-radius: 2px;
			color: white;
			float: right;
			font-size: 11px;
			letter-spacing: 1px;
			margin: 0 10px 20px;
			padding: 7px 15px;
		}
		ul.tag_list{
			list-style: none;
			border: 2px solid #ccc;
			border-radius: 2px;
			color: #2d4367;
			font-size: 12px;
			margin: 0;
			outline: 0 none;
			padding: 6px;
			width:95%;
		}
		ul.tag_list li.taglist{
			display: inline-block;
		}
		ul.tag_list li.tagselected{
			background: #ccc none repeat scroll 0 0;
			border: 1px solid #ccc;
			border-radius: 3px;
			padding: 4px 10px;
			margin-right: 5px;
			margin-top: 2px;
		}
		ul.tag_list li.tagselected a{
			color: red;
			font-size: 8px;
			font-weight: bold;
			position: relative;
			right: -5px;
			text-decoration: none;
			top: -2px;
		}
		ul.tag_list li input#tem_tags.loading{
			background: rgba(0, 0, 0, 0) url("<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/loading.gif") no-repeat scroll right center;
		}
		ul.tag_list li input#tem_tags{
			border:0;
			box-shadow: none;
			width: 97%;
		}
		#tem_thumb_error{
			color:red;
			display: inline-block;
			padding-left: 20px;
		}
		#tem_thumb_prev{
			display: inline-block; vertical-align: middle; width: 20%; margin-right: 10px;
		}
		input#tem_thumb{
			border: 0;
			width: 70%;
		}
		input#tem_thumb.loading{
			background: rgba(0, 0, 0, 0) url("<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/loading.gif") no-repeat scroll right center;
		}
		.red{
			color: red;
		}
		#confightml{
			min-height:100px;
			font-size: 13px;
			line-height: 30px;
		}
		#confightml select{
			border: 2px solid #ccc;
			border-radius: 2px;
			color: #2d4367;
			font-size: 12px;
			margin: 0;
			outline: 0 none;
			padding: 6px;
			width: 98.5%;
		}
		button#saveconfigbtn {
			background: #1ca5f0 none repeat scroll 0 0;
			border: 0 none;
			border-radius: 2px;
			color: white;
			float: right;
			font-size: 11px;
			letter-spacing: 1px;
			margin: 0 10px 20px;
			padding: 7px 15px;
			cursor: pointer;
		}
		.paper text.label1 {
			font-weight: bold;
		}
		</style>
    </head>
    <body>
        <div class="header-container">
			<input type="text" id="projname" placeholder="Type your workflow name here..." class="header-title"/>
			<select class="btn-publish" id="btn-projselect">
				<option value="">Publish</option>
				<option value="">Settings</option>				
				<?php if(isset($_REQUEST['id'])){ ?>  				
				<option value="btn-createnew">Create New Workflow</option>
				<option value="btn-updateworkflow">Update Workflow</option>
				<?php }else{ ?> 
				<option value="btn-save">Save &amp; Exit</option>
				<option value="btn-saveguide">Save as Guide</option>
				<?php } ?>
				<option value="btn-delete">Delete</option>
				<option value="btn-viewall">View Projects</option>
			</select>         
            <!--button id="btn-delete" class="btn-publish" data-tooltip="Delete Project" style="display:none">delete</button>
			<button id="btn-save" class="btn-publish" data-tooltip="Save Project">save</button>  
			<button id="btn-viewall" class="btn-publish" data-tooltip="View All Project">view projects</button-->
		</div>        
        <div class="stencil-container">
			<div class="stencil-tab-container">
				<ul class="stencil-tabs stenciltabtrigger">
					<li class="sten_tab active" id="sten_t">Triggers</li>
					<li class="sten_tab" id="sten_a">Actions</li>
				</ul>
				<ul class="stencil-tabs stenciltabproject" style="display:none">
					<li class="sten_tab active2"id="sten_p" style="width:99%">
						Workflow Projects <a href="javascript:void(0);" id="btn-viewallclose" style="float:right"><small>close</small></a>
					</li>
				</ul>
			</div>
			<div style="text-align:center;margin-top:50px">
				<img class="startloading" src="https://www.wcupa.edu/images/spinner.gif">
			</div>
			<div id="projectlistcontainer" style="display:none">
				<ol style="color:black;font-size:13px" class="projectlist">
					<?php if(count($projectlist) > 0){
						foreach($projectlist as $row) { ?>
							<li><a href="javascript:void(0)" class="loadproject" data-id="<?php echo $row->w_id?>"><?php echo $row->w_name?></a></li>
						<?php } ?>
					<?php } ?>

				</ol>
			</div>
		</div>
        <div class="paper-container"></div>
        <div class="navigator-container"></div>
		<div class="inspector-container"></div>
        <div class="toolbar-container">
			<div style="width: 40%; text-align: left; padding-left: 10px;margin-top: 15px;" class="panel">
				<span style="text-align: left;">Helping tips here....</span>
			</div>
						
			<button id="btn-linkdialog" class="btn btn-livemode">Live Mode</button>
			<button class="btn btn-editmode active">Edit Mode</button>
			<button id="btn-fullscreen" class="btn" data-tooltip="Toggle Fullscreen Mode" style="float: right;"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/fullscreen.png" alt="Fullscreen"/></button>
            <button id="btn-zoom-to-fit" class="btn" data-tooltip="Zoom To Fit" style="float: right;"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/zoomtofit.png" alt="Zoom To Fit"/></button>
            <button id="btn-zoom-in" class="btn" data-tooltip="Zoom In" style="float: right;"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/zoomin.png" alt="Zoom in"/></button>
			<input type="range" id="zoom-range"  min="20" max="200" step="20" style="float: right;margin-top: 24px;">
            <input type="hidden" id="zoom-range-before">
			<button id="btn-zoom-out" class="btn" data-tooltip="Zoom Out" style="float: right;"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/zoomout.png" alt="Zoom out"/></button>
			<div class="panel" style="float: right;margin-top: 15px;">
				<span id="zoom-level">100</span><span>%</span>
            </div>
			
			<input type="hidden" id="current_id" value="<?php if(isset($_REQUEST['id'])){ echo $_REQUEST['id']; } ?>"/>
			<input type="hidden" id="current_cond" value=""/>
			<input type="hidden" id="current_cond_label" value=""/>
			<input type="hidden" id="base_url" value="http://burganic.com/projects/workflow/"/>
        </div>
		<div id="preview" class="preview" style="display: block;"></div>
        <!--div class="statusbar-container"><span class="rt-colab"></span></div-->

        <!-- Dependencies: -->
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/node_modules/jquery/dist/jquery.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/node_modules/lodash/index.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/node_modules/backbone/backbone.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/node_modules/graphlib/dist/graphlib.core.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/node_modules/dagre/dist/dagre.core.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/lib/KeyboardJS/keyboard.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/build/rappid.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/src/inspector.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/src/stencil.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/src/main.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
		<script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>js/jquery.ui.widget.js"></script>
		<script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>js/jquery.iframe-transport.js"></script>
		<script src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>js/jquery.fileupload.js"></script>
		<!--[if IE 9]>
			<script src="./lib/base64/base64.js"></script>
			<script type="text/javascript">
			  // SVG Export requires window.btoa/atoa extension to convert binary data (the `b`)
			  // to base64 (ascii, the `a`). Unfortunately it is not available in IE9.
			  // To get it working under IE9 you may include compatible solution like `stringencoders`
			  // (`https://code.google.com/p/stringencoders/source/browse/trunk/javascript/base64.js`)
			  // and create a global alias `btoa`.
			  window.btoa = base64.encode
			  // `-ms-user-select: none` doesn't work in IE9
			  document.onselectstart = function() { return false; };
			</script>
		<![endif]-->
        <script>
            // Uncomment the following line and comment the line after if you
            // want to use channels.
            //var app = new Rappid({ channelUrl: 'ws://localhost:4141' });
            var app;
	
			$(function(){
				setTimeout(function() {
					app = new Rappid;
					Backbone.history.start();
				},500);
				
				$('#btn-viewall').on('click',function(){
					$('.stenciltabproject').show();
					$('.stenciltabtrigger').hide();
					
					$('.group').hide();					
					$('.listofprojects').show();
				});
				
				$('#btn-viewallclose').on('click',function(){	
					$('.stenciltabproject').hide();
					$('.stenciltabtrigger').show();										
				});
				
				$('.sten_tab').on('click',function(){
					var id = $(this).attr('id');
					$('.sten_tab').removeClass('active');
					
					if(id=='sten_a'){
						$('.group').hide();
						$('.listofactions').show();	
						$('#'+id).addClass('active');						
					}else if(id=='sten_t'){
						$('.group').show();
						$('.listofactions').hide();
						$('.listofprojects').hide();
						$('#'+id).addClass('active');
					}else if(id=='sten_p'){
						$('.group').show();
						$('.listofactions').hide();
						$('.listofprojects').hide();
						$('#sten_t').addClass('active');
						
						$('.stenciltabproject').hide();
						$('.stenciltabtrigger').show();
					}				
				});
				
				
					
				<?php if(isset($_REQUEST['d'])){ ?>				
					setTimeout(function() {
						$('.stenciltabproject').show();
						$('.stenciltabtrigger').hide();
						
						$('.group').hide();					
						$('.listofprojects').show();
					},1000);
				<?php } ?>
					
				//$.post('http://burganic.com/projects/workflow/yii/index.php?r=automation/gettagsbykey',{key:'mar'},function(res){
				//console.log(res);
				//});
				
			});
        </script>
    </body>
</html>
