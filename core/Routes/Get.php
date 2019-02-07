<?php

use App\Modules\Functions;
use App\Authentication\Session;
use Core\Database\Database;
use App\Modules\Users;
use App\Controller\Protections;
use App\Pages\admin\Home\AdminHome;
use App\Pages\admin\Pages\AdminPages;
use App\Pages\admin\Pages\AdminPagesEdit;
use App\Pages\admin\Banners\BannersCheck;
use App\Pages\admin\Newsletter\Newsletter;

// Home
$router->get('/', function () {
	
	$db = Database::PDO();
    
    $function = new Functions();
    
    $newsletter = new Newsletter();
    
    $csrf_token = Session::Get('csrf_token');
	
	$page = 'home';
    
    $pageid = '0';
	
	require 'app/Views/web/home.view.php';
	
});

$contact = Database::PDO()->query('SELECT * FROM contact');
$fcontact = $contact->fetch();

if($fcontact['active'] == '1') {
    $router->get('/contact', function() {
        $db = Database::PDO();

        $function = new Functions();

        $newsletter = new Newsletter();

        $csrf_token = Session::Get('csrf_token');

        $page = 'home';

        $pageid = '-7';

        require 'app/Views/web/contact.view.php';
    });
}

// Pages

$router->get('/pages/([a-z0-9_-]+)', function ($id) {

	$db = Database::PDO();
    
    $CheckPage = $db->prepare('SELECT * FROM pages WHERE url = ?');
    $CheckPage->execute(array($id));
    $rowCount = $CheckPage->rowCount();
    if($rowCount > 0) {
        $data = $CheckPage->fetch();
        
        $function = new Functions();
        
        $newsletter = new Newsletter();
        
        $csrf_token = Session::Get('csrf_token');
	
        $page = 'home';
    
        $pageid = $id;
	
	   require 'app/Views/web/pages.view.php';
    } else {
        header('Location: /');
        return false;
    }
	
});

// Events ID

$router->get('/events/([a-z0-9_-]+)', function ($id) {
	
	$db = Database::PDO();
    
    $CheckEvents = $db->prepare('SELECT * FROM events WHERE url = ?');
    $CheckEvents->execute(array($id));
    $rowCount = $CheckEvents->rowCount();
    if($rowCount > 0) {
        $data = $CheckEvents->fetch();
        
        $function = new Functions();
        
        $newsletter = new Newsletter();
        
        $csrf_token = Session::Get('csrf_token');
	
        $page = 'home';
        
        $pageid = '-1';
    
        $eventid = $id;
	
	   require 'app/Views/web/events.view.php';
    } else {
        header('Location: /');
        return false;
    }
	
});

// Events All

$router->get('/events', function () {

    $db = Database::PDO();

    $function = new Functions();

    $newsletter = new Newsletter();

    $csrf_token = Session::Get('csrf_token');

    $page = 'none';

    $pageid = '-1';

    require 'app/Views/web/events_list.view.php';

});

// Admin Login

$router->get('/admin/login', function() {
    
    $db = Database::PDO(); 
    
    $csrf_token = Session::Get('csrf_token');
    
    if(Session::Logging()) {
        header('Location: /admin/');
        return false;
    } else {
        require 'app/Views/admin/login.view.php';
    }
    
});

$router->get('/admin/', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            $user = new Users;
            $fpage = new AdminHome;
            $page = 'home';
            $csrf_token = Session::Get('csrf_token');
            require 'app/Views/admin/home.view.php';
        } else {
            header('Location: /');
            return false;
        }
    }
});

$router->get('/admin/pages', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            $user = new Users;
            $fpage = new AdminPages;
            $page = 'pages';
            require 'app/Views/admin/pages.view.php';
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/pages/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            $user = new Users;
            $db = Database::PDO();
            $fpage = new AdminPagesEdit;
            if($fpage->CheckPagesExist($id) == 'success') {
                $page = 'pages';
                $csrf_token = Session::Get('csrf_token');
                require 'app/Views/admin/pages_edit.view.php';
            } else {
                header('Location: /admin/pages');
                return false;
            }
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/pages/navigator/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            $user = new Users;
            $page = 'pages';
            $db = Database::PDO();
            $csrf_token = Session::Get('csrf_token');
            require 'app/Views/admin/pages_navigator_add.view.php';
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/pages/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            $user = new Users;
            $page = 'pages';
            $db = Database::PDO();
            $csrf_token = Session::Get('csrf_token');
            require 'app/Views/admin/pages_add.view.php';
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/pages/navigator/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            $user = new Users;
            $page = 'pages';
            $db = Database::PDO();
            
            $Check = $db->prepare('SELECT * FROM navigator WHERE id = ?');
            $Check->execute(array($id));
            $row = $Check->rowCount();
            if($row > 0) {
                $f = $Check->fetch();
                $csrf_token = Session::Get('csrf_token');
                require 'app/Views/admin/pages_navigator_edit.view.php';
            } else {
                header('Location: /admin/pages');
                return false;
            }
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/events', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            $user = new Users;
            $page = 'events';
            $db = Database::PDO();
            $csrf_token = Session::Get('csrf_token');
            $function = new Functions();
            require 'app/Views/admin/events.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/events/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'events';
            $db = Database::PDO();
            $function = new Functions();
            require 'app/Views/admin/events_add.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/events/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'events';
            $db = Database::PDO();
            $function = new Functions();
            $Check = $db->prepare('SELECT * FROM events WHERE id = ?');
            $Check->execute(array($id));
            $row = $Check->rowCount();
            
            if($row > 0) {
                $f = $Check->fetch();
                require 'app/Views/admin/events_edit.view.php';
            } else {
                header('Location: /admin/events');
                return false;
            }
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/events/comments/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            $user = new Users;
            $page = 'events';
            $db = Database::PDO();
            $csrf_token = Session::Get('csrf_token');
            $function = new Functions();
            require 'app/Views/admin/events_comments.view.php';

        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/news/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'news';
            $db = Database::PDO();
            $function = new Functions();
            
            require 'app/Views/admin/news_add.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/news/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'news';
            $db = Database::PDO();
            $function = new Functions();
            $Check = $db->prepare('SELECT * FROM news WHERE id = ?');
            $Check->execute(array($id));
            $row = $Check->rowCount();
            
            if($row > 0) {
                $f = $Check->fetch();
                require 'app/Views/admin/news_edit.view.php';
            } else {
                header('Location: /admin/news');
                return false;
            }
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/news', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            $user = new Users;
            $page = 'news';
            $db = Database::PDO();
            $csrf_token = Session::Get('csrf_token');
            $function = new Functions();
            require 'app/Views/admin/news.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/messages', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'messages';
            $db = Database::PDO();
            $function = new Functions();
            
            require 'app/Views/admin/messages.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/messages/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'messages';
            $db = Database::PDO();
            $function = new Functions();
            $Check = $db->prepare('SELECT * FROM messages WHERE id = ?');
            $Check->execute(array($id));
            $row = $Check->rowCount();
            
            if($row > 0) {
                $f = $Check->fetch();
                require 'app/Views/admin/messages_edit.view.php';
            } else {
                header('Location: /admin/messages');
                return false;
            }
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/messages/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'news';
            $db = Database::PDO();
            $function = new Functions();
            
            require 'app/Views/admin/messages_add.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/banners', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'banners';
            $db = Database::PDO();
            $function = new Functions();
            $b = new BannersCheck();
            
            require 'app/Views/admin/banners.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/news/([a-z0-9_-]+)', function($id) {
    
    $db = Database::PDO();
    
    $CheckPage = $db->prepare('SELECT * FROM news WHERE url = ?');
    $CheckPage->execute(array($id));
    $rowCount = $CheckPage->rowCount();
    if($rowCount > 0) {
        $data = $CheckPage->fetch();
        
        $csrf_token = Session::Get('csrf_token');
        
        $function = new Functions();
        
        $newsletter = new Newsletter();
	
        $page = 'news';
    
        $pageid = '-2';
	
	   require 'app/Views/web/news.view.php';
    } else {
        header('Location: /');
        return false;
    }
    
});

$router->get('/admin/newsletter', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_newsletter') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'newsletter';
            $db = Database::PDO();
            $function = new Functions();
            $newsletter = new Newsletter();
            
            require 'app/Views/admin/newsletter.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/users', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_users') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'users';
            $db = Database::PDO();
            $function = new Functions();
            

            require 'app/Views/admin/users.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/users/edit/(\d+)', function($id) {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_users') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'users';
            $db = Database::PDO();
            $function = new Functions();
            
            $ft = $db->prepare('SELECT * FROM users WHERE id = ?');
            $ft->execute(array($id));
            
            $ro = $ft->rowCount();
            
            if($ro > 0) {
                $fetch = $ft->fetch();
                require 'app/Views/admin/users_edit.view.php';
            } else {
                header('Location: /admin/users');
                return false;
            }
            
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/settings', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'users';
            $db = Database::PDO();
            $function = new Functions();
            
            require 'app/Views/admin/settings.view.php';
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/permissions', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_permissions') == 'access') {
            $user = new Users;
            $csrf_token = Session::Get('csrf_token');
            $page = 'permissions';
            $db = Database::PDO();
            $function = new Functions();
            
            require 'app/Views/admin/permissions.view.php';
            
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});

$router->get('/admin/logout', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            
            Session::Delete('id');
            header('Location: /admin/login');
            return false;
            
        } else {
            header('Location: /admin/');
            return false;
        }
    }
});