<?php
    // This file is for plain PHP functions.
    // All methods involving SQL are in the various xClass.php files
    
     function createSlug($string) {
        // unique slug/identifier value for each post, allows multiple posts to have the same title but different URLs
        $slug = preg_replace('/[^A-Za-z0-9]+/', '-', $string);
        $slugSalt = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789_-'), 0, 20);
        $fullSlug = $slugSalt . $slug;
        return $fullSlug;
     }

     // shorten long title
     function sliceLongTitle($titleValue) {
        // prefered over overflow: hidden;, as the ellpises indicates a longer title rather than an abrupt cutoff
        $lengthOfTitle = strlen($titleValue);
        if ($lengthOfTitle > 29 ) {
            $subtractLength = $lengthOfTitle - 29;
            // ^ calculates the difference between the title length, and the number value 29, when the title is longer than 29
            // example: 31 char title: subtractLength = 2, as 31 - 29 = 2
            $shortenedTitleLength = $lengthOfTitle - $subtractLength; // then slices the title based on its length to keep it at 29 chars max
            $shortenedTitle = substr_replace($titleValue, "", $shortenedTitleLength) . ' ...';
            return $shortenedTitle;
        } else {
            return $titleValue;
        }
     }

     function sliceLongString($stringValue) {
        // same as sliceLongTitle(x) but for values in the dashboard table
        $lengthOfString = strlen($stringValue);
        if ($lengthOfString > 29 ) {
            $subtractLength = $lengthOfString - 29;
            $shortenedStringLength = $lengthOfString - $subtractLength;
            $shortenedString = substr_replace($stringValue, "", $shortenedStringLength) . ' ...';
            return $shortenedString;
        } else {
            return $stringValue;
        }
     }

     function sliceLongStringMobile($stringValue) {
        // allows dashboard values to fit on mobile devices, reduce length of strings to keep table narrow enough to fit on phone screens
        // user must view the post to view full length data
        $lengthOfString = strlen($stringValue);
        if ($lengthOfString > 6 ) {
            $subtractLength = $lengthOfString - 6;
            $shortenedStringLength = $lengthOfString - $subtractLength;
            $shortenedString = substr_replace($stringValue, "", $shortenedStringLength) . ' ...';
            return $shortenedString;
        } else {
            return $stringValue;
        }
     }
?>
 