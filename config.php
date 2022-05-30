<?php
    //MAILGUN SETTINGS
    // email validation key pubkey-374d943ceac32c02e5472106d416fbff
    // API-key : key-d4fd3a7aaf2ca0c25cc9601e5d3fb29d
    // 2FA paper key 3f5fe3c7f2d859c9a4b9df09e97a710d315a607461bde8075bf116fd769a69f8
    // 2FA WAOROAL3OCLQMA4W
    // 2FA code - 343435

    $host = $_SERVER['HTTP_HOST'];
    $db = new mysqli('localhost', "regpager_admin", "inChrist365", ($host == "localhost:8080" || substr($host, 4,3) === 'dev' ? "regpager_main" : "regpager_main"));

    $mailgunAdminPass = 'sdf3223@sfsdas2434SD23mlc2';
    $mailgunPostmasterPass = 'odfn234PMSD@ash242zxc346';
    $locHost = $_SERVER['HTTP_HOST'];
    $appRootPath = $locHost == 'localhost:8080' ? 'http://localhost:8080/' : (substr($locHost, 4,3) === 'dev' ? 'https://www.dev.reg-page.ru/' : 'https://reg-page.ru/');
?>
