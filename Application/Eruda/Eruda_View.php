<?php
/**
 * Description of Eruda_View
 *
 * @author gaixas1
 */

/**
 * @property Eruda_Header $_header 
 */
abstract class Eruda_View {
    
    /**
     * @param Eruda_Model $model
     */
    abstract function show($model);
}

?>
