	<?php $this->load->view('static/nav'); ?>
	<div class="bg-head" style="background: url('/assets/img/gallery-cover.jpg');"></div>
	<div class="bahe">
      <div class="title-container">
        <div class="yellow-s"></div>
        <div class="container">
          <div class="yellow">
            <h2>Photo Gallery</h2>
            <p><i>Queen Villas & Spa</i></p>
          </div>
        </div>
      </div>
    </div>
	<style>
		.stage {
			width: 770px;
			height: 460px;
			background: gray;
			float: left;
		}

		.gallery {
			width: 100%;
		}

		.gallery-holder {
			display: block;
			height: auto;
		}

		.gallery ul {
			text-align: center;
		}

		.gallery ul li {
			list-style: none;
			display: inline-block;
		}

		.gallery li a {
			padding: 4px 20px;
		}

		.gallery-list ul {
			padding: 0;
			margin: 0;
		}

		.gallery-list ul li {
			list-style: none;
			display: inline-block;
		}

		.gallery-list li {
			overflow: hidden;
			margin: 3px 2px;
		}

		.thumbs {
			height: auto;
			moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.3);
			-webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.3);
			box-shadow: 0px 1px 3px rgba(0,0,0,0.3);
		}

		.thumbs a {
			display: block;
			background: url('/assets/img/lens.png') no-repeat 50%;
		}

		.after {
		}

		#gal-filter ul {
			text-align: center;
		}

		#gal-filter li{
			list-style: none;
			display: inline-block;
			font-size: 12px;
		}
	</style>
	<script type="text/javascript">

		$(document).ready(function() {
			$("a[rel=imgGallery]").fancybox({
				openEffect		: 'fade',
				closeEffect		: 'fade',
				titlePosition	: 'over',
				titleFormat 	: function(title, currentArray, currentIndex, currentOpts) {
		    		return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
				}
			});

			$('.thumbs a img').css("opacity", "1");

				$('.thumbs a img').mouseover(function() {
					$(this).stop().animate({"opacity": "0.3"}, "slow");
				}).mouseout(function(){
					$(this).stop().animate({"opacity": "1"}, "fast");
			});

			// get the action filter option item on page load
		  	var $filterType = $('#gal-filter li a').attr('data-type');
		  
		  	// get and assign the ourHolder element to the
		  	// $holder varible for use later
		  	var $holder = $('ul.gallery-holder');

		  	// clone all items within the pre-assigned $holder element
		  	var $data = $holder.clone();

		  	// attempt to call Quicksand when a filter option
		  	// item is clicked
		  	$('#gal-filter li a').click(function(e) {
		    	// reset the active class on all the buttons
		    
		    	// assign the class of the clicked filter option
		    	// element to our $filterType variable
		    	var $filterType = $(this).attr('data-type');
		    
		    	if ($filterType == 'all') {
		      		// assign all li items to the $filteredData var when
		      		// the 'All' filter option is clicked
		      		var $filteredData = $data.find('li');
		    	} 
		    	else {
		      		// find all li elements that have our required $filterType
		      		// values for the data-type element
		      		var $filteredData = $data.find('li[data-type=' + $filterType + ']');
		    	}
		    
		    	// call quicksand and assign transition parameters
		    	$holder.quicksand($filteredData, {
		      		duration: 800,
		      		//easing: 'easeInOutQuad'
		    	}, function () {
		    		$('.thumbs a img').css("opacity", "1");

				$('.thumbs a img').mouseover(function() {
					$(this).stop().animate({"opacity": "0.3"}, "slow");
				}).mouseout(function(){
					$(this).stop().animate({"opacity": "1"}, "fast");
			});
		    	});
		    	e.preventDefault();
		    	return false;
		  	});
		});
		
	</script>
	<div class="content container">
		<style type="text/css">
		.width240 {
			height: 120px;
			overflow: hidden;
		}
		</style>
		<ul id="gal-filter">
			<li><a href="#" class="btn" data-type="all">All</a></li>
			<li><a href="#" class="btn" data-type="qv">Queen Villas & Spa</a></li>
		    <li><a href="#" class="btn" data-type="ag">Around Gili</a></li>
		    <li><a href="#" class="btn" data-type="al">Around Lombok</a></li>
		</ul>
		<div class="gallery-list">
			<ul class="gallery-holder">
				<?php $i = 1; ?>
				<?php foreach ($content as $row) : ?>
				<?php 
					if ($row->location_id == '1') $dt = 'qv';
					elseif ($row->location_id == '2') $dt = 'ag';
					elseif ($row->location_id == '3') $dt = 'al';
					else $dt = NULL;
				?>
				<li class="thumbs" data-id="id-<?=$i;?>" data-type="<?=$dt;?>">
					<a rel="imgGallery" href="/assets/uploads/images/galleries/<?=$row->src;?>" title="<?=$row->title;?>">
						<img src="/assets/uploads/images/galleries/<?=$row->src;?>" class="width240">
					</a>
				</li>
				<?php $i++; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
