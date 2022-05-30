<!-- Support buttons -->
<div class="send-message-support-phone" data-target="#choiseHelpPoint" data-toggle="modal" style="position: fixed; font-size: 16px; bottom: 95px; right: 10px; cursor: pointer; background-color: white; padding: 7px 14px; border-radius: 10px; border: 1px solid lightgrey;">Нужна помощь?</div>
<div class="send-message-support-phone" style="position: fixed; bottom: 0px; right: 0px; cursor: pointer;" data-target="#choiseHelpPoint" data-toggle="modal">
  <div class="webWidget__chatButton" style="background-color: rgb(244, 67, 54); color: white;">
    <div class="webWidget__buttonOverlay"></div>
    <svg width="63px" height="60px" viewBox="0 0 43 40" class="webWidget__buttonIcon" fill="white"><g stroke="none" stroke-width="1" fill="inherit" fill-rule="evenodd"><path d="M27.4458365,34.0675019 C25.5591994,34.4582171 23.5177637,34.6666667 21.3333333,34.6666667 C8.00488281,34.6666667 1.45661261e-13,26.906269 1.45661261e-13,17.3333333 C1.45661261e-13,7.76039767 7.94173177,2.13162821e-14 21.3333333,2.13162821e-14 C34.7249349,2.13162821e-14 42.6666667,7.76039767 42.6666667,17.3333333 C42.6666667,22.8947387 39.9649873,27.8444054 35.0873627,31.0161175 L37.3333333,40 L27.4458365,34.0675019 Z M35.0981607,24.0265195 C31.5856821,26.3080541 26.936562,27.6666667 21.3333333,27.6666667 C15.7301047,27.6666667 11.0809845,26.3080541 7.56850596,24.0265195 C10.159618,27.6200266 14.9107875,30 21.3333333,30 C27.7558791,30 32.5070486,27.6200266 35.0981607,24.0265195 Z"></path></g></svg>
  </div>
</div>
<!-- Support form -->
<div id="choiseHelpPoint" class="modal hide fade" tabindex="-1">
  <div class="modal-dialog modal-lg w-800">
    <div class="modal-content">
      <div class="modal-header" style="padding: 5px 16px">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <!--<button type="button" style="font-size: 22px; opacity: 0.6;">x</button>-->
      </div>
        <div class="modal-body">
          <!-- Вставьте этот HTML-код где вы хотите показать форму 320px -->
        <div id="formHolder" data-width=""></div>
        </div>
        <div class="modal-footer"></div>
      </div>
  </div>
</div>
<style media="screen">
/*support icon*/
.webWidget__buttonIcon {
    padding: 9px;
}

.webWidget__chatButton {
  flex-shrink: 0;
  flex-grow: 0;
  align-self: flex-end;
  cursor: pointer;
  width: 60px;
  height: 60px;
  border-radius: 10px;
  float: right;
  box-shadow: 0 2px 14px 0 rgba(0, 0, 0, 0.15);
  margin-right: 14px;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  margin-bottom: 20px;
}
.webWidget__buttonOverlay {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 4px;
  background-color: black;
  opacity: 0;
  top: 0;

  &:hover {
      opacity: 0.05;
  }
}
</style>
<script>

// MESSAGE TO TEAMS OR SITE ADMIN
$('.send-message-support-phone').click(function(e) {
  // Служба поддержки, окно. if mobile
  if ($(window).width()<=992) {
    $('#formHolder').attr('data-width','320px');
  } else {
    $('#formHolder').attr('data-width','740px');
  }
  (function(){var f='externalFormStarterCallback',s=document.createElement('script');
  window[f]=function(h){h.bind(document.getElementById('formHolder'))};
  s.type='text/javascript';s.async=1;
  s.src='https://pyrus.com/js/externalformstarter?jsonp='+f+'\x26id=967014';
  document.head.appendChild(s)})();
});
</script>
