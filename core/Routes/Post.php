<?php

use App\Authentication\Session;
use App\Authentication\Authentication;
use App\Controller\Protections;
use App\Pages\admin\Home\Todolist\TodolistAdd;
use App\Pages\admin\Home\Todolist\TodolistCheck;
use App\Pages\admin\Home\Todolist\TodolistDelete;
use App\Pages\admin\Pages\Pages\PagesEdit;
use App\Pages\admin\Pages\Pages\PagesDelete;
use App\Pages\admin\Pages\Pages\PagesAdd;
use App\Pages\admin\Pages\Pages\PagesAdd2;
use App\Pages\admin\Pages\Pages\PagesNavigatorEdit;
use App\Pages\admin\Pages\Pages\PagesNavigatorDelete;
use App\Pages\admin\Pages\Summernote\SummernoteImg;
use App\Pages\admin\Events\EventAdd;
use App\Pages\admin\Events\EventDelete;
use App\Pages\admin\Events\EventEdit;
use App\Pages\admin\News\NewsAdd;
use App\Pages\admin\News\NewsDelete;
use App\Pages\admin\News\NewsEdit;
use App\Pages\admin\Messages\MessageAdd;
use App\Pages\admin\Messages\MessageEdit;
use App\Pages\admin\Messages\MessageDelete;
use App\Pages\admin\Banners\BannersEdit;
use App\Pages\admin\Banners\BannersCheck;
use App\Pages\admin\Banners\BannersTop;
use App\Pages\admin\Newsletter\Newsletter;
use App\Pages\admin\Users\Users;
use App\Pages\admin\Permissions\Permissions;
use App\Pages\admin\Settings\Settings;
use App\Pages\web\News\AddComment;
use App\Pages\web\Events\AddEvent;

// Login

$router->post('/api/admin/login', function() {

    if(!Session::Logging()) {
        new Authentication;
    } else {
        echo 'Erreur 403';
    }
    
});

// Add Todolist

$router->post('/api/admin/todolist/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            new TodolistAdd;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Check Todolist

$router->post('/api/admin/todolist/check', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            new TodolistCheck;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete Todolist

$router->post('/api/admin/todolist/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            new TodolistDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit Page

$router->post('/api/admin/pages/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete Page

$router->post('/api/admin/pages/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add Page

$router->post('/api/admin/pages/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesAdd;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add2 Page

$router->post('/api/admin/pages/add2', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesAdd2;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit navigator

$router->post('/api/admin/pages/navigator/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesNavigatorEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete navigator

$router->post('/api/admin/pages/navigator/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new PagesNavigatorDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add Event

$router->post('/api/admin/events/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            new EventAdd;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete Event 

$router->post('/api/admin/events/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            new EventDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit Event

$router->post('/api/admin/events/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_events') == 'access') {
            new EventEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add News

$router->post('/api/admin/news/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            new NewsAdd;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete News

$router->post('/api/admin/news/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            new NewsDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit News

$router->post('/api/admin/news/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_news') == 'access') {
            new NewsEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add Message

$router->post('/api/admin/messages/add', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            new MessageAdd;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit Message

$router->post('/api/admin/messages/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            new MessageEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Delete Message

$router->post('/api/admin/messages/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_messages') == 'access') {
            new MessageDelete;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit Banners

$router->post('/api/admin/banner/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
            new BannersEdit;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Active Banners

$router->post('/api/admin/banner/active', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
            $t = new BannersCheck();
            
            $t->Active();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Disabled Banners

$router->post('/api/admin/banner/disabled', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
            $t = new BannersCheck();
            
            $t->Disabled();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Edit Banner Top

$router->post('/api/admin/banner/top', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_banners') == 'access') {
            new BannersTop;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Newsletter Status Change

$router->post('/api/admin/newsletter/status', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_newsletter') == 'access') {
            $t = new Newsletter();
            
            $t->Status();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Newsletter Create Message

$router->post('/api/admin/newsletter/create', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_newsletter') == 'access') {
            $t = new Newsletter();
            
            $t->CreateMessage();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Newsletter Delete Email 

$router->post('/api/admin/newsletter/email_delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_newsletter') == 'access') {
            $t = new Newsletter();
            
            $t->Delete();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Newsletter Regiser

$router->post('/api/newsletter', function() {
    $t = new Newsletter();
            
    $t->Register();
});

// User Delete

$router->post('/api/admin/users/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_users') == 'access') {
            $t = new Users();
            
            $t->Delete();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// User Add

$router->post('/api/admin/users/create', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_users') == 'access') {
            $t = new Users();
            
            $t->Create();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// User edit

$router->post('/api/admin/users/edit', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_users') == 'access') {
            $t = new Users();
            
            $t->Edit();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Permissions Create

$router->post('/api/admin/permissions/create', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_permissions') == 'access') {
            $t = new Permissions();
            
            $t->Create();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Permissions Delete

$router->post('/api/admin/permissions/delete', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_permissions') == 'access') {
            $t = new Permissions();
            
            $t->Delete();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Settinds Password

$router->post('/api/admin/settings/password', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access') {
            $t = new Settings();
            
            $t->Password();
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add Img Summernote

$router->post('/api/admin/pages/summernote/add/img', function() {
    if(!Session::Logging()) {
        header('Location: /admin/login');
        return false;
    } else {
        if(Protections::Permission('permission_admin_access') == 'access' AND Protections::Permission('permission_admin_pages') == 'access') {
            new SummernoteImg;
        } else {
            header('Location: /');
            return false;
        }
    }
});

// Add Comment

$router->post('/api/web/news/add/comment', function() {
    new AddComment;
});

$router->post('/api/web/event/add/comment', function() {
    new AddEvent;
});