<?php

class Eruda_Helper_Parser {
    static function parseMonth($month){
        switch ($month){
            case 1 : return 'Enero';
            case 2 : return 'Febrero';
            case 3 : return 'Marzo';
            case 4 : return 'Abril';
            case 5 : return 'Mayo';
            case 6 : return 'Junio';
            case 7 : return 'Julio';
            case 8 : return 'Agosto';
            case 9 : return 'Octubre';
            case 10 : return 'Septiembre';
            case 11 : return 'Noviembre';
            case 12 : return 'Diciembre';
        }
    }
    
    static function parseDate($date){
        return date ( "j.n.Y" , strtotime($date));
    }
    
    static function parseAllDate($date){
        $ret = date ( "j" , strtotime($date)). ' de ';
        $ret .= self::parseMonth( date ( "n" , strtotime($date))).' de ';
        $ret .= date ( "Y" , strtotime($date)).' a las '.date ( "G:i" , strtotime($date));
        
        return $ret;
    }
    
    static function Text2Link($text){
        $text = strtolower($text);
        $text = str_replace(' ', '_', $text);
        $safe = "~![a-zA-Z0-9-_.!*'()]~";
	return preg_replace ($safe,
            '-',$text);
    }
    
    static function Link2Text($text){
        return str_replace('_', ' ', $text);
    }
    
    static function parseText($text){
        
        $text = utf8_encode($text);
        
        /**Replace BBCode**/
        $tags = 'b|i|size|color|center|url|img'; 
        while (preg_match_all('`\[('.$tags.')=?(.*?)\](.+?)\[/\1\]`is', $text, $matches)) foreach ($matches[0] as $key => $match) { 
            list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]); 
            switch ($tag) { 
                case 'b': $replacement = '<span class="BB_b">'.$innertext.'</span>'; break; 
                case 'i': $replacement = '<span class="BB_i">'.$innertext.'</span>'; break; 
                case 'size': $replacement = '<span style="font-size: '.$param.';">$innertext</span>'; break; 
                case 'color': $replacement = '<span style="color: '.$param.';">$innertext</span>'; break; 
                case 'center': $replacement = '<div class="center">'.$innertext.'</div>'; break; 
                case 'url': $replacement = '<a href="' . ($param? $param : $innertext) . "\">$innertext</a>"; break; 
                case 'img': 
                    list($width, $height) = preg_split('`[Xx]`', $param); 
                    $replacement = "<img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/>'; 
                break; 
                case 'video': 
                    $videourl = parse_url($innertext); 
                    parse_str($videourl['query'], $videoquery); 
                    if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>'; 
                    if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>'; 
                break; 
            } 
            $text = str_replace($match, $replacement, $text); 
        } 
        
        $text = nl2br($text);
        
        
        //Emoticonos
        $emotic = array('cabre', 'chulo', 'confu', 'dance', 'duda', 'lloron', 'love', 'nervi', 'plauso', 'sorry', 'morros', 'casi', 'powa', 'trellao');
        
        if (preg_match_all('`:('.implode('|', $emotic).'):`is', $text, $matches)) foreach ($matches[0] as $key => $match) { 
            $emot = $matches[1][$key];
            $replacement = '<img class="emoticono" src="/emotic/icon_'.$emot.'.gif" alt=":'.$emot.':"/>';
            $text = str_replace($match, $replacement, $text); 
        } 
                
        /**Replace Items**/
        $tags = 'cap|ani'; 
        while (preg_match_all('`\[('.$tags.')\]([0-9]+)\[/\1\]`is', $text, $matches)) foreach ($matches[0] as $key => $match) { 
            list($tag, $param) = array($matches[1][$key], $matches[2][$key]); 
            switch ($tag) { 
                case 'ani': 
                    $cap = Eruda_Mapper_Anime::get($param);
                    $replacement = $cap->__toString();
                    break; 
                case 'cap': 
                    $cap = Eruda_Mapper_Manga::get($param);
                    $replacement = $cap->__toString();
                    break; 
            } 
            $text = str_replace($match, $replacement, $text); 
        } 
        
        
        return $text;
    }
    
}
?>
