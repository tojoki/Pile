<?php

function starshow($val){
    $intval = floor($val);
    $decval = (int)(($val - $intval)*10);
    $str = '';
    $i = 0;
    for($i=0;$i<$intval;$i++){
        $str .= '<i class="s_icon4 offset_'.$i.'"></i>';
    }
    if($i==0){
        $offset = 0;
    }else{
        $offset = $i;
    }
    switch ($decval) {
        case 1:
        case 2:
        case 3:
        case 4:
            $str .= '<i class="s_icon1 offset_'.$offset.'"></i>';
            break;
        case 5:
        case 6:
        case 7:
            $str .= '<i class="s_icon2 offset_'.$offset.'"></i>';
            break;
        case 8:
        case 9:
            $str .= '<i class="s_icon3 offset_'.$offset.'"></i>';
            break;
        default:
            $str .= '<i class="s_icon0 offset_'.$offset.'"></i>';
            break;
    }
    for($j=5;$j>($i+1);$j--){
        $str .= '<i class="s_icon0 offset_'.(5-$j+$i+1).'"></i>';
    }
    return $str;
}
?>