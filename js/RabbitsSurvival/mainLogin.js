jQuery(document).ready(function($){
	var formModal = $('.cd-user-modal'),
		formLogin = formModal.find('#cd-login'),
		formSignup = formModal.find('#cd-signup'),
		formForgotPassword = formModal.find('#cd-reset-password'),
		formModalTab = $('.cd-switcher'),
		tabLogin = formModalTab.children('li').eq(0).children('a'),
		tabSignup = formModalTab.children('li').eq(1).children('a'),
		forgotPasswordLink = formLogin.find('.cd-form-bottom-message a'),
		backToLoginLink = formForgotPassword.find('.cd-form-bottom-message a'),
		divPlay = $('.divPlay');

	//open sign-up form
	divPlay.on('click', '.cd-signup', signup_selected);
	//open login-form form
	divPlay.on('click', '.cd-signin', login_selected);

	//close modal
	formModal.on('click', function(event){
		if( $(event.target).is(formModal) || $(event.target).is('.cd-close-form') ) {
			formModal.removeClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		formModal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	formModalTab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( tabLogin ) ) ? login_selected() : signup_selected();
	});

	//hide or show password
	$('.hide-password').on('click', function(){
		var togglePass= $(this),
			passwordField = togglePass.prev('input');
		
		( 'password' == passwordField.attr('type') ) ? passwordField.attr('type', 'text') : passwordField.attr('type', 'password');
		( 'Cacher' == togglePass.text() ) ? togglePass.text('Montrer') : togglePass.text('Cacher');
		//focus and move cursor to the end of input field
		passwordField.putCursorAtEnd();
	});

	//show forgot-password form 
	forgotPasswordLink.on('click', function(event){
		event.preventDefault();
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	backToLoginLink.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	// Event for remove input errors messages
	
	$('.cd-input').on('click', function(){
		$(this).removeClass('has-error');
		$(this).nextAll('.cd-error-message').removeClass('is-visible');
	});
	
	// Event for remove checkbox errors messages 
	
	$('.cd-input-checkbox').on('click', function(){
		$(this).nextAll('.cd-error-message-checkbox').removeClass('is-visible');
	});
	
	function login_selected(){
		formModal.addClass('is-visible');
		formLogin.addClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.addClass('selected');
		tabSignup.removeClass('selected');
	}

	function signup_selected(){
		formModal.addClass('is-visible');
		formLogin.removeClass('is-selected');
		formSignup.addClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.removeClass('selected');
		tabSignup.addClass('selected');
	}

	function forgot_password_selected(){
		formLogin.removeClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.addClass('is-selected');
	}

	//IE9 placeholder fallback
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
		  	}
		}).blur(function() {
		 	var input = $(this);
		  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
		  	}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  	$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
			 		input.val('');
				}
		  	})
		});
	}

});


//credits http://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.focus();
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};