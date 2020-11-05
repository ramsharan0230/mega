<?php

if (!function_exists('getClassNameForIcons')) {
   function getClassNameForIcons($piller_slug)
   {
      switch ($piller_slug) {
         case "to-learn":
            return 'fa fa-book';
            break;
         case "to-grow":
            return 'fa fa-level-up';
            break;
         case "to-stand":
            return 'ti-light-bulb';
            break;
         case "to-teach":
            return 'fa fa-television';
            break;
         default:
            return 'none';
      }
   }
}
