<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DisplayOverride  {
    
   function boldFirst($str){
       $newWord = '';
       // For each letter in $str, if there is an upper case letter, Bold it.
       for($x = 0; $x < strlen($str); ++$x){                
            if(ctype_upper($str[$x])){
                $newWord = "<strong>" . $str[$x] . "</strong>";
                continue;                  
            }else{
                $newWord .= $str[$x];
                continue;
            }              
        }
        // return new word.
        return $newWord;
   }
   
   // Bolds all capital letters that appear inside a paragraph tag with the Lead Attribute
   function OverrideDisplay(){
       $CI =& get_instance();
       $output = $CI->output->get_output();     
       //Regex pattern for the lead attribute
       $lead = '/<p class="lead">(.*)<\/p>/';
       //Array for matches
       $matches = array();
       //If there is a match in $output with Lead Pattern
       if(preg_match($lead, $output, $matches)){
            //Split up matches with delimiter " " into $quote array
            $quote = explode(" ", $matches[0]);
            //Replace the lead tag with empty string for first word in quote
            $quote[1] = preg_replace('/(class="lead">)/', '', $quote[1]);
            /*
             * For each word in $quote array, call the boldFirst function to
             * bold each capital letter 
             */
            for($i = 0; $i < count($quote); ++$i){     
                $word = $quote[$i];
                $quote[$i] = self::boldFirst($word);
            }
            //Add the lead attribute back to first word in quote
            $quote[1] = 'class="lead">' . $quote[1]; 
            //put the words in $quote array back into a single string in new Matches index 0
            $newMatches[0] = implode(" ",$quote);
            //Create new buffer with newMatches 
            $newOutput = str_replace($matches[0], $newMatches[0], $output);
            $CI->output->set_output($newOutput);
       }else{
            $CI->output->set_output($output);
       }
       $CI->output->_display();  
   }
   
   
}