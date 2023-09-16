<?php

namespace App\Services;

use App\Models\CustomTemplate;
use App\Models\Template;

class HelperService 
{
    public static function getTotalWords()
    {   
        $value = number_format(auth()->user()->available_words + auth()->user()->available_words_prepaid);
        return $value;
    }

    public static function getTotalImages()
    {   
        $value = number_format(auth()->user()->available_images + auth()->user()->available_images_prepaid);
        return $value;
    }

    public static function listTemplates()
    {   
        $all_templates = Template::orderBy('group', 'asc')->where('status', true)->get();
        return $all_templates;
    }

    public static function listCustomTemplates()
    {   
        $custom_templates = CustomTemplate::orderBy('group', 'asc')->where('status', true)->get();
        return $custom_templates;
    }

    public static function userAvailableWords()
    {   
        $value = self::numberFormat(auth()->user()->available_words + auth()->user()->available_words_prepaid);
        return $value;
    }

    public static function userPlanTotalWords()
    {   
        $value = self::numberFormat(auth()->user()->total_words);
        return $value;
    }

    public static function userAvailableImages()
    {   
        $value = self::numberFormat(auth()->user()->available_images + auth()->user()->available_images_prepaid);
        return $value;
    }

    public static function userPlanTotalImages()
    {   
        $value = self::numberFormat(auth()->user()->total_images);
        return $value;
    }

    public static function userAvailableChars()
    {   
        $value = self::numberFormat(auth()->user()->available_chars + auth()->user()->available_chars_prepaid);
        return $value;
    }

    public static function userPlanTotalChars()
    {   
        $value = self::numberFormat(auth()->user()->total_chars);
        return $value;
    }

    public static function userAvailableMinutes()
    {   
        $value = self::minutesFormat(auth()->user()->available_minutes + auth()->user()->available_minutes_prepaid);
        return $value;
    }

    public static function userPlanTotalMinutes()
    {   
        $value = self::minutesFormat(auth()->user()->total_minutes);
        return $value;
    }

    public static function numberFormat($num) {

        if($num > 1000) {
      
              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array('K', 'M', 'B', 'T');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];
      
              return $x_display;
      
        }
      
        return $num;
    }

    public static function minutesFormat($num) {

        $num = floor($num);

        if($num > 1000) {
      
              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array('K', 'M', 'B', 'T');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];
      
              return $x_display;
      
        }
      
        return $num;
    }
}