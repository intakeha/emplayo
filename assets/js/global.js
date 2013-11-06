// Prevent delete button to send user to previous browser page
$(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD')) 
             || d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});

// Using jQuery for front-end functionalities
$(document).ready(function(){
	
	// Determine current page
	var currentPage = $('div#container div').eq(0).attr('id');
		

	// Default cursor location
	if(currentPage == 'login' || currentPage == 'signup' || currentPage == 'reset' || currentPage == 'forgot' || currentPage == 'brb'){
		$('input#email').focus();
		$('#header_login').hide(); // hide login link
		$('#header_icon, #header_email').hide(); // show profile navigation
	};
	
	if(currentPage == 'criteria'){
		$('#header_icon, #header_email').hide(); // show profile navigation
		window.onbeforeunload = function() { return "Your data will be lost if you leave now."; }; // enable onbeforeunload
	};
	
	// Customize header elements based on current page
	if(currentPage == 'profile' || currentPage == 'admin'){

		//mouseover on company tiles
		$('div#profile li').mouseenter(function() {
			$(this).find('img.photo').hide();
			$(this).find('div.fit').animate({marginLeft: "-=15px", opacity: .9}, 50);
			$(this).find('img.logo').show();
		}).mouseleave(function(){
			$(this).find('img.photo').show();
			$(this).find('div.fit').animate({marginLeft: "+=15px", opacity: 0}, 0);
			$(this).find('img.logo').hide();
		});
		
		if($('div#admin').find('.company_search')){
			$('.company_search').typeahead({
				name: 'company_search',
				limit: 5,
                                //BLC: Changed this to work for admin company table
				//remote: '/inquire/company_search/%QUERY',
                                remote: '/admin/company/company_search/%QUERY',
				template: '<p><strong>{{value}}</strong></p>',
				engine: Hogan
			}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
				$("#listing_search input[name='search_id']").val(datum.id);
				$('div#admin #company_search').submit();
			});
		};
	};
	
	if(currentPage == 'company'){
		$('#header_login').hide(); // hide login link
		$('#header_icon, #header_email').show(); // show profile navigation

		var $container = $('#tiles');
		// initialize isotope
		$container.isotope({
			masonry: {
				columnWidth: 200,
			}
		});

		// filter items when filter link is clicked
		$('#filters a').click(function(){
			var selector = $(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});
		
		 $container.on('click', '.smallHighlight', function(){
			$('#profile img.smallTile.bigTile').removeClass('bigTile');
			$(this).toggleClass('bigTile');
			$(this).find('div').toggleClass('bigContent');
			$(this).find('img').toggle();
			if ($(this).find('img').eq(1).hasClass('smallPic')){
				$(this).find('img').eq(1).switchClass('smallPic','bigPic',100);
			}else{
				$(this).find('img').eq(1).switchClass('bigPic','smallPic',100);
			};
			$container.isotope('reLayout');
		}); 
		
	};

	//Close Modal and Fade Layer
	$(document).on("click", "#fade, a.close, #transparent_fade", function() {
		$('#fade , .modal_popup, #modal_settings, #transparent_fade').fadeOut(function() {
			$('#fade, a.close, #transparent_fade').remove();
		});
		return false;
	});

});


// Modal popup function
function modal(modalID, modalWidth, topMargin){

	//Fade in the Popup and add close button
	$(modalID).fadeIn().css({ 'width': modalWidth }).prepend('<a href="#" class="close"><img src="../assets/images/modals/close_modal.png" class="btn_close" title="Close Window" alt="Close" /></a>');

	//Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
	//var popMargTop = ($(modalID).height() + 80) / 2;
	var popMargLeft = ($(modalID).width() + 80) / 2;

	//Apply Margin to Popup
	$(modalID).css({
		//'margin-top' : -popMargTop,
		'margin-top' : topMargin+'px',
		'margin-left' : -popMargLeft
	});

	//Fade in Background
	$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

	return false;

};

// Modal popup function for locked messaging
function lockedModal(modalID, modalWidth, topMargin){
	//Fade in the Popup
	$(modalID).fadeIn();
	
	//Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
	//var popMargTop = ($(modalID).height() + 80) / 2;
	var popMargLeft = ($(modalID).width() + 80) / 2;

	//Apply Margin to Popup
	$(modalID).css({
		//'margin-top' : -popMargTop,
		'margin-top' : topMargin+'px',
		'margin-left' : -popMargLeft
	});

	//Fade in Background
	$('body').append('<div id="locked_fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#locked_fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

	return false;
	
}

// User settings menu modal popup function
function settings(modalID){

	//Fade in the Popup
	$(modalID).fadeIn();

	//Fade in Background
	$('body').append('<div id="transparent_fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#transparent_fade').css({'filter' : 'alpha(opacity=0)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

	return false;

};
