<!--ПРОЧИТАННЫЕ КНИГИ -->
<div id="mdl_bible_read_before" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Отметка прочитанных к началу семестра книг</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Статистика чтения Библии -->
<div class="modal fade" id="mdl_bible_statistic">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 600px;">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Статистика чтения Библии</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div id="bible_statistic_list" class="container">
          <canvas></canvas>
        </div>
        <div id="bible_statistic_list_dates" class="container">
          <canvas></canvas>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- ЧТЕНИЕ СТАРТ-->
<?php include 'components/ftt_reading/modal_part_start.php'; ?>
