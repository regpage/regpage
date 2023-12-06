        <div id="list_content_auth" class="mb-2">
          <div class="row">
            <div class="col-12">
              <h4>Обучающиеся ПВОМ</h4>
              <br>
            </div>
          </div>
          <div class="row">
            <?php foreach ($trainee_list as $key => $value): ?>
              <div class="col-3 col-fio">
                <?php echo $value; ?>
              </div>
              <div class="col-3">
                <span class="text-primary cursor-pointer auth_link" data-member_key="<?php echo $key; ?>"><i class="fa fa-sign-in h6" aria-hidden="true"></i></span>
              </div>

            <?php endforeach; ?>
          </div>
        </div>
