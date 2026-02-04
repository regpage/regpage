<?php
/**
 * создание модальных окон
 * !!! КНОПКИ СДЕЛАТЬ СТАТИЧНЫМИ И ВОЗВРАЩАТЬ ИХ ПО ТИПУ ПЕРЕДАВАЯ ID ВОЗМОЖНО ПЕРЕЗАТЬ КЛАССЫ И СТИЛИ Button::success('set_something', 'Сохранить', 'ml-2', 'max-width: 100px;','close','#open')
 */

 namespace App\UI\Components;

 /**
  * Класс для генерации модальных окон.
  * Наследует базовую логику работы с атрибутами от HtmlComponent.
  */
 class ModalWindow extends HtmlComponent
 {
     private string $title = '';
     private string $body = '';
     private string $footer = '';
     private string $size = 'md';

     // Отдельное хранилище для атрибутов хедера
     protected array $headerAttributes = [];

     /**
      * Установить заголовок окна
      */
     public function setTitle(string $title): self
     {
         $this->title = $title;
         return $this;
     }

     /**
      * Установить основной контент
      */
     public function setBody(string $content): self
     {
         $this->body = $content;
         return $this;
     }

     /**
      * Установить содержимое подвала (обычно кнопки)
      */
     public function setFooter(string $content): self
     {
         $this->footer = $content;
         return $this;
     }

     /**
      * Установить размер: sm, md, lg, xl
      */
     public function setSize(string $size): self
     {
         $this->size = $size;
         return $this;
     }

     /**
      * Добавить атрибут именно в блок .modal-header
      */
     public function setHeaderAttribute(string $name, $value): self
     {
         $this->headerAttributes[$name] = $value;
         return $this;
     }

     /**
      * Рендеринг атрибутов хедера
      */
      public function setHeaderData(array $data): self
     {
         foreach ($data as $key => $value) {
             $this->headerAttributes["data-{$key}"] = $value;
         }
         return $this;
     }
     /**
          * Вспомогательный метод для генерации кнопок
          */
         protected function createButton(string $text, string $class = 'btn-secondary', array $attributes = []): string
         {
             $attrString = '';
             foreach ($attributes as $name => $value) {
                 $attrString .= sprintf(' %s="%s"', htmlspecialchars($name), htmlspecialchars($value));
             }

             return "<button type='button' class='btn {$class}' {$attrString}>{$text}</button>";
         }
         public function addButton(Button $button): self
    {
        $this->buttons[] = $button;
        return $this;
    }

    // Переопределяем рендер футера
    protected function renderFooter(): string
    {
        if (empty($this->buttons)) {
            return "";
        }

        $buttonsHtml = "";
        foreach ($this->buttons as $button) {
            $buttonsHtml .= $button->render() . " ";
        }

        return "<div class='modal-footer w-100'>{$buttonsHtml}</div>";
    }
     /**
      * Финальная сборка HTML
      */
     public function render(): string
     {
         // Атрибуты из HtmlComponent идут в главный контейнер .modal
         $mainAttributes = $this->renderAttributes();
         $headerAttributes = $this->renderHeaderAttributes();
         $footerHtml = $this->renderFooter();

         return "
         <div class='modal fade' id='{$this->id}' {$mainAttributes} tabindex='-1' role='dialog' aria-hidden='true'>
             <div class='modal-dialog modal-{$this->size}' role='document'>
                 <div class='modal-content'>
                     <div class='modal-header' {$headerAttributes}>
                         <h5 class='modal-title'>{$this->title}</h5>
                         <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                             <span aria-hidden='true'>&times;</span>
                         </button>
                     </div>
                     <div class='modal-body'>
                         {$this->body}
                     </div>
                     {$footerHtml}
                 </div>
             </div>
         </div>";
     }
 }
// Окно подтверждения удаления
class ConfirmDeleteModal extends ModalWindow
{
    public function __construct(string $id, string $itemName)
    {
        parent::__construct($id);
        $this->setTitle("Подтвердите удаление")
             ->setSize("sm")
             ->setBody("Вы уверены, что хотите удалить <b>{$itemName}</b>?")
             ->setFooter("
                <button class='btn btn-secondary' data-dismiss='modal'>Отмена</button>
                <button class='btn btn-danger'>Удалить навсегда</button>
             ");
    }
}
