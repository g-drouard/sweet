	function init(){
		formModal = $('.cd-user-modal'),
		formLogin = formModal.find('#cd-login'),
		formSignup = formModal.find('#cd-signup'),
		formForgotPassword = formModal.find('#cd-reset-password'),
		formModalTab = $('.cd-switcher'),
		tabLogin = formModalTab.children('li').eq(0).children('a'),
		tabSignup = formModalTab.children('li').eq(1).children('a'),
		forgotPasswordLink = formLogin.find('.cd-form-bottom-message a'),
		backToLoginLink = formForgotPassword.find('.cd-form-bottom-message a');
	}
	
	function open_signin_form(){
		init();
		formModal.addClass('is-visible');
		formLogin.addClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.addClass('selected');
		tabSignup.removeClass('selected');
	}

	function open_signup_form(){
		init();
		formModal.addClass('is-visible');
		formLogin.removeClass('is-selected');
		formSignup.addClass('is-selected');
		formForgotPassword.removeClass('is-selected');
		tabLogin.removeClass('selected');
		tabSignup.addClass('selected');
	}

	function open_forgot_password_form(){
		init();
		formModal.addClass('is-visible');
		formLogin.removeClass('is-selected');
		formSignup.removeClass('is-selected');
		formForgotPassword.addClass('is-selected');
		tabLogin.addClass('selected');
		tabSignup.removeClass('selected');
	}
	
	function showError(id) {
		switch(id) {
			case 1:
				open_signup_form();
				var signupEmail = $("#signup-email");
				signupEmail.addClass('has-error');
				var signupEmailError = $("#signup-email-error");
				signupEmailError.addClass('is-visible');
				signupEmailError.text("Adresse mail invalide");
				break;
			case 2:
				open_signup_form();
				var signupUsername = $("#signup-username");
				signupUsername.addClass('has-error');
				var signupUsernameError = $("#signup-username-error");
				signupUsernameError.addClass('is-visible');
				signupUsernameError.text("Nom d'utilisateur invalide");
				break;
			case 3:
				open_signup_form();
				var signupPassword = $("#signup-password");
				signupPassword.addClass('has-error');
				var signupPasswordError = $("#signup-password-error");
				signupPasswordError.addClass('is-visible');
				signupPasswordError.text("Mots de passe différents");
				var signupConfirmPassword = $("#signup-confirm-password");
				signupConfirmPassword.addClass('has-error');
				var signupConfirmPasswordError = $("#signup-confirm-password-error");
				signupConfirmPasswordError.addClass('is-visible');
				signupConfirmPasswordError.text("Mots de passe différents");
				break;
			case 4:
				open_signup_form();
				var signupUsername = $("#signup-username");
				signupUsername.addClass('has-error');
				var signupUsernameError = $("#signup-username-error");
				signupUsernameError.addClass('is-visible');
				signupUsernameError.text("Nom d'utilisateur déjà utilisé");
				break;
			case 5:
				open_signup_form();
				var signupEmail = $("#signup-email");
				signupEmail.addClass('has-error');
				var signupEmailError = $("#signup-email-error");
				signupEmailError.addClass('is-visible');
				signupEmailError.text("Adresse mail déjà utilisée");
				break;
			case 6:
				open_signup_form();
				var acceptTermsError = $("#accept-terms-error");
				acceptTermsError.addClass('is-visible');
				acceptTermsError.text("Conditions d'utilisations non acceptées");
				break;
			case 7:
				open_signin_form();
				var signinUsernameEmail = $("#signin-username-email");
				signinUsernameEmail.addClass('has-error');
				var signinUsernameEmailError = $("#signin-username-email-error");
				signinUsernameEmailError.addClass('is-visible');
				signinUsernameEmailError.text("Identifiants et/ou mot de passe incorrect(s)");
				var signinPassword = $("#signin-password");
				signinPassword.addClass('has-error');
				var signinPasswordError = $("#signin-password-error");
				signinPasswordError.addClass('is-visible');
				signinPasswordError.text("Identifiants et/ou mot de passe incorrect(s)");
				break;
			case 8:
				open_forgot_password_form();
				var resetEmail = $("#reset-email");
				resetEmail.addClass('has-error');
				var resetEmailError = $("#reset-email-error");
				resetEmailError.addClass('is-visible');
				resetEmailError.text("Adresse non utilisée");
				break;
			case 9:
				var resetPassword = $("#reset-password");
				resetPassword.addClass('has-error');
				var resetPasswordError = $("#reset-password-error");
				resetPasswordError.addClass('is-visible');
				resetPasswordError.text("Mots de passe différents");
				var resetConfirmPassword = $("#reset-confirm-password");
				resetConfirmPassword.addClass('has-error');
				var resetConfirmPasswordError = $("#reset-confirm-password-error");
				resetConfirmPasswordError.addClass('is-visible');
				resetConfirmPasswordError.text("Mots de passe différents");
				break;
		}
	}
	
	// Toast

	function showSuccessToastRegister() {
        $().toastmessage('showToast', {
			text     : 'Inscription validée',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'success'
		});
		open_login_form();
    }
	function showSuccessToastLogin() {
        $().toastmessage('showToast', {
			text     : 'Connexion établie',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'success'
		});
    }
	function showSuccessToastLogout() {
        $().toastmessage('showToast', {
			text     : 'Déconnexion effectuée',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'success'
		});
    }
	function showSuccessToastMailSend(bool) {
		if(bool == 1)
		{
			$().toastmessage('showToast', {
			text     : 'Mail envoyé',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'success'
			});
		}
		else
		{
			open_forgot_password_form();
			$().toastmessage('showToast', {
			text     : 'Erreur lors de l\'envoi du mail',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'error'
			});
		}
    }
	function showSuccessToastPasswordChanged(bool) {
		if(bool)
		{
			open_signin_form();
			$().toastmessage('showToast', {
			text     : 'Mot de passe changé',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'success'
			});
		}
		else
		{
			open_forgot_password_form();
			$().toastmessage('showToast', {
			text     : 'Erreur lors du changement de mot de passe',
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'error'
			});
		}
	}
    function showErrorToast(texte) {
        $().toastmessage('showToast', {
			text     : texte,
			sticky   : false,
			stayTime	 : 5000,
            position : 'top-right',
            type     : 'error'
		});
    }