<?php

namespace Bglobal\Options\Http\Helpers;
use Config;

class options_helper
{
    public static function getHFHtml($Obj)
    {
//        $Obj = json_decode(Config::get('bglobal_settings.header'), true);
        $totalRow = count($Obj);
        if($totalRow==0){
            return '';
        }
        $totalAvgCol = 12 / $totalRow;
        $html = '';
        $col = '';
        $i = 0;
        foreach ($Obj as $k => $v) {
            $i++;
            $sectionClasse = Config::get('option.header_footer_option')['class'] . $i;
            $baseClass = Config::get('option.header_footer_option')['base_class'];
            if ($k == 'custom') {
                $col = '_custom_header';
            } else {
                $col = $baseClass.'-' . $totalAvgCol;
            }

            if ($i == $totalRow) {
                $html .= '<div class="' . $col . ' ' . $sectionClasse . ' text-right">';

            } else {
                $html .= '<div class="' . $col . ' ' . $sectionClasse . '">';
            }
            $html .= $v;
            $html .= '</div>';
        }
        return $html;
    }


}