<?php
/**
 * Description of Eruda_Cron
 *
 * @author gaixas1
 */
class Eruda_Cron {
    private $file;
    private $bkp;
    private $maxbkp;
    
    public function __construct() {
        $this->file = PATH.'\log.txt';
        $this->bkp = 'fallensoul.es';
        //$this->bkp = 'copy.fallensoul.es';
        $this->maxbkp = 10;
    }

    public function log($txt){
        file_put_contents($this->file, date(DATE_ATOM).' - '. $txt.'
', FILE_APPEND );;
    }
    
    public function ini(){
        Eruda::getDBConnector()->connect();
    }
    public function end(){
        Eruda::getDBConnector()->disconnect();
    }
    
    public function backup(){
        
        $i = 0;
        foreach(Eruda_Mapper_Manga::getNoUpdatedSeries() as $t){
            $t['action'] = 'update1';
            $t['auto'] = md5('update_mangaseries');
            if($this->http_request('POST', $this->bkp, 80, '/copy/', $t) == 'OK') {
                Eruda_Mapper_Manga::setUpdatedSerie($t['id']);
                $i++;
                $this->log('Updated : MangaSerie '.$t['id']);
            } else {
                $this->log('Error Update : MangaSerie '.$t['id']);
                return;
            }
            if($i>$this->maxbkp) return;
        }
        foreach(Eruda_Mapper_Anime::getNoUpdatedSeries() as $t){
            $t['action'] = 'update2';
            $t['auto'] = md5('update_animeseries');
            if($this->http_request('POST', $this->bkp, 80, '/copy/', $t) == 'OK') {
                Eruda_Mapper_Anime::setUpdatedSerie($t['id']);
                $i++;
                $this->log('Updated : AnimeSerie '.$t['id']);
            } else {
                $this->log('Error Update : AnimeSerie '.$t['id']);
                return;
            }
            if($i>$this->maxbkp) return;
        }
        foreach(Eruda_Mapper_Manga::getNoUpdated() as $t){
            $t['action'] = 'update3';
            $t['auto'] = md5('update_mangaclass');
            if($this->http_request('POST', $this->bkp, 80, '/copy/', $t) == 'OK') {
                Eruda_Mapper_Manga::setUpdated($t['id']);
                $i++;
                $this->log('Updated : Manga '.$t['id']);
            } else {
                $this->log('Error Update : Manga '.$t['id']);
                return;
            }
            if($i>$this->maxbkp) return;
        }
        foreach(Eruda_Mapper_Anime::getNoUpdated() as $t){
            $t['action'] = 'update4';
            $t['auto'] = md5('update_animeclass');
            if($this->http_request('POST', $this->bkp, 80, '/copy/', $t) == 'OK') {
                Eruda_Mapper_Anime::setUpdated($t['id']);
                $i++;
                $this->log('Updated : Anime '.$t['id']);
            } else {
                $this->log('Error Update : Anime '.$t['id']);
                return;
            }
            if($i>$this->maxbkp) return;
        }
    }
    
    
    public function avisos(){
        
    }
    
    

    private function http_request( $verb, $ip, $port = 80, $uri = '/', $postdata = array(), $timeout = 1000, $req_hdr = false, $res_hdr = false )  { 
        $ret = ''; 
        $verb = strtoupper($verb); 
        $postdata_str = ''; 

        foreach ($postdata as $k => $v) 
            $postdata_str .= urlencode($k) .'='. urlencode($v) .'&'; 

        $crlf = "\r\n"; 
        $req = $verb .' '. $uri .' HTTP/1.1' . $crlf; 
        $req .= 'Host: '. $ip . $crlf; 
        $req .= 'User-Agent: Mozilla/5.0 Firefox/3.6.12' . $crlf; 
        $req .= 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' . $crlf; 
        $req .= 'Accept-Language: en-us,en;q=0.5' . $crlf; 
        $req .= 'Accept-Encoding: deflate' . $crlf; 
        $req .= 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7' . $crlf; 

        if ($verb == 'POST' && !empty($postdata_str)) 
        { 
            $postdata_str = substr($postdata_str, 0, -1); 
            $req .= 'Content-Type: application/x-www-form-urlencoded' . $crlf; 
            $req .= 'Content-Length: '. strlen($postdata_str) . $crlf . $crlf; 
            $req .= $postdata_str; 
        } 
        else $req .= $crlf; 

        if ($req_hdr) 
            $ret .= $req; 

        if (($fp = @fsockopen($ip, $port, $errno, $errstr)) == false) 
            return "Error $errno: $errstr\n"; 

        stream_set_timeout($fp, 0, 1000 * 1000); 

        fputs($fp, $req); 
        while ($line = fgets($fp)) $ret .= $line; 
        fclose($fp); 

        if (!$res_hdr) 
            $ret = substr($ret, strpos($ret, "\r\n\r\n") + 4); 

        return $ret; 
    } 
}

?>
