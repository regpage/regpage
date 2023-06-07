<script>
  let data_page = {};
  // get admin ID
  data_page.admin_id = <?php echo $memberId; ?>;
  // get members category
  data_page.category = {
  <?php foreach ($member_categories as $key => $value) { ?>
    "<?php echo $key; ?>":"<?php echo $value; ?>",
  <?php } ?>
};
</script>

<script src="js/ftt/ftt_applications_list/script.js?v8"></script>
<script src="js/ftt/ftt_applications_list/design.js?v1"></script>
