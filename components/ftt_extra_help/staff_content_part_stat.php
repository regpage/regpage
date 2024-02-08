<div id="" class="row">
  <div class="col-2 cursor-pointer text_blue mb-2 ml-3"><b class="sort_name_stat">Дата<i class="fa fa-sort-<?php echo $sortingStat; ?>"></i></b></div>
</div>
<div class="accordion" id="accordionExtraHelpStat">
  <?php foreach (getStatisticsExtraHelp($sortingStat) as $key => $value): ?>
    <div class="card" data-member_key="<?php echo $key; ?>">
      <div class="card-header pl-2" id="heading<?php echo $key; ?>">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left pl-1" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse<?php echo $key; ?>">
            <?php echo $value[0]['name']; ?>
          </button>
        </h2>
      </div>
      <div id="collapse<?php echo $key; ?>" class="collapse" aria-labelledby="heading<?php echo $key; ?>" data-parent="#accordionExtraHelpStat">
        <div class="card-body">
          <?php foreach ($value as $subKey => $subValue): ?>
            <div class="row py-2 border-bottom <?php if ($subValue['archive'] == 1): ?>
              green_string
            <?php endif; ?>">
              <div class="col-1">
                <?php
                $dateStat = date_convert::yyyymmdd_to_ddmm($subValue['date']);
                echo $dateStat; ?>
              </div>
              <div class="col-10">
                <?php echo $subValue['reason']; ?>
              </div>
              <div class="col-1">
                <?php if (!empty($subValue['comment'])): ?>
                  <span class=" ml-3 align-middle" title="<?php echo $subValue['comment']; ?>"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
