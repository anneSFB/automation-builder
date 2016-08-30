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
										<div id="tagscontent<?php echo $row['wt_id'];?>">
											<script>loadtags(<?php echo $row['wt_id'];?>);</script>
										</div>
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
					