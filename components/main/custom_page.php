<?php
// determine a special page
$specPage = NULL;
foreach (CustomPage::getSpecPages() as $sp){
    if (isset ($_GET[$sp])){
        $specPage = $sp;
        break;
    }
}

if ($specPage){
    include 'header.php';
    include 'nav.php';
    include 'modals.php';

    echo '<div class="container"><div style="background-color: white; padding: 20px;">';
    echo CustomPage::getPage($specPage);
    echo'</div>';
    include 'footer.php';
} else { ?>
  <script>
  window.location.href = '/isnotfound.html';
  </script>
  <?php
  //header("Location: ".$appRootPath."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
}
