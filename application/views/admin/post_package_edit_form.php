<div>
	<ul class="breadcrumb">
		<li>
			<a href="#">Home</a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#">Posts</a> <span class="divider">/</span>
		</li>
		<li><a href="">Edit</a></li>
	</ul>
</div>
<script type="text/javascript">
	$('a#resetImages').live('click', function() {
		console.log('Begin Reset!');
		$('.imagess li').slideUp('fast', function() {
    		$(this).remove();
    		$('input#files').val('');
  		});
	});
	$().ready(function () {
			$('.slug').slugify('#title');
		
			var pigLatin = function(str) {
				return str.replace(/(\w*)([aeiou]\w*)/g, "$2$1ay");
			}
		
			$('#pig_latin').slugify('#title', {
					slugFunc: function(str, originalFunc) { return pigLatin(originalFunc(str)); } 
				}
			);
		
		}); 
</script>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-edit"></i> Form Elements</h2>
			<div class="box-icon">
				<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form class="form-horizontal" action="/admin/post/update" method="POST" enctype="multipart/form-data">
			  <fieldset>
				<div class="control-group">
				  <label class="control-label" for="typeahead">Title </label>
				  <input type="hidden" name="id" value="<?=$data->id;?>"/>
				  <div class="controls">
					<input type="text" id="title" name="title" value="<?=$data->title;?>">
				  </div>
				  <div class="control">
				  	<input type="hidden" class="slug" name="slug" value="<?=$data->slug;?>"/>
				  </div>
				</div>
				
				<div class="control-group">
					<label for="" class="control-label">Category</label>
					<div class="controls">
						<select name="category" id="category">
							<?php foreach ($category as $row) : ?>
								<?php if ($row->id == $this->input->get('category')) : ?>
									<option value="<?=$row->id;?>" selected><?=$row->category;?></option>
								<?php else : ?>
									<option value="<?=$row->id;?>"><?=$row->category;?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fileInput">Cover Image</label>
					<?php if ($data->cover_image) : ?>
					<div class="controls">
						<img src="/assets/uploads/images/cover/<?=$data->cover_image;?>" alt="" width="300px"/>
					</div>
					<?php endif;?>
				  	<div class="controls">
						<div class="uploader" id="uniform-fileInput"><input class="input-file uniform_on" id="fileInput" type="file" size="19" style="opacity: 0;" name="cover"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
				 	</div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="textarea2">Meta Desc</label>
				  <div class="controls">
					<textarea class="cleditor" id="textarea2" rows="3" name="metadesc"><?=$data->meta_desc;?></textarea>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="textarea2">Detailed Description</label>
				  <div class="controls">
					<textarea class="cleditor" id="textarea2" rows="3" name="desc"><?=$data->content;?></textarea>
				  </div>
				</div>
				<div class="control-group">
					<label for="fileInput" class="control-label">Images</label>
					<div class="controls">
						<div class="imagess">
							<?php 
							if ($data->images) {
								$imgs = explode(', ', $data->images);
								
								foreach ($imgs as $row):
								
									echo "<li style='float: left; list-style:none; margin: 4px 4px 4px 0;' class='thumbnail'>";
									echo "<a style='background: url(ewe.jpg);' href='/assets/uploads/images/$row' class='cboxElement'>";
									echo "<img src='/assets/uploads/images/$row' width='100px' height='100px'>";
									echo "</a>";
									echo "</li>";
								
								endforeach;
							}
							?>
						</div>
						<input type="hidden" name="files" value="<?=$data->images;?>" id="files"/>
						<div class="clearfix"></div>
						<a href="#" class="btn btn-primary btn-small gallery-open">Select Image(s)</a>
						<a href="#" class="btn btn-danger btn-small" id="resetImages">Reset Images</a>
						<!-- <input data-no-uniform="true" type="file" name="file_upload" id="file_upload" /> -->
					</div>
				</div>
				<?php if ($_GET['category'] == 1): ?>
				<div class="control-group">
					<label for="fileInput" class="control-label">Facilities</label>
					<div class="controls">
						<label class="checkbox inline">
						  	<input type="checkbox" name="facil[]" value="1" checked> Private Pool
						</label>
						<label class="checkbox inline">
						  	<input type="checkbox" name="facil[]" value="2" checked> Spring Airbed
						</label>
						<label class="checkbox inline">
						  	<input type="checkbox" name="facil[]" value="3" checked> Safe Deposit Box
						</label>
						<label class="checkbox inline">
						  	<input type="checkbox" name="facil[]" value="4" checked> LED TV
						</label>
						<label class="checkbox inline">
						  	<input type="checkbox" name="facil[]" value="5" checked> Tea & Coffee Maker
						</label>
					</div>
				</div>
				<?php endif;?>
				<div class="form-actions">
				  <button type="submit" name="submit" class="btn btn-primary" value="doSave">Save</button>
				  <button type="reset" class="btn">Cancel</button>
				</div>
			  </fieldset>
			</form>   

		</div>
	</div><!--/span-->
	
	<div class="modal hide fade" id="gallery" style="width: 800px; margin-left: -380px;">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3>Select Images :</h3>
	  </div>
	  <div class="modal-body" style="max-height: 400px;">
	  	<script type="text/javascript">
	  		console.log($('.imagess li').length);
	  		$('#imagez li').live('click', function () {
		      console.log($('.imagess li').length);
		      if ($('.imagess li').length > 1) {
		      	alert('Sorry only 1 image per Post');
		      }
		      else {
			      $('.selected').append("<span style='margin: 4px 4px 4px 0;' class='label'>"+$('img', this).attr('rel')+"</span>");
			      $('.imagess').append("<li style='margin: 2px;float: left;list-style:none;'><img src='"+$('img', this).attr('src')+"' width='100px' height='100px'></li>");
			      if ($('.imagess li').length > 1) {
			      	$('#files').val($('#files').val()+", "+$('img', this).attr('rel'));
			      }
			      else {
			      	$('#files').val($('img', this).attr('rel'));
			      }
			  }
		    });
	  	</script>
	  	<div class="selected" style="margin-bottom: 10px;"></div>
	    <div id="imagez">
	    <?php
	    foreach (new DirectoryIterator("./assets/uploads/images/") as $fn) {
	    	$tpl = "/assets/uploads/images/";
	    	$tmb = "/assets/uploads/images/thumbs/thumb_";
	    	if ($fn->getExtension() == 'jpg' || $fn->getExtension() == 'png' || $fn->getExtension() == 'gif') {
	    		echo "<li class='img-gal' style='float: left; padding: 0 6px 6px 0; list-style:none;'>";
				echo "<img rel='".$fn->getFilename()."' src='".$tmb.$fn->getFilename()."' width='100px' height='100px' class='thumb-img'>";
				echo "</li>";
			}
		}
	    
	    ?>
	    </div>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn btn-success" data-dismiss="modal" aria-hidden="true">Finish</a>
	  </div>
	</div>
	
</div><!--/row-->