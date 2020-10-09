<?php

namespace Lib;

use PDO;
use PDOException;

class Mysql
{
    protected $db_envs;
    protected $storage_path;

    public function __construct(Array $db_envs)
    {
        $this->db_envs = $db_envs;
        $this->storage_path = __DIR__.'/../storage/backup/';
    }

    public function dump()
    {
        ini_set('memory_limit', '-1');
        exec('mkdir '.$this->storage_path);
        $all_sql_file = $this->db_envs['database'].'_'.date("dMY_His").'.sql';
        try {
            foreach ($this->getTables() as $table) {
                $sql_file = $this->dumpTable($this->db_envs['host'], $this->db_envs['user'], $this->db_envs['password'], $this->db_envs['database'], $table);
                file_put_contents($this->storage_path.$all_sql_file, file_get_contents($this->storage_path.$sql_file)."\n", FILE_APPEND | LOCK_EX);
                exec('rm -f '.$this->storage_path.$sql_file);
            }

            return $all_sql_file;
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
            die();
        }
        ini_set('memory_limit', '128M');
    }

    private function dumpTable($host, $user, $password, $database, $table)
    {
        $sql_file_path = $this->storage_path.$database.'_'.$table.'.sql';
        exec("mysqldump -h $host -u $user -p$password --single-transaction $database $table > $sql_file_path");

        return basename($sql_file_path);
    }

    private function getTables()
    {
        try {
            $host = $this->db_envs['host'];
            $database = $this->db_envs['database'];
            $pdo = new PDO("mysql:host=$host;dbname=$database", $this->db_envs['user'], $this->db_envs['password']);
            $query = $pdo->query("SHOW TABLES;");
            $results = $query->fetchAll(PDO::FETCH_COLUMN);

            $filter_results = array_filter(
                $results,
                function ($var) {
                    return !in_array($var, $this->db_envs['ignore_table']);
                }
            );
        } catch (PDOException $e) {
            echo $e->getMessage()."\n";
            die();
        }

        return $filter_results;
    }
}
