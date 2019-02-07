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
        <link href="/public/admin/plugins/summernote/summernote.css" rel="stylesheet"/>
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
                <form id="posting" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Titre de l'événement</label>
                            <input class="form-control form-control-lg" name="title" placeholder="Titre de l'événement">
                        </div>
                        <div class="form-group">
                            <label>Brève description</label>
                            <input class="form-control form-control-lg" name="description" placeholder="Brève description">
                        </div>
                        <div class="form-group">
                            <label>Date de l'événement</label>
                            <input type="date" class="form-control form-control-lg" name="date_event">
                        </div>
                        <textarea id="summernote" name="content"></textarea>
                    </div>
                    <div class="col-md-2">
                        <img style="height: auto; width:100%; margin-bottom: 10px; display: none" id="blah" src="#"/>
                        <input type="file" name="image" class="btn btn-primary fileinput-button m-r-3" style="margin-bottom: 10px">
                        <button name="publish" class="btn btn-primary btn-block">Publier</button>
                        <a style="margin-bottom: 10px" href="/admin/events" class="btn btn-danger btn-block">Annuler</a>
                        <div style="display: none" id="progress" class="progress rounded-corner">
                            <div class="progress-bar" style="width: 0%;">Chargement</div>
                        </div>
                    </div>
                </div></form>
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
        <script src="/public/admin/plugins/summernote/summernote.min.js"></script>
        <script src="/public/admin/plugins/summernote/fr.js"></script>
		<script>
			$(document).ready(function(){
				App.init();
			});
            
            $("#summernote").summernote({
                placeholder:"Personnalisez votre page facilement !",
                lang: 'fr-FR',
                callbacks: {
                    onImageUpload: function(files) {
                        $('#progress').show();
                        sendFile(files[0]);
                    }
                }
            });

            function sendFile(file) {
                var csrf = $('meta[name="csrf-token"]').attr('content');
                data = new FormData();
                data.append("file", file);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: data,
                    dataType: 'json',
                    type: "POST",
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
                        return myXhr;
                    },
                    url: "/api/admin/pages/summernote/add/img",
                    success: function(json) {
                        if(json.status == 'success') {
                            console.info('Importation success')
                            var url = json.response;
                            $('#summernote').summernote('insertImage', json.response);
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + textStatus + " " + errorThrown
                        });
                    }
                });
            }
            
            $('[name="publish"]').click(function() {
                $('#progress').show();
                $('[name="publish"]').prop('disabled', true);
                $('[name="publish"]').html('Publication en cours');
                
                var title = $('[name="title"]').val(),
                    content = $('[name="content"]').val(),
                    csrf = $('meta[name="csrf-token"]').attr('content'),
                    image = $('[name="image"]').prop("files")[0],
                    desc = $('[name="description"]').val(),
                    date = $('[name="date_event"]').val();

                data = new FormData();
                data.append("title", title);
                data.append("content", content);
                data.append("description", desc);
                data.append("date_event", date);
                data.append("file", image);
                    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/events/add',
                    type: 'POST',
                    data: data,
                    xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
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
                            $("[name='publish']").prop('disabled', true);
                            $("[name='publish']").html('Publication effectué');
                            setTimeout(function() {
                                window.location.href = '/admin/events';
                            }, 2200);
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response,
                            });
                            $("[name='publish']").prop('disabled', false);
                            $("[name='publish']").html('Publier');
                        }
                    },
                    error: function (request, status, error) {
                        $.gritter.add({
                            title: "Notification",
                            text: "Une erreur est survenue : " + request.responseText
                        });
                    }
                });
            });
            
            function progressHandlingFunction(e){
                if(e.lengthComputable){
                    var percentComplete = (e.loaded / e.total) * 100
                    $('div.progress-bar').css({ "width": percentComplete + "%", });
                    if (e.loaded == e.total) {
                        $('div.progress-bar').css({ "width": percentComplete + "%" });
                        setTimeout(function() {
                            $('#progress').hide();
                            $('div.progress-bar').css({ "width": "0%" });
                        }, 2200);
                    }
                }
            }
            
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    }
            
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            $('[name="image"]').change(function(){
                $('#blah').show();
                readURL(this);
            });
		</script>
	</body>
</html>
