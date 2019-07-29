<?php

namespace mj\libraries;

use mj\config;
use mj\languages\text as Txt;
use mj\libraries\application as App;

class helper{

    public static function genSelector($id, $options, $selected = null, $attributes =''){
        if(is_array($id)){
            list( $id, $name) = $id;
        }else{
            $name = $id;
        }

        $html = '<select name="'.$name.'" id="'.$id.'" '. $attributes. '>';

        foreach( $options as $opt ){
            if( is_array($opt) ){
                $text = isset($opt['text']) ? $opt['text'] : $opt[0];
                $value = isset($opt['value']) ? $opt['value'] : $opt[1];
            }else{
                $text = $value = (string) $opt;
            }
            $value = trim($value);

            $checked = '';
            if( is_array($selected)){
                if( in_array( $value, $selected)) $checked = ' selected ';
            }else if( $selected !== null){
                if( $value == $selected ) $checked = ' selected ';
            }

            $html .= '<option value="'. $value .'"'. $checked .'>'.$text.'</option>';
            
        }

        $html .= '</select>';

        return $html;
    }

    public static function genLabel($label, $id = ''){
        return '<label for="' . $id . '">'.$label.'</label>' ;
    }

    public static function genPagination($total, $link){
        
        $html = '';

        if( $total > 0):

            $html .= '<ul class="pagination">';

            $offset = App::use('input')->getPageOffset();
            $limit = config::$queryLimit;

            $totalPage = floor( $total / $limit ) + 1;
            $currentPage = floor( $offset / $limit ) + 1;

            $between = '';

            // previous
            if( $currentPage == 1){
                $html .= '<li class="page-item"><a class="page-link" >'. Txt::_('Previous').'</a></li>';
            }else{
                $start = ($currentPage - 2) * $limit;
                $link = self::addUrlVar($link, 'start='.$start);
                $html .= self::genPageInNav( false, Txt::_('Previous'), $link );
            }
            // pages
            for($i = 0; $i < $totalPage; $i++ ){
                $start = $i * $limit;
                $link = self::addUrlVar($link, 'start='.$start);
                $html .= self::genPageInNav( ($i +1 == $currentPage), ( $i + 1 ), $link );
            }
            // next
            if( $currentPage == $totalPage){
                $html .= '<li class="page-item"><a class="page-link" >'. Txt::_('Next').'</a></li>';
            }else{
                $start = ($currentPage + 1) * $limit;
                $link = self::addUrlVar($link, 'start='.$start);
                $html .= self::genPageInNav( false, Txt::_('Next'), $link );
            }

            $html .= '</ul>';

        endif;

        return $html;

    }

    public static function addUrlVar( $link, $params){

        $root = strtok($link,'?');
        $rp = strpos($link, '?') === false ? $root : $root.'?';
        $tmp = str_replace( $rp, '', $link);
        parse_str($tmp, $arr);
        
        if ( is_array($params) || is_object($params)){

            foreach($params as $k=>$v) $arr[$k] = $v;

        }elseif( is_string($params)){

            parse_str($params, $ps);
            foreach($ps as $k=>$v) $arr[$k] = $v;
        }
        
        return $root . '?' . http_build_query($arr);
    }

    public static function genPageInNav( $isActive, $pageTxt, $link){
        
        $tmpl = '<li class="page-item">';
        $tmpl .= '<a class="page-link';
        $tmpl .= $isActive  ? ' active" > ' : '" href="' .$link. '"> ';
        $tmpl .= $pageTxt ; 
        $tmpl .= ' </a></li>';
        return $tmpl;
    }

    public static function arrayToString($array){
        return '['. implode( '][', $array) .']';
    }

    public static function stringToArray($string){
        return explode( '][', substr($string, 1, -1) ); 
    }

    public static function isEmptyDateTime($string){
        return empty($string) || $string == '0000-00-00 00:00:00';
    }
    
    public static function isEmptyDate($string){
        return empty($string) || $string == '0000-00-00';
    }

    public static function isEmptyTime($string){
        return empty($string) || $string == '00:00:00';
    }

    public static function shortenName($name){
        $tmp = explode(' ', $name);
        $result = '';
        foreach($tmp as $x){
            $result .= strtoupper( substr($x, 0, 1) );
        }
        return $result;
    }

    public static function getContent($url){

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $page->url());
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curlSession);
        curl_close($curlSession);

        return $content;
    }

    public static function genTableHeader($link, $text, $key, $sort){

        $sort = strtolower($sort);
        if( stripos($sort, $key) === 0 ){
            $sortDir = stripos($sort, 'asc') === false ? 'ASC' : 'DESC';
            $sortIcon = $sortDir === 'ASC' ? 'sort-amount-up' : 'sort-amount-down';
        }else{
            $sortDir = 'ASC';
            //$sortIcon = 'sort-amount-up';
        }

        $link = self::addUrlVar($link, 'sort='.$key.'-'.$sortDir );
        return '<a class="" href="'.$link.'" ><i class="fas fa-'.$sortIcon.'"></i> '. $text .'</a>';
        
    }
}