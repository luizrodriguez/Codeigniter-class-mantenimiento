<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Mantenimiento Class
 *
 * Realiza tus mantenimientos de una forma facil y ayuda a minimizar tu tiempo de produccion 
 *
 * @package                 CodeIgniter
 * @subpackage              Libraries
 * @category                Libraries
 * @author                  Luis Rodriguez
 * @license                 http://philsturgeon.co.uk/code/dbad-license
 * @link                    http://luisrodriguez.pe
 */
class Mantenimiento
{ 
    //variables privadas para el uso de las funciones
    private $CI;
    private $sql;
    /*la funcion agregar sirve para hacer los insert a las tablas solo necesitamos
    que sea enviado 2 variables $data que es un array que el key sera el nombre
    del campo de la tabla y el value sera loq ue se va a ingresar a la tabla
    la segunda variable $tabla es el nombre de la tabla que queremos agregar*/
    function agregar($data=NULL,$tabla=NULL)    
    { 
        $i=0;
        $this->CI = & get_instance();
        $this->sql .=" INSERT INTO  `$tabla` set";
        foreach ($data as $campo=>$valor):  
            $i++;
            $this->sql .="    `$campo`='".  addslashes($valor)."' "; 
            if ($i<count($data)):
                $this->sql .=",";
            endif;
        endforeach;
        
            if ($this->CI->db->query($this->sql))
            {
                  $this->CI->session->set_userdata("mensaje",'<div class="infobox success-bg mrg10B"> <p>'."Los registros se guardaron correctamente. ".'</p></div>');
            }
            else
            {
                  $this->CI ->session->set_userdata("mensaje",'<div class="infobox error-bg mrg0A mrg10B"><p>'."Hubo un problema al momento de grabar. <br />intentelo y si persiste comunique a la area de sistema.".'</p></div>');
            }
        
    }
    /*la funcion editar sirve para hacer los update a las tablas solo necesitamos
    que sea enviado 2 variables $data que es un array que el key sera el nombre
    del campo de la tabla y el value sera loq ue se va a ingresar a la tabla
    la segunda variable $tabla es el nombre de la tabla que queremos editar*/
     function editar($data=NULL,$tabla=NULL)    
    { 
        $i=0;
        $this->CI = & get_instance(); 
        $id=$data["id"];
        unset($data["id"]);
        if ($id)
        {
            $this->sql .=" update   `$tabla` set";
            foreach ($data as $campo=>$valor):   
                $i++;
                $this->sql .="    `$campo`='".  addslashes($valor)."' "; 
                if ($i<count($data)):
                    $this->sql .=",";
                endif;
            endforeach;
            $this->sql .=" where id='".$id."' ";

            if ($this->CI->db->query($this->sql))
            {
                  $this->CI->session->set_userdata("mensaje",'<div class="infobox success-bg"> <p>'."Los registros se editaron correctamente.".'</p></div>');
            }
            else
            {
                  $this->CI->session->set_userdata("mensaje",'<div class="infobox error-bg mrg0A"><p>'."Hubo un problema al momento de grabar. <br />intentelo y si persiste comunique a la area de sistema.".'</p></div>');
            }
        }
        
    }
    /*la funcion eliminar sirve para hacer los delete a las tablas  solo necesitamos
     * 2 variables $data es un array con los id que las tablas que se van a eliminar
     * aqui seria obligatorio que las pk de las tablas se llamen id y la variable $tabla
     * que es la variable que indica a que tabla eliminaremos las id que le pasamos
     */
     function eliminar($data=NULL,$tabla=NULL)    
    { 
         $this->CI = & get_instance(); 
         foreach ($data as $item):
             $this->CI->db->query("delete from $tabla where id=".addslashes($item));
         endforeach;
         $this->CI->session->set_userdata("mensaje",'<div class="infobox success-bg"> <p>'."Los registros se eliminaron correctamente.".'</p></div>');

     }
}
