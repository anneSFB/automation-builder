<?php if(count($tags) >0 ){ ?>		
	<div class="row">
		<div class="col-md-12">
			<h4 style="font-size: 16px;">Best Use</h4>
			<h4>
			<?php foreach ($tags as $row) { ?>
				<span class="label label-default tags"><?php echo $row->tag; ?></span>
			<?php } ?>
			</h4>
			<br>
		</div>
	</div>
<?php } ?>