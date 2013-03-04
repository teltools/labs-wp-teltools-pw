<?php
/*
Plugin Name: Teltools Passwords
Plugin URI: http://www.teltools.com.br
Description: Allows Teltools intranet users to change passwords.
Version: 1.0
Author: Arthur Costa
Author URI: http://www.teltools.com.br
Author Email: arthur@teltools.com.br
License: GPL2
*/

class TeltoolsPasswords {

    function __construct() 
    {	
        // forms
        add_shortcode( 'form_asterisk', array(&$this, 'form_asterisk') );
    }
    
    function form_asterisk( $atts ) {
    	extract( shortcode_atts( array(
    		'path' => '',
    		'scheme' => null
    	), $atts ) );
    
        $current_user = wp_get_current_user();
        $user_email= $current_user->user_email;
        $plugins_url = plugins_url( $path, $plugin );

        $form_str  = '<form action="' . $plugins_url . '/teltools-pw/changepw-asterisk.php" method="post" name="mudarsenha">';
        $form_str .= '<table>';
        $form_str .='<tbody>';
        $form_str .= '<tr>';
        $form_str .= '<td>Senha antiga:</td>';
        $form_str .= '<td><input type="password" name="senha_antiga" value=""/></td>';
        $form_str .= '</tr>';
        $form_str .= '<tr>';
        $form_str .= '<td>Senha nova:</td>';
        $form_str .= '<td><input type="password" name="senha_nova" /></td>';
        $form_str .= '</tr>';
        $form_str .= '<tr>';
        $form_str .= '<td>Confirmar Senha:</td>';
        $form_str .= '<td><input type="password" name="confirmacao" /></td>';
        $form_str .= '</tr>';
        $form_str .= '<tr>';
        $form_str .= '<td><input type="hidden" name="email" value="' . $user_email . '"/></td>';
        $form_str .= '<td><input type="submit" name="Salvar" value="Salvar" /></td>';
        $form_str .= '</tr>';
        $form_str .= '</tbody>';
        $form_str .= '</table>';
        $form_str .= '</form>&nbsp;';

        $msg = $_GET['msg'];
        if($msg == 'senha_diferente')
            $form_str .= '<b>Nova senha e confirmação são diferentes.</b>';
        else if($msg == 'senha_invalida')
            $form_str .= '<b>Senha atual inválida.</b>';
        else if($msg == 'senha_alterada')
            $form_str .= '<b>Senha atualizada com sucesso!</b>';

        return $form_str;
    }

}
new TeltoolsPasswords();

?>