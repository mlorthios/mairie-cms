<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Administration</title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta name="csrf-token" content="<?= $csrf_token ?>">
        <meta name="robots" content="noindex, nofollow">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link href="/public/admin/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
		<link href="/public/admin/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/public/admin/plugins/font-awesome/css/all.min.css" rel="stylesheet" />
		<link href="/public/admin/plugins/animate/animate.min.css" rel="stylesheet" />
		<link href="/public/admin/css/default/style.min.css" rel="stylesheet" />
		<link href="/public/admin/css/default/style-responsive.min.css" rel="stylesheet" />
		<link href="/public/admin/css/default/theme/default.css" rel="stylesheet" id="theme" />
	</head>
	<body class="pace-top">
		<div class="login-cover">
			<div class="login-cover-image" style="background-image: url(/public/admin/img/login-bg/Mairie.jpg)" data-id="login-cover-image"></div>
			<div class="login-cover-bg"></div>
		</div>
		<div id="page-container" class="fade">
			<div class="login login-v2" data-pageload-addclass="animated fadeIn">
				<div class="login-header">
					<div class="brand">
						<span class="logo"></span>
						<b>Administration</b>
						<small>
							Ville d'Audruicq
						</small>
					</div>
					<div class="icon">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<div class="login-content">
                    <div id="_message-alert"></div>
					<form id="__login" class="margin-bottom-0">
						<div class="form-group m-b-20">
							<input type="email" name="email" class="form-control form-control-lg" placeholder="E-mail" />
						</div>
						<div class="form-group m-b-20">
							<input type="password" class="form-control form-control-lg" placeholder="Mot de passe" name="password" />
						</div>
						<div class="login-buttons">
							<button type="submit" class="btn btn-success btn-block btn-lg">Se connecter</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="/public/admin/plugins/jquery/jquery-3.3.1.min.js"></script>
		<script src="/public/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="/public/admin/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
		<script src="/public/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="/public/admin/plugins/js-cookie/js.cookie.js"></script>
		<script src="/public/admin/js/theme/default.min.js"></script>
		<script src="/public/admin/js/apps.min.js"></script>
		<script src="/public/admin/js/demo/login-v2.demo.min.js"></script>
		<script>
            $(document).ready(function() {
				App.init();
				LoginV2.init();
			});
            
            $(document).ready(function() {
    $('body').on('submit', '#__login', function (e) {
        e.preventDefault();

        var $this = $(this);
        var csrf = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            url: '/api/admin/login',
            type: 'POST',
            data: $this.serialize(),
            dataType: 'json',
            success: function(json) {
                if(json.status == 'success') {
                    $('#_message-alert').html('<div class="alert alert-success">'+json.response+'</div>');
                    setTimeout(function() {
                        window.location.href = "/admin/";
                    }, 2200);
                } else {
                    $('#_message-alert').html('<div class="alert alert-danger">'+json.response+'</div>');
                }
            }
        });
    });
});
		</script>
	</body>
</html>