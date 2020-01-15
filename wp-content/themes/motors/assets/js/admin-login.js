(function($) {
	$(document).ready(function() {
		const carImageBeforeSubmit = '<div class="car-image"></div>';
		$('#user_login').attr('placeholder', 'Username or Email Address');
		$('#user_pass').attr('placeholder', 'Password');
		$('.forgetmenot').wrap('<div class="middle-wrapper"></div>');
		$('#nav').appendTo('.middle-wrapper');
		let rememberMe = $('.forgetmenot label').text().replace('Remember Me', 'Remember me');
		$('.forgetmenot label').text(rememberMe);
		let forgetPassword = $('#nav a').text().replace('Lost your password?', 'Forget password');
		$('#nav a').text(forgetPassword);
		$(carImageBeforeSubmit).insertBefore('.submit');
		let login = $('#wp-submit').attr('value').replace('Log In', 'Login');
		$('#wp-submit').attr('value', login);
		$('#backtoblog, .privacy-policy').wrap('<div class="bottom-wrapper"></div>');
		$('.privacy-policy-page-link').insertAfter('#backtoblog');
		let backToHome = $('#backtoblog a').text().replace('← Back to MotorsDoha', 'Back to MotorsDoha');
		$('#backtoblog a').text(backToHome);
	});
})(jQuery);