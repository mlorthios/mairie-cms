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
					<div class="col-lg-3 col-md-6">
						<div class="widget widget-stats bg-grey-darker">
							<div class="stats-icon">
								<i class="fa fa-desktop"></i>
							</div>
							<div class="stats-info">
								<h4>TOTAL DE VISITEURS</h4>
								<p>
									<?= $fpage->TotalVisitors(); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="widget widget-stats bg-orange">
							<div class="stats-icon">
								<i class="fa fa-comments"></i>
							</div>
							<div class="stats-info">
								<h4>TOTAL DE COMMENTAIRES</h4>
								<p>
									0
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="widget widget-stats bg-green">
							<div class="stats-icon">
								<i class="fa fa-thumbs-up"></i>
							</div>
							<div class="stats-info">
								<h4>TOTAL DE J'AIMES</h4>
								<p>
									0
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="widget widget-stats bg-red">
							<div class="stats-icon">
								<i class="fa fa-thumbs-down"></i>
							</div>
							<div class="stats-info">
								<h4>TOTAL DE JE N'AIME PAS</h4>
								<p>
									0
								</p>
							</div>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="widget-todolist widget-todolist-rounded m-b-30" data-id="widget">
                            <div class="widget-todolist-header">
                                <div class="widget-todolist-header-left">
                                    <h4 class="widget-todolist-header-title">Liste de tâches</h4>
                                </div>
                            </div>
                            <div class="widget-todolist-body">
                                
                                <div id="addnewtodolist"><?= $fpage->Todolist(); ?></div>
							
                                <div class="widget-todolist-item">
                                    <div class="widget-todolist-input">
                                        <i class="fa fa-plus text-muted"></i>
                                    </div>
                                    <div class="widget-todolist-content">
                                        <input id="addtodolist" name="todolist_content" type="text" class="form-control" placeholder="Écrivez votre tâche ici ...">
                                    </div>
                                </div>
                            </div>
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
            
            function CheckTodolist(id) {
               var csrf = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/todolist/check',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            })
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            })
                        }
                    }
                });
            }
            
            function DeleteTodolist(id) {
               var csrf = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    url: '/api/admin/todolist/delete',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == 'success') {
                            $('#todolist'+id).remove();
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            })
                        } else {
                            $.gritter.add({
                                title: "Notification",
                                text: json.response
                            })
                        }
                    }
                });
            }
            
            var input = document.getElementById("addtodolist");
            input.addEventListener("keyup", function(event) {
                event.preventDefault();
                if (event.keyCode === 13) {
                    $("[name='todolist_content']").prop('disabled', true);
                    var csrf = $('meta[name="csrf-token"]').attr('content');
                    if($('#notodolist')) {
                        $('#notodolist').remove();
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        url: '/api/admin/todolist/add',
                        type: 'POST',
                        data: { content: $('[name="todolist_content"]').val() },
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                $('#addnewtodolist').append(json.code);
                                $('[name="todolist_content"]').val('');
                                $("[name='todolist_content']").prop('disabled', false);
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response
                                })
                            } else {
                                $("[name='todolist_content']").prop('disabled', false);
                                $.gritter.add({
                                    title: "Notification",
                                    text: json.response,
                                })
                            }
                        }
                    });
                }
            });
		</script>
	</body>
</html>
