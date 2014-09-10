#!/usr/bin/php
<?php
if ($argc < 2) {
    shell::usage();
} else {
    shell::interpreta($argv);
}

class shell {

    static $comandos = array(
        'help' => 'ayuda',
        'saludo' => 'saludo',
    );

    function version() {
        echo "\n";
        echo "AppBuilder v1.0\n";
        echo "Informática ALBATRONIC\n";
        echo "\n";
    }

    function usage() {
        self::version();
        echo "Uso: php alba <comando> <parametros>\n\n";
    }

    function help($comando = '') {

        self::version();

        if (isset(self::$comandos[$comando])) {
            echo self::$comandos[$comando], "\n";
        } else {
            foreach (self::$comandos as $key => $value) {
                echo "{$key}\t\t{$value}\n";
            }
        }
    }

    function interpreta($argv) {
        
        switch ($argv[1]) {
            case 'version':
            case 'v':
            case '-v':
                self::version();
                break;

            case 'help':
            case '?':
            case '-help':
            case '-h':
                self::help($argv[2]);
                break;

            default:
                self::help();
        }
    }

}
