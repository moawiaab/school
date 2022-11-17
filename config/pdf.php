<?php

return [
  'mode'                       => '',
  'format'                     => 'A4',
  'default_font_size'          => '12',
  'default_font'               => 'XBRiyaz',
  'margin_left'                => 5,
  'margin_right'               => 5,
  'margin_top'                 => 65,
  'margin_bottom'              => 5,
  'margin_header'              => 0,
  'margin_footer'              => 0,
  'orientation'                => 'P',
  'title'                      => 'Laravel mPDF',
  'author'                     => '',
  'watermark'                  => '',
  'show_watermark'             => false,
  'show_watermark_image'       => false,
  'watermark_font'             => '',
  'display_mode'               => 'fullpage',
  'watermark_text_alpha'       => 1,
  'watermark_image_path'       => '',
  'watermark_image_alpha'      => 1,
  'watermark_image_size'       => 'D',
  'watermark_image_position'   => 'P',
  'custom_font_dir'            => '',
  'custom_font_data'           => [],
  'auto_language_detection'    => false,
  'temp_dir'                   => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
  'pdfa'                       => false,
  'pdfaauto'                   => false,
  'use_active_forms'           => false,
];