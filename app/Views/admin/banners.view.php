<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Administration</title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
        <meta name="csrf-token" content="<?= $csrf_token ?>">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
		<link href="/public/admin/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/font-awesome/css/all.min.css" rel="stylesheet"/>
		<link href="/public/admin/plugins/animate/animate.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/style.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/style-responsive.min.css" rel="stylesheet"/>
		<link href="/public/admin/css/default/theme/default.css" rel="stylesheet" id="theme"/>
		<link href="/public/admin/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
			<div id="header" class="header navbar-default">
				<div class="navbar-header">
					<a href="/admin/" class="navbar-brand">
						<span class="navbar-logo"></span>
						<b>Administration</b>
					</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<ul class="navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="d-none d-md-inline">
								<?= $user->Firstname(); ?>
								<?= $user->Lastname(); ?>
							</span>
							<b class="caret"></b>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="/admin/settings" class="dropdown-item">Paramètres</a>
							<div class="dropdown-divider"></div>
							<a href="/admin/logout" class="dropdown-item">Déconnexion</a>
						</div>
					</li>
				</ul>
			</div>
			<?php include 'partials/nav.partial.php'; ?>
			<div class="sidebar-bg"></div>
			<div id="content" class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-primary">Pour éviter tout problème d'affichage, vous devez utiliser une largeur de 200px. Une bannière de 200x800 au préalable. Uniquement pour les bannières gauche et droite</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Bannière gauche</label>
                            <input type="file" name="file_left" class="btn btn-primary btn-block">
                        </div>
                        <button class="btn btn-info btn-block" type="submit" name="left">Modifier</button>
                        <?php if($b->Check('left') == 0) { ?>
                        <button class="btn btn-success btn-block" id="left" type="submit" onclick="Active('left')">Activer la bannière gauche</button>
                        <?php } elseif($b->Check('left') == 1) { ?>
                        <button class="btn btn-danger btn-block" id="left" type="submit" onclick="Disabled('left')">Désactiver la bannière gauche</button>
                        <?php } ?>
                        <div style="display: none; margin-top: 10px" id="progressleft" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Chargement</div>
                        </div>
                        <div style="margin-top: 10px; text-align: center">
                            <img id="ban_left" src="<?= $b->Banner('left'); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Bannière droite</label>
                            <input name="file_right" type="file" class="btn btn-primary btn-block">
                        </div> 
                        <button class="btn btn-info btn-block" type="submit" name="right">Modifier</button>
                        <?php if($b->Check('right') == 0) { ?>
                        <button class="btn btn-success btn-block" type="submit" id="right" onclick="Active('right')">Activer la bannière droite</button>
                        <?php } elseif($b->Check('right') == 1) { ?>
                        <button class="btn btn-danger btn-block" type="submit" id="right" onclick="Disabled('right')">Désactiver la bannière droite</button>
                        <?php } ?>
                        <div style="display: none; margin-top: 10px" id="progressright" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Chargement</div>
                        </div>
                        <div style="margin-top: 10px; text-align: center">
                            <img id="ban_right" src="<?= $b->Banner('left'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bannière haut (Hauteur de 115 pixels)</label>
                            <input name="file_top" type="file" class="btn btn-primary btn-block">
                        </div>
                        <button class="btn btn-info btn-block" type="submit" name="top">Modifier</button>
                        <div style="display: none; margin-top: 10px" id="progresstop" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Chargement</div>
                        </div>
                        <div style="margin-top: 10px; text-align: center">
                            <img style="width: 100%; height: auto" id="ban_top" src="/public/img/header/banner.png">
                        </div>
                    </div>
                </div>
			</div>
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		</div>
		<script src="/public/admin/plugins/jquery/jquery-3.3.1.min.js"></script>
		<script src="/public/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="/public/admin/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
		<!--[if lt IE 9]>
		<script src="/public/admin/crossbrowserjs/html5shiv.js"></script>
		<script src="/public/admin/crossbrowserjs/respond.min.js"></script>
		<script src="/public/admin/crossbrowserjs/excanvas.min.js"></script>
		<![endif]-->
		<script src="/public/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="/public/admin/plugins/js-cookie/js.cookie.js"></script>
		<script src="/public/admin/js/theme/default.min.js"></script>
        <script src="/public/admin/plugins/gritter/js/jquery.gritter.js"></script>
		<script src="/public/admin/js/apps.min.js"></script>
		<script>
			$(document).ready(function(){
				App.init();
			});
            
            function Convert(placement) {
                if(placement == 'right') {
                    return 'droite';
                } else if(placement == 'left') {
                    return 'gauche';
                }
            }
            
            function Active(placement) {
                
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                $('#'+placement).prop('disabled', true);
                $('#'+placement).html('Modification en cours');
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/banner/active',
                    type: 'POST',
                    data: {
                        placement: placement
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("#"+placement).prop('disabled', false);
                            $("#"+placement).html('Désactiver la bannière ' + Convert(placement));
                            $("#"+placement).attr("onclick","Disabled('"+placement+"')");
                            $("#"+placement).attr("class","btn btn-danger btn-block");
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("#"+placement).prop('disabled', false);
                            $("#"+placement).html('Activer la bannière ' + Convert(placement));
                        }
                    },
                    error: function (request, status, error) {
                        $("#"+placement).prop('disabled', false);
                        $("#"+placement).html('Activer la bannière ' + Convert(placement));
                        
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            }
            
            function Disabled(placement) {
                
                var csrf = $('meta[name="csrf-token"]').attr('content');
                
                $('#'+placement).prop('disabled', true);
                $('#'+placement).html('Modification en cours');
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/banner/disabled',
                    type: 'POST',
                    data: {
                        placement: placement
                    },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("#"+placement).prop('disabled', false);
                            $("#"+placement).html('Activer la bannière ' + Convert(placement));
                            $("#"+placement).attr("onclick","Active('"+placement+"')");
                            $("#"+placement).attr("class","btn btn-success btn-block");
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("#"+placement).prop('disabled', false);
                            $("#"+placement).html('Désactiver la bannière ' + Convert(placement));
                        }
                    },
                    error: function (request, status, error) {
                        $("#"+placement).prop('disabled', false);
                        $("#"+placement).html('Désactiver la bannière ' + Convert(placement));
                        
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            }
            
            $('[name="left"]').click(function() {
                $('[name="left"]').prop('disabled', true);
                $('[name="left"]').html('Modification en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content'),
                    image = $('[name="file_left"]').prop("files")[0];

                data = new FormData();
                data.append("file_left", image);
                data.append("placement", "left");
                
                if(image) {
                    $('#progressleft').show();
                }
                    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/banner/edit',
                    type: 'POST',
                    data: data,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunctionLeft, false);
                        return myXhr;
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("[name='left']").prop('disabled', false);
                            $("[name='left']").html('Modifier');
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("[name='left']").prop('disabled', false);
                            $("[name='left']").html('Modifier');
                        }
                    },
                    error: function (request, status, error) {
                        $("[name='left']").prop('disabled', false);
                        $("[name='left']").html('Modifier');
                        
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });
            
            function progressHandlingFunctionLeft(e){
                if(e.lengthComputable){
                    var percentComplete = (e.loaded / e.total) * 100
                    $('div.progress-bar').css({ "width": percentComplete + "%", });
                    if (e.loaded == e.total) {
                        $('div.progress-bar').css({ "width": percentComplete + "%" });
                        setTimeout(function() {
                            $('#progressleft').hide();
                            $('div.progress-bar').css({ "width": "0%" });
                        }, 2200);
                    }
                }
            }
            
            $('[name="right"]').click(function() {
                $('[name="right"]').prop('disabled', true);
                $('[name="right"]').html('Modification en cours');
                
                var csrf = $('meta[name="csrf-token"]').attr('content'),
                    image = $('[name="file_right"]').prop("files")[0];

                data = new FormData();
                data.append("file_right", image);
                data.append("placement", "right");
                
                if(image) {
                    $('#progressright').show();
                }
                    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/banner/edit',
                    type: 'POST',
                    data: data,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunctionRight, false);
                        return myXhr;
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("[name='right']").prop('disabled', false);
                            $("[name='right']").html('Modifier');
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("[name='right']").prop('disabled', false);
                            $("[name='right']").html('Modifier');
                        }
                    },
                    error: function (request, status, error) {
                        $("[name='right']").prop('disabled', false);
                        $("[name='right']").html('Modifier');
                        
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });
            
            function progressHandlingFunctionRight(e){
                if(e.lengthComputable){
                    var percentComplete = (e.loaded / e.total) * 100
                    $('div.progress-bar').css({ "width": percentComplete + "%", });
                    if (e.loaded == e.total) {
                        $('div.progress-bar').css({ "width": percentComplete + "%" });
                        setTimeout(function() {
                            $('#progressright').hide();
                            $('div.progress-bar').css({ "width": "0%" });
                        }, 2200);
                    }
                }
            }
            
            function readURLLeft(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        $('#ban_left').attr('src', e.target.result);
                    }
            
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            function readURLRight(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        $('#ban_right').attr('src', e.target.result);
                    }
            
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            $('[name="file_right"]').change(function(){
                $('#ban_right').show();
                readURLRight(this);
            });
            
            function readURLLeft(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        $('#ban_left').attr('src', e.target.result);
                    }
            
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            $('[name="file_left"]').change(function(){
                $('#ban_left').show();
                readURLLeft(this);
            });

            $('[name="top"]').click(function() {
                $('[name="top"]').prop('disabled', true);
                $('[name="top"]').html('Modification en cours');

                var csrf = $('meta[name="csrf-token"]').attr('content'),
                    image = $('[name="file_top"]').prop("files")[0];

                data = new FormData();
                data.append("file_top", image);
                data.append("placement", "right");

                if(image) {
                    $('#progresstop').show();
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/banner/top',
                    type: 'POST',
                    data: data,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunctionTop, false);
                        return myXhr;
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                            $("[name='top']").prop('disabled', false);
                            $("[name='top']").html('Modifier');
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("[name='top']").prop('disabled', false);
                            $("[name='top']").html('Modifier');
                        }
                    },
                    error: function (request, status, error) {
                        $("[name='top']").prop('disabled', false);
                        $("[name='top']").html('Modifier');

                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });

            function readURLTop(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#ban_top').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('[name="file_top"]').change(function(){
                $('#ban_top').show();
                readURLTop(this);
            });

            function progressHandlingFunctionTop(e){
                if(e.lengthComputable){
                    var percentComplete = (e.loaded / e.total) * 100
                    $('div.progress-bar').css({ "width": percentComplete + "%", });
                    if (e.loaded == e.total) {
                        $('div.progress-bar').css({ "width": percentComplete + "%" });
                        setTimeout(function() {
                            $('#progresstop').hide();
                            $('div.progress-bar').css({ "width": "0%" });
                        }, 2200);
                    }
                }
            }
		</script>
	</body>
</html>
