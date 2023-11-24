<?php
    include_once "header.php";
    include_once "nav.php";
    include_once "modals.php";
    include_once "db/regpage/reference_db.php";

    $sort_field = isset ($_COOKIE['sort_field_reference']) ? $_COOKIE['sort_field_reference'] : 'name';
    $sort_type = isset ($_COOKIE['sort_type_reference']) ? $_COOKIE['sort_type_reference'] : 'asc';

    $references = db_getReferences($sort_field, $sort_type);
?>

<div class="container">
    <div class="reference-content tab-content">
        <div>
            <a class="btn btn-primary btn-add-reference"><i class="fa fa-plus" title="Добавить"></i> <span class="hide-name">Добавить</span></a>
        </div>
        <?php
            if(!$references){
                echo '<div style="text-align: center;"><h4>На данный момент нет созданных справок</h4></div>';
            }
            else{
        ?>
            <div class="desctop-references-header" style="margin-top: 20px; border-bottom: 1px solid #f5f5f5; height: 30px;">
                <div class="span4">
                    <a id="sort-name" href="#" title="сортировать">Название</a>&nbsp;
                        <i class="<?php echo $sort_field == 'name' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i>
                </div>
                <div class="span2">
                    <a id="sort-page_name" href="#" title="сортировать">Страница</a>&nbsp;
                        <i class="<?php echo $sort_field == 'page_name' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i>
                </div>
                <div class="span2">
                    <a id="sort-block_name" href="#" title="сортировать">Блок на главной</a>&nbsp;
                    <i class="<?php echo $sort_field == 'block_name' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i>
                </div>
                <div class="span2">Опубликовано</div>
                <div class="span1">&nbsp;</div>
            </div>
            <div class="references-list">
                <div class="desctop-references"></div>
                <div class="phone-references"></div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Users Emails Modal -->
<div id="modalAddReference" data-width="400" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3>Карточка инструкции</h3>
    </div>
    <div class="modal-body">
        <div >
            <label class="">Название инструкции</label>
            <input class=" name" type="text" />
        </div>
        <div >
            <label class="">Ссылка на инструкцию</label>
            <input class=" link-article" type="text" />
        </div>
        <div>
            <label class="">Страница на сайте</label>
            <select class=" page" >
                <?php
                $pages = db_getPages();
                foreach ($pages as $key => $page) {
                    echo "<option value='".$key."' >".$page."</option>";
                }
                ?>
            </select>
        </div>
        <div >
            <label class="">Блок на главной</label>
            <select class="block" >
                <?php
                echo "<option value='_none_'>&nbsp;</option>";

                $blocks = db_getReferencesBlock();
                foreach ($blocks as $key => $block) {
                    echo "<option value='".$key."' >".$block."</option>";
                }
                ?>
            </select>
        </div>
        <div >
            <label class="">Опубликовано</label>
            <select class=" published">
                <option value='0' selected>НЕТ</option>
                <option value='1'>ДА</option>
            </select>
        </div>
        <div >
            <label class="">Приоритет</label>
            <input class="priority" type="text" />
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary handle-reference" ></button>
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
</div>

<div id="modalDeleteReference" class="modal hide fade" tabindex="-1" role="dialog"  aria-labelledby="regEndedTitle" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 id="regEndedTitle">Подтверждение удаления справки</h4>
    </div>
    <div class="modal-body">
        <h4>Вы действительно хотите удалить справку: <em class="deleted-reference"></em> ?</h4>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary delete-reference">Да</button>
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
</div>
<script src="/js/regpage/reference/script.js?v1"></script>
<script src="/js/regpage/reference/design.js?v1"></script>
