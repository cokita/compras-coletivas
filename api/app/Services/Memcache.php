<?php
namespace App\Services\Memcache;


class Memcache extends \Memcache
{
    protected static $memcache;
    protected static $inicializado;

    public function __construct()
    {
        $this->mem = $this->addserver(getenv('MEMCACHE_SERVER'), getenv('MEMCACHE_PORTA'));

    }

    /**
     * Inicia o servidor do memcache
     * @return bool
     */
    public static function init() {
        if (self::$inicializado)
            return true;
        if (class_exists('Memcache') && !self::$memcache) {
            self::$memcache = new Memcache();
            self::$memcache -> addserver(getenv('MEMCACHE_SERVER'), getenv('MEMCACHE_PORTA'));
            $stats = @self::$memcache -> getExtendedStats();
            $disponivel = (bool)$stats[getenv('MEMCACHE_SERVER') . ":" . getenv('MEMCACHE_PORTA')];
            if ($disponivel) {
                self::$inicializado = true;
                return true;
            } else {
                self::$memcache = false;
            }
        }
    }

    /**
     * Calcula o tempo de expiração da variável do memcache
     * retornando o tempo restante para expiração baseado
     * no fim do dia (23:59:59)
     * @return int
     */
    public function expiraCache() {
        $hora = date('h');
        $minuto = date('i');
        $segundo = date('s');
        $dia = 24 * 3600;

        $expira = $dia - (($hora * 3600) + ($minuto * 60) + $segundo);

        return $expira;

    }

}