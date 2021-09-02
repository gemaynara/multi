<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', "marci487_ifood" );


/** Usuário do banco de dados MySQL */
define( 'DB_USER', "marci487_ifood" );


/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', "guido242830" );


/** Nome do host do MySQL */
define( 'DB_HOST', "localhost" );


/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );


/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'g|raU8fpm7,2;s{Bg$vX&o=(W|QpuVR@sf73f^oTuZ^j[sbMs1J?r0kelIjLr[va' );

define( 'SECURE_AUTH_KEY',  '4*_%L79& `B2!pIhnqOCzU+u$^D3-3sTI`Q]?~a(gdlcd:A.WUr!3ZdUeXQ(TP-Q' );

define( 'LOGGED_IN_KEY',    'STr!ID9c!{W7qO Aw$@cgU$x{be{.V:{zM2<+x^cgy4X*_B=Bsk,(+mp+{k{u#cX' );

define( 'NONCE_KEY',        'nZ<emu*Yd6%4<5E9$`*1JhSp*@v`Shy<bm&FAi% o7nY-r(v gENHpIN2BxG4fOl' );

define( 'AUTH_SALT',        ']WXNY@c?E<mRC5I$MDGez;)F@]ww/~K(HrylGTLBIi?;fKV#1&&,F_p@tpVuEwx5' );

define( 'SECURE_AUTH_SALT', 'BnZnF9kTj1Iw? =DReA qDW*6;a?cHE/U~S-+YRHnji<&n1e_crOZ*lgkCi3w@7n' );

define( 'LOGGED_IN_SALT',   'o-*V[$8%])sm@k-QUywjVp*ic?Z<|l=8Lg@eX@wtq+yXncFo+Nv^8Us=4uRh15p^' );

define( 'NONCE_SALT',       'aapI.)JNDQXi21Pf.f ]>a<2zwY;5S+3O5j3L>Q8IrV,#XYko,)N&:B7,e(=|4b[' );


/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';


/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
define( 'FORCE_SSL_ADMIN', true );
define( 'WP_CACHE', true );
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
