<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Manage Category</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
	.tagcontainer{
		margin-right: 15px;padding:20px
	}
		
	.tagcontainer .tag_link {
		text-decoration: none;
	}
	.tagcontainer .tag_link .tags {
		font-weight: normal;
		border-radius: 10px;
		background: #e8ecef;
		color: inherit;
		margin-bottom: 10px;
		margin-right: 10px;
		padding: 9px 15px 12px;
		display: inline-block;
	}
	.tagcontainer .tag_link .tags:hover {
		cursor: pointer;
		opacity:.8;
	}
	.tagdelete{
		color:red;
		margin:0 -3px 0 10px;
	}
	.tagdelete:hover{
		cursor: pointer;
		text-decoration: none;
	}
	</style>
  </head>
  <body>		
		<div class="container-fluid">
			<div class="row menuheader">
				<div class="col-md-6">
					<ul class="menutab">
						<li><a href="<?php echo Yii::app()->getBaseUrl(true); ?>">Automations</a></li>
						<li>&nbsp;</li>
						<li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/index.php?r=guide">Guides Library</a></li>
						<li>&nbsp;</li>
						<li class="active"><a href="<?php echo Yii::app()->getBaseUrl(true);?>/index.php?r=managecategory">Manage Category</a></li>
					</ul>
				</div>
				<div class="col-md-6 text-right">
					<!--icons here-->
				</div>
			</div>
			
			<div class="row">	
			
				<div class="col-md-6">
					<br>
					<h3 style="padding-left: 15px;"><b>Manage Category</b><button class="btn btn-default pull-right" id="addcategorybtn">+ Add Category</button></h3>
					<br>
					<div class="panel panel-default" style="margin-left: 15px;">
						
						<div id="categorywarning"></div>
						<table class="table">
							<thead>
								<tr>
									<th class="text-center">ID</th>
									<th>Category Name</th>
									<th>Description</th>
									<th>Options</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($categories) >0 ){ ?>
								<?php foreach ($categories as $row) { ?>
								<?php if(strlen($row['c_desc'])>100){
									$desc = substr($row['c_desc'],100);
								}else{
									$desc = $row['c_desc'];
								}
								 ?>
								<tr>
									<td class="text-center"><?php echo $row['c_id'];?></td>
									<td id="cat_name<?php echo $row['c_id'];?>"><?php echo $row['c_name']; ?></td>
									<td id="cat_desc<?php echo $row['c_id'];?>"><?php echo ($desc=='')?'--':$desc; ?></td>
									<td>
										<div class="btn-group">
											<a class="btn btn-primary" href="javascript:editcategory(<?php echo $row['c_id'];?>);" id="editcategorybtn<?php echo $row['c_id'];?>" title="Edit"><i class="fa fa-edit"></i></a>
											<a class="btn btn-danger" href="javascript:deletecategory(<?php echo $row['c_id'];?>);" id="deletecategorybtn<?php echo $row['c_id'];?>" title="Edit"><i class="fa fa-trash-o"></i></a>
										</div>
									</td>
								</tr>
								<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>	
				
				<div class="col-md-6">
					<br>
					<h3><b>Manage Tags</b></h3>
					<br>
					<div class="panel panel-default tagcontainer">
						<h4>
						<?php if(count($tags) >0 ){ ?>
						<?php foreach ($tags as $row) { ?>
							<a href="<?php echo Yii::app()->getBaseUrl(true);?>/index.php?r=guide&tag=<?php echo $row['tag']; ?>" target="_blank" class="tag_link">
								<span class="label label-default tags">
									<span class="tagvalue"><?php echo $row['tag']; ?></span>&nbsp;&nbsp;
									<span class="label label-info"><?php echo $row['cnt']; ?></span>
								</span>		
							</a>							
						<?php } ?>
						<?php } ?>
						</h4>						
					</div>
				</div>	
			
			</div>	
				
		</div>
		
	<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="editModalLabel">								
						Modify Category
					</h4>
				</div>
				<form onsubmit="return false" method="post" id="editcategoryform">
					<div class="modal-body">
												
						<div class="form-group">
							<div class="input-group input-group">
								<span class="input-group-addon" >Name : </span>
								<input type="text" class="form-control" id="editcategoryname" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group">
								<span class="input-group-addon" >Description : </span>
								<textarea class="form-control" id="editcategorydesc"></textarea>
							</div>
						</div>
						<div id="editcategorywarning"></div>						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="btn btn-primary" type="submit" id="editcategorybtn">Save</button>
						<input type="hidden" id="editcategoryid">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="addModalLabel">								
						Add Category
					</h4>
				</div>
				<form onsubmit="return false" method="post" id="addcategoryform">
					<div class="modal-body">
												
						<div class="form-group">
							<div class="input-group input-group">
								<span class="input-group-addon" >Name : </span>
								<input type="text" class="form-control" id="addcategoryname" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group">
								<span class="input-group-addon" >Description : </span>
								<textarea class="form-control" id="addcategorydesc"></textarea>
							</div>
						</div>
						<div id="addcategorywarning"></div>						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="btn btn-primary" type="submit" id="addcategorybtn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<input type="hidden" id="base_url" value="<?php echo Yii::app()->getBaseUrl(true);?>">
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script>
		var _dom_url = $('#base_url').val();
		$(function(){
			$('#addcategorybtn').on('click',function(){
				$('#addCategoryModal').modal('show');
			});	
				
			$('#addcategoryform').submit(function(){
				var name = $('#addcategoryname').val();
				var desc = $('#addcategorydesc').val();
				
				$('#addcategorywarning').html('');
				
				if(name==''){
					$('#addcategoryname').focus();
				}else{
					$('#addcategorybtn').addClass('disabled');
					$('#addcategorybtn').html('<i class="fa fa-spinner fa-spin"></i> Save');
					$.post(_dom_url+'/index.php?r=managecategory/addcategory',{name:name,desc:desc},function(res){
						if(res.return===true){
							window.location.href=window.location.href;						
						}else{
							$('#addcategorywarning').html('<div class="alert alert-warning" role="alert"><b>Warning:</b> Something went wrong. Please reload page and try again.</div>');
						}
						$('#addcategorybtn').removeClass('disabled');
						$('#addcategorybtn').html('Save');
					});
				}
			});
			
			$('#editcategoryform').submit(function(){
				var c_id = $('#editcategoryid').val();
				var name = $('#editcategoryname').val();
				var desc = $('#editcategorydesc').val();
				
				$('#editcategorywarning').html('');
				
				if(name==''){
					$('#editcategoryname').focus();
				}else{
					$('#editcategorybtn').addClass('disabled');
					$('#editcategorybtn').html('<i class="fa fa-spinner fa-spin"></i> Save');
					$.post(_dom_url+'/index.php?r=managecategory/editcategory',{c_id:c_id,name:name,desc:desc},function(res){
						if(res.return===true){
							window.location.href=window.location.href;						
						}else{
							$('#editcategorywarning').html('<div class="alert alert-warning" role="alert"><b>Warning:</b> Something went wrong. Please reload page and try again.</div>');
						}
						$('#editcategorybtn').removeClass('disabled');
						$('#editcategorybtn').html('Save');
					});
				}
			});

		});
		function editcategory(id){
			$('#editcategorybtn'+id).html('<i class="fa fa-spinner fa-spin"></i>');
			var name = $('#cat_name'+id).text();
			var desc = $('#cat_desc'+id).text();
			if(desc=='--') desc = '';
			$('#editcategoryid').val(id);
			$('#editcategoryname').val(name);
			$('#editcategorydesc').val(desc);
			$('#editCategoryModal').modal('show');	
			$('#editcategorybtn'+id).html('<i class="fa fa-edit"></i>');
		}
		
		function deletecategory(id){			
			$('#deletecategorybtn'+id).html('<i class="fa fa-spinner fa-spin"></i>');			
			$.post(_dom_url+'/index.php?r=managecategory/countundercategory',{id:id},function(res){
				var count = res.count;
				if(count>0){
					$('#categorywarning').html('<div class="alert alert-warning" role="alert">This category has an existing template attached. Remove all attached templates to delete category.</div>');
					$('#deletecategorybtn'+id).html('<i class="fa fa-trash-o"></i>');
					setTimeout(function(){ resetwarning() }, 6000);
				}else{
					var r = confirm('Are you sure you want to delete category?');
					if(r){
						$.post(_dom_url+'/index.php?r=managecategory/deletecategory',{c_id:id},function(){
							window.location.href=window.location.href;	
						});
					}else{
						$('#deletecategorybtn'+id).html('<i class="fa fa-trash-o"></i>');
					}
				}
				
			});	
		}
		
		function resetwarning(){
			$('#categorywarning').html('');
		}
	</script>
	
  </body>
</html>