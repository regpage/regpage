// Служба поддержки, окно. if mobile
if ($(window).width()<=992) {
      $('#formHolder').attr('data-width','320px');
} else {
  $('#formHolder').attr('data-width','740px');
}

// MESSAGE TO TEAMS OR SITE ADMIN
$('.send-message-support-phone').click(function(e) {
  (function(){var f='externalFormStarterCallback',s=document.createElement('script');
  window[f]=function(h){h.bind(document.getElementById('formHolder'))};
  s.type='text/javascript';s.async=1;
  s.src='https://pyrus.com/js/externalformstarter?jsonp='+f+'\x26id=967014';
  document.head.appendChild(s)})();
});
