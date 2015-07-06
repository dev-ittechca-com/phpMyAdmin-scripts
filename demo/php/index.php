<?php

$version_data = parse_ini_file('versions.ini');
$pma_branches = $version_data['branches'];
$pma_master_rel = $version_data['master-release'];

function pma_branch_desc($branch, $short = false) {
    $match = array();
    if ($branch == 'stable') {
        return 'Stable version included in Debian Sid.';
    } elseif ($branch == 'themes') {
        return 'phpMyAdmin addon themes all in one file.';
    } elseif (preg_match('/themes-([0-9]*)\.([0-9]*)/', $branch, $match)) {
        return sprintf('phpMyAdmin addon themes for %s releases all in one file.', $match[1] . '.' . $match[2] . '.x');
    } elseif ($branch == 'master') {
        return sprintf('Development version, it will later become %s.', $GLOBALS['pma_master_rel']);
    } elseif (preg_match('/QA_([0-9]*)_([0-9]*)/', $branch, $match)) {
        return sprintf('Maintenance branch for %s releases.', $match[1] . '.' . $match[2] . '.x');
    } elseif (preg_match('/MAINT_([0-9]*)_([0-9]*)_([0-9]*)/', $branch, $match)) {
        return sprintf('Maintenance branch for %s releases.', $match[1] . '.' . $match[2] . '.' . $match[3]) . ' ' . 'This gets only urgent fixes.';
    } elseif ($branch == 'STABLE') {
        return 'Latest phpMyAdmin stable release.';
    } elseif ($branch == 'TESTING') {
        return 'Latest phpMyAdmin testing release.';
    } else {
        return 'Unknown, please report this error.';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head profile="http://purl.org/uF/2008/03/ http://purl.org/uF/hAtom/0.1/">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="phpMyAdmin devel team" />
  <meta name="copyright" content="Copyright © 2003 - 2012 phpMyAdmin devel team" />
  <link rel="copyright" href="http://www.phpmyadmin.net/home_page/license.php" />
  <title>phpMyAdmin - Demo server</title>
  <link rel="stylesheet" type="text/css" href="https://www.phpmyadmin.net/static/css/style.css"/>
  <link rel="stylesheet" href="https://www.phpmyadmin.net/static/css/font-awesome.min.css">

  <link rel="shortcut icon" href="https://www.phpmyadmin.net/static/favicon.ico" type="image/x-icon" />
  <link rel="icon" href="https://www.phpmyadmin.net/static/favicon.ico" type="image/x-icon" />
  <link rel="vcs-git" href="git://github.com/phpmyadmin/phpmyadmin.git" title="phpMyAdmin Git repository" />
  <link rel="vcs-browse" href="http://github.com/phpmyadmin/" title="phpMyAdmin Git repository browser" />
  <meta name="verify-v1" content="3AM2eNj0zQ1Ao/N2eGE02S45V3p5KQxAyMIxdUJhtEQ=" />
  <meta name="robots" content="index, follow" />
  <script type="text/javascript">
  window.google_analytics_uacct = "UA-2718724-5";
  </script>
 </head>
 <body>
  <header>
   <nav>
   <div class="menu">
    <a href="https://www.phpmyadmin.net/" >Home</a>

    <a href="https://www.phpmyadmin.net/news/">News</a>

    <a href="https://www.phpmyadmin.net/security/" >Security</a>

    <a href="https://www.phpmyadmin.net/support/" >Support</a>

    <a href="https://www.phpmyadmin.net/docs/" >Docs</a>

    <a href="https://www.phpmyadmin.net/try/" class="active" >Try</a>

    <a href="https://www.phpmyadmin.net/contribute/" >Contribute</a>

    <a href="https://www.phpmyadmin.net/sponsors/" >Sponsors</a>

    <a href="https://www.phpmyadmin.net/themes/" >Themes</a>

    <a href="https://www.phpmyadmin.net/downloads/" >Download</a>

   </div>
   <div class="clearer"></div>
   </nav>
    <h1><a href="https://www.phpmyadmin.net/" rel="home"><span id="logo">phpMyAdmin</span></a> Planet phpMyAdmin</h1>
  </header>
  <div id="body" class="demo-body">
<h2>Demo Server</h2>
  <p>
    This host runs some <a href="http://www.phpmyadmin.net">phpMyAdmin</a>
    demos. You have full control over the MySQL server, however you should not
    change root, debian-sys-maint or pma user password or limit their
    permissions. If you do so, demo can not be accessed  until privileges are
    restored, so you just break things for you and other users. Feel free to
    try any of the phpMyAdmin features. If you break
    something, just wait a while. The database configuration resets every
    hour. Databases are cleaned every Monday morning, so do not expect
    that your data will stay there forever.
  </p>

  <p>
    Demo is running on <a href="http://www.mysql.com">MySQL</a>,
    <a href="http://www.drizzle.org/">Drizzle</a> and
    <a href="https://mariadb.org/">MariaDB</a>.
    phpMyAdmin has enabled additional relational features
    and MIME transformations. Demos use mysqli extension, unless stated
    otherwise.
  </p>

  <h2>Login information</h2>
  <p>
    Login is root with empty password or any user you create.
  </p>

  <h2>Available demo versions</h2>

  <p>
    Please note that git versions don't have to be working, that's why it's development version :-).
  </p>

  <h3>Releases and maintenance branches</h3>

  <ul>

<?php
foreach($pma_branches as $branch) {
    if (strstr($branch, 'master') !== false) continue;
    echo '<li>';
    echo '<a href="/' . $branch . '/">' . pma_branch_desc($branch) . '</a>';
    if (strstr($branch, '-config') === false && strstr($branch, '-http') === false) {
        echo ' (<a href="/' . $branch . '/?pma_username=root">' . 'direct login' . '</a>)';
    }
    echo '</li>';
}
?>
  </ul>

  <h3><?php printf('Development version (future %s)', $GLOBALS['pma_master_rel']); ?></h3>

  <ul>

<?php
foreach($pma_branches as $branch) {
    if (strstr($branch, 'master') === false) continue;
    echo '<li>';
    echo '<a href="/' . $branch . '/">';
    if (strstr($branch, '-config') !== false) {
        echo 'Configured for config auth';
    } elseif (strstr($branch, '-http') !== false) {
        echo 'Configured for http auth';
    } else {
        echo 'Configured for cookie auth';
    }
    echo ' and ';
    if (strstr($branch, '-mysql') !== false) {
        echo 'using mysql extension.';
    } else {
        echo 'using mysqli extension.';
    }
    if (strstr($branch, '-nopmadb') !== false) {
        echo ' ' . 'Without advanced features requiring extra database.';
    }
    echo '</a>';
    if (strstr($branch, '-config') === false && strstr($branch, '-http') === false) {
        echo ' (<a href="/' . $branch . '/?pma_username=root">' . 'direct login' . '</a>)';
    }
    echo '</li>';
}
?>
  </ul>

  <h2><?php echo 'Current documentation and tools';?></h2>
  <ul>
    <li>
      <a href="http://docs.phpmyadmin.net/"><?php echo 'Main documentation (including FAQ)';?></a>
    </li>
    <li>
      <a href="/master-config/changelog.php"><?php echo 'ChangeLog (preprocessed to be user friendly)';?></a>
    </li>
    <li>
      <a href="/master-config/license.php"><?php echo 'License';?></a>
    </li>
    <li>
      <a href="/master-config/setup/"><?php echo 'Setup script';?></a>
    </li>
   </ul>

</div>
<div class="sidebar">
<h3><?php echo 'Quick navigation'; ?></h3>
<ul>
<li><a href="/master"><?php echo 'Cookie auth'; ?></a></li>
<li><a href="/master-config"><?php echo 'Config auth'; ?></a></li>
<li><a href="/master-http"><?php echo 'HTTP auth'; ?></a></li>
<li><a href="/master-config-nopmadb"><?php echo 'Config auth, no pmadb'; ?></a></li>
</ul>
</div>

<footer>
  <ul>
    <li>Copyright &copy; 2003 - 2015 <span class="vcard"><a class="url org fn" href="https://www.phpmyadmin.net/team/">phpMyAdmin contributors</a><a href="mailto:phpmyadmin-devel@lists.sourceforge.net" class="email"></a></span></li>
    <li><a href="https://www.phpmyadmin.net/license/" rel="license">License</a></li>
    <li><a href="https://www.phpmyadmin.net/donate/" rel="payment" title="Support phpMyAdmin by donating money!">Donate</a></li>
    <li><a href="https://www.phpmyadmin.net/search/" title="Search for phpMyAdmin related questions">Search</a></li>
    <li><a href="https://www.phpmyadmin.net/about-website/" title="Information about website">About</a></li>
    <li class="logo"><a href="http://google.com/+phpmyadmin"><i class="fa fa-google-plus-square"></i></a></li>
    <li class="logo"><a href="http://twitter.com/phpmya"><i class="fa fa-twitter-square"></i></a></li>
    <li class="logo"><a href="https://www.facebook.com/pages/PhpMyAdmin/157021164334486"><i class="fa fa-facebook-official"></i></a></li>
  </ul>
  </footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2718724-5', 'auto');
  ga('send', 'pageview');

</script>
 </body>
</html>
