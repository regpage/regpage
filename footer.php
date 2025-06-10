<?php

$info = db_getTextBlock('footer');

echo '<div id="footer_block" style="text-align: center; margin-top:50px; padding-top:20px; color: #ababab !important;">'.$info.'</div>';

if (empty($_COOKIE['cookie-agreement'])): ?>
    <div style="position: fixed; bottom: 0; left: 0; right: 0; margin-left: auto;  margin-right: auto; background-color: lightgray; padding: 5px 10px; border-rounded: 10px; text-align: center;"><div>Этот сайт использует файлы cookie. Продолжая пользоваться сайтом, вы даёте согласие на работу с этими файлами. <button id="cookie_agreement_accept" class="btn btn-primary">OK</button></div></div>
<?php endif; ?>

      <script src="/js/design_old.js?v7"></script>
    </body>
</html>
