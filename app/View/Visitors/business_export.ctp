<?php

// app/Views/Subscribers/export.ctp

foreach ($data as $row):
  foreach ($row['Visitor'] as &$cell):
    // Escape double quotation marks
    $cell = '"' . preg_replace('/"/','""',$cell) . '"';
  endforeach;
  echo implode(',', $row['Visitor']) . "\n";
endforeach;
