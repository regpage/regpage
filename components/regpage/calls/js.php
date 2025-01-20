<script src="js/modules/blank.js?v1"></script>
<script src="js/modules/name.js?v1"></script>
<script src="js/modules/date.js?v1"></script>
<script src="js/modules/cookie.js?v1"></script>
<script src="js/modules/phone_field.js?v3"></script>
<script src="js/regpage/calls/script.js?v14"></script>
<script src="js/regpage/calls/client.js?v21"></script>
<script src="js/regpage/calls/design.js?v5"></script>

<script>
  let open_id;
  <?php if (isset($_GET['id']) && !empty($_GET['id'])) { ?>
    open_id = "<?php echo $_GET['id']; ?>";
  <?php } ?>
  let gl_calls_user_data = {};
  gl_calls_user_data["role"] = "<?php echo $callsUserData['role']; ?>";
  gl_calls_user_data["male"] = "<?php echo $callsUserData['male']; ?>";
  gl_calls_user_data["comment"] = "<?php echo $callsUserData['comment']; ?>";
</script>
