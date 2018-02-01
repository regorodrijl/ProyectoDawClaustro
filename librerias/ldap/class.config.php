<?php
class Config
{
    // Datos configuración autenticación LDAP
	public static $ldapServidor = '193.144.43.241';
	public static $ldapPuerto = '65500';
	public static $ldapDominio = 'sanclemente.local';
	public static $OUdefecto = 'OU=SC-Usuarios,DC=sanclemente,DC=local';

    // Valores por defecto para las claves LDAP de usuarios que no tengan datos.
	const direccion = 'C/ San Clemente s/n.';
	const telefono = '981580496';
	const provincia = 'A Coruña';
	const website = 'http://www.iessanclemente.net';
	const dominiodefecto = 'iessanclemente.net';
}
?>