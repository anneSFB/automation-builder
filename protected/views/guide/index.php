<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Workflow Guide Templates</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	body{
		background: #e8ecef;
		color:#20395e;
		font-family: 'Lato', sans-serif;
	}
	.menuheader{
		background:white;
		border-bottom: 1px solid #ccc;
	}
	.menuheader ul.menutab{
		list-style: none;
		padding: 0;
		margin: 0;
		margin-bottom: -1px;
	}
	.menuheader ul.menutab li:hover{
		cursor: pointer;
	}
	.menuheader ul.menutab li a{
		color: inherit;
	}
	.menuheader ul.menutab li a:hover{
		text-decoration: none;
	}
	.menuheader ul.menutab li{
		display: inline-block;
		padding: 15px 5px;
		font-size: 16px;
	}
	.menuheader ul.menutab li.active{
		color: #387aac;
		border-bottom: 3px solid;
		font-size: 17px;
	}
	.guidebox{
		background:white;
		padding: 20px;
		margin-bottom: 30px;
	}
	.guidebox .label.tags:hover{
		cursor: pointer;
		background: #ccc;
	}
	.guidebox .label.tags{
		font-weight: normal;
		border-radius: 10px;
		background: #e8ecef;
		color: inherit;
		margin-right: 10px;
		padding: 4px 15px;
	}
	.guidebox .btn.usebtn{
		background-color: #1ca5f0;
		border-color: #1ca5f0;
		border-radius: 3px;
		padding: 5px 40px;
		font-size: 15px;
	}
	.categorylabel{
		font-size: 15px;
		color: #ccc;
		margin-top: 5px;
		text-transform: uppercase;
	}
	.guideheader{
		border-bottom:1px solid #e8ecef; 
		padding: 0;
		margin-bottom:20px;
	}
	.guideheader p{
		line-height: 23px;
		margin-bottom: 20px;
	}
	.guidethumb{
		padding-left: 0;
		padding-top: 15px;
	}
	.guidefilter{
		background:white;
		padding: 20px;
	}
	.guidecategories{
		list-style: none;
		padding: 0;
	}
	.filterheader{
		border-bottom: 1px solid #e8ecef;
		margin-top: 0;
		padding-bottom: 15px;
		margin-bottom: 15px;
	}
	.guidecategories li{
		font-size: 16px;
		padding: 8px 0;
	}
	.guidecategories li input[type="checkbox"]{
		margin-right: 5px;
	}
	input[type=checkbox] { visibility: hidden; width: 30px; height: 15px;}
	input[type=checkbox]:before { content: '  '; border: 1px solid lightgray; width: 1em; color: #4bb2ff; font-size: 17px; line-height: 1em; text-align: center; text-shadow: 0 0 0.0714em #4bb2ff; font-weight: bold; padding: 0 .7em; border-radius: 1px; cursor: pointer;	visibility: visible;}
	input[type=checkbox]:checked:before { content: '\2713'; padding: 0 .3em; }
	
	@-moz-document url-prefix("") {
		input[type="checkbox"] {
			visibility: visible;
		}
	}
	#searchkeyword{
		border: 2px solid #ccc;
		border-radius: 2px;
		border-right: 0;
		height: 43px;
		box-shadow: none;
	}
	#searchkeybtn{
		border: 2px solid #ccc;
		border-left: 0;
		height: 43px;
		outline: 0;
	}
	</style>
  </head>
  <body>		
		<div class="container-fluid">
			<div class="row menuheader">
				<div class="col-md-6">
					<ul class="menutab">
						<li><a href="<?php echo Yii::app()->getBaseUrl(true);?>">Automations</a></li>
						<li>&nbsp;</li>
						<li class="active"><a href="<?php echo Yii::app()->getBaseUrl(true);?>/index.php?r=guide">Guides Library</a></li>
						<li>&nbsp;</li>
						<li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/index.php?r=managecategory">Manage Category</a></li>
					</ul>
				</div>
				<div class="col-md-6 text-right">
					<!--icons here-->
				</div>
			</div>
			
			<br>
			<h3 style="padding-left: 15px;"><b>Guides Library</b></h3>
			<br>
			
			<div class="row">
				<div class="col-md-3" style="padding-left: 30px; padding-right: 0;">
					<div class="guidefilter">
						<h4 class="filterheader"><b>Filters</b></h4>
						<h4 class="filtercategory">Category</h4>
						<ul class="guidecategories">
							<li><input type="checkbox" name="category" value="all" checked id="allcat"/> All Categories</li>
							<?php if(count($categories) >0 ){ ?>
							<?php foreach ($categories as $row) { ?>
							<li><input type="checkbox" name="category" value="<?php echo $row['c_id'];?>"> <?php echo $row['c_name'];?></li>
							<?php } ?>
							<?php } ?>
						</ul>
						<br>
						<h4 style="font-size: 16px;">Best Use</h4>
						<div class="input-group">
							<input type="text" class="form-control" id="searchkeyword" placeholder="Keywords" value="<?php echo (isset($_GET['tag']))?$_GET['tag']:'';  ?>">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="searchkeybtn"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>plugins/rappid/img/search.png" style="width: 16px;"></button>
							</span>
						</div>
						<br>
					</div>	
				</div>	
				<div class="col-md-9" >
					<div class="alert alert-info guidecontentloader" role="alert" style="margin: 0 15px 10px;display:none;"><img src="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>images/icons/loading.gif"> &nbsp;loading content...</div>
					<div id="guidecontent">				
						<?php if(count($templates) >0 ){ ?>
							<?php foreach ($templates as $row) { ?>
								<div class="col-md-6">
									<div class="guidebox">
										<div style="display: table;">
											<div class="col-md-12 guideheader">
												<div class="col-md-3 guidethumb">
													<img src="<?php echo ($row['wt_thumb']!=''?$row['wt_thumb']:Yii::app()->getBaseUrl(true) . '/'.'images/guides/blank.gif');?>" style="width: 100%;">
												</div>
												<div class="col-md-9" style="padding: 0;">
													<h4><?php echo $row['w_name'];?></h4>
													<div style="height: 90px;    overflow: hidden;"><?php echo $row['w_desc'];?></div>
												</div>
											</div>
										</div>
										<div id="tagscontent<?php echo $row['wt_id'];?>"></div>
										<div class="row">
											<div class="col-md-12">
												<a class="btn btn-primary usebtn" href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>?id=<?php echo $row['w_id']?>" role="button">Use Guide</a>
												<span class="pull-right categorylabel"><?php echo $row['c_name'];?></span>
											</div>
										</div>					
									</div>
								</div>						
							<?php } ?>
						
						<?php }else{ ?>
							<div class="col-md-12">
								<div class="guidebox" style="min-height: 370px;">
									<h3>No Results Found...</h3>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>	
				
		</div>
		
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		var _dom_url = '<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>';
		$(function(){
			$('input[name="category"]').on('click',function(){
				var categories = [];
				var cat = $(this).val();
				if(cat!='all'){
					$("#allcat").prop('checked', false);
				}else{
					$('input[name="category"]').prop('checked', false);
					$("#allcat").prop('checked', true);
				}
				$('input[name="category"]:checked').each(function() {
					categories.push($(this).val());
				});
				
				$('.guidecontentloader').show();
				$.post(_dom_url+'index.php?r=guide/getbycategories',{ids:categories},function(res){
					$('#guidecontent').html(res.guidecontent);
					$('.guidecontentloader').hide();
				});
				
			});	
			
			$('#searchkeybtn').on('click',function(){
				loadguidebytag();				
			});
			$('#searchkeyword').keypress(function(e){
				 var press = e.which;
				if(press == 13)
					loadguidebytag();				
			});
			
			<?php if(isset($_GET['tag'])){ ?>
				$('#searchkeybtn').trigger('click');
			<?php } ?>
		});
		$( document ).on( "click", ".label.tags", function() {
			var key = $(this).text();
			$('#searchkeyword').val(key);	
			$('#searchkeybtn').trigger('click');				
		});	
		
		function loadguidebytag(){
			var key = $('#searchkeyword').val();
			if(key==''){
				$('#searchkeyword').focus();
			}else{
				$('.guidecontentloader').show();
				$.post(_dom_url+'index.php?r=guide/getguidesbytag',{key:key},function(res){
					$('#guidecontent').html(res.guidecontent);
					$('.guidecontentloader').hide();
				});
			}
		}
		function loadtags(wid){
			$.post(_dom_url+'index.php?r=guide/gettagsbyguide',{id:wid},function(res){
				$('#tagscontent'+wid).html(res.tagscontent);
			});
		}
		<?php if(count($templates) >0 ){ ?>
			<?php foreach ($templates as $row) { ?>
				loadtags(<?php echo $row['wt_id'];?>);
			<?php } ?>
		<?php } ?>
		
	</script>
	
  </body>
</html>