<?php
// ДИАГРАММА
class SimplePlot {
  private $data = array(), $headers=array(), $percent = array(), $pixels = array();
  private $width, $sum, $count;

  function __construct ($data,$width=100) {
   $this->width = $width;
   $this->headers = array_keys($data);
   $this->data = array_values($data);
   $this->count = count($this->data);
   $this->sum = array_sum($data);
   for ($i=0; $i<$this->count; $i++) {
    if ($this->sum) $this->percent[$i] = $this->data[$i];
    else $this->percent[$i] = 0;
    $this->pixels[$i] = $this->percent[$i];
   }

  }

  function get () {
   $string = '<div class="plotTable">';
   for ($i=0; $i<$this->count; $i++) {
    $string .= '<div><div class="plotCountCell">'.$this->data[$i].$this->headers[$i].'</div>';
    $string .= '<div class="plotDataCell" style="min-height: '.$this->width.'px;"><div class="plotItemInCell" style="min-height: '.
     $this->pixels[$i].'px;"></div></div><div class="plotHeaderCell">'.$this->headers[$i].'</div>';
    $string .= '</div>';
   }
   $string .= '</div>';
   return $string;
  }

  function show () {
   echo $this->get();
  }
 }
