<?php

use PHPUnit\Framework\TestCase;
use Lib\Mysql;

class MysqlTest extends TestCase
{
    public function testDump()
    {
        // DB1
        $host = $_ENV['DB_1_HOST'];
        $user = $_ENV['DB_1_USER'];
        $password = $_ENV['DB_1_PASSWORD'];
        $database = $_ENV['DB_1_DATABASE'];

        exec("mysql -h $host -u root -p$password -e 'DROP DATABASE IF EXISTS `$database`;'");
        exec("mysql -h $host -u root -p$password -e 'CREATE DATABASE `$database`;'");

        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

        //

        $sql1 = "CREATE TABLE `users1` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql1);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql2 = "INSERT INTO `users1` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql2);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql3 = "CREATE TABLE `users2` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql3);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql4 = "INSERT INTO `users2` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql4);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql5 = "CREATE TABLE `users3` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql5);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql6 = "INSERT INTO `users3` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql6);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // DB2
        $host = $_ENV['DB_2_HOST'];
        $user = $_ENV['DB_2_USER'];
        $password = $_ENV['DB_2_PASSWORD'];
        $database = $_ENV['DB_2_DATABASE'];

        exec("mysql -h $host -u root -p$password -e 'DROP DATABASE IF EXISTS `$database`;'");
        exec("mysql -h $host -u root -p$password -e 'CREATE DATABASE `$database`;'");

        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

        //

        $sql1 = "CREATE TABLE `users1` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql1);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql2 = "INSERT INTO `users1` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql2);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql3 = "CREATE TABLE `users2` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql3);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql4 = "INSERT INTO `users2` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql4);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql5 = "CREATE TABLE `users3` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $query = $pdo->query($sql5);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        //

        $sql6 = "INSERT INTO `users3` (`id`, `name`, `email`) VALUES
            (1, 'AAA', 'aaa@email.com'),
            (2, 'BBB', 'bbb@email.com');
        ";
        $query = $pdo->query($sql6);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // start testing DB_1
        $envs = [
            'HOST' => $_ENV['DB_1_HOST'],
            'USER' => $_ENV['DB_1_USER'],
            'PASSWORD' => $_ENV['DB_1_PASSWORD'],
            'DATABASE' => $_ENV['DB_1_DATABASE'],
            'IGNORE_TABLE1' => $_ENV['DB_1_IGNORE_TABLE1'],
            'IGNORE_TABLE2' => $_ENV['DB_1_IGNORE_TABLE2'],
        ];
        $mysql = new Mysql($envs);
        $sql_file = $mysql->dump();

        $sql_file_content = file_get_contents(__DIR__.'/../storage/backup/'.$sql_file);
        exec('rm -Rf '.__DIR__.'/../storage/backup');

        $this->assertContains("CREATE TABLE `users2`", $sql_file_content);
        $this->assertContains("(1,'AAA','aaa@email.com')", $sql_file_content);
        $this->assertContains("(2,'BBB','bbb@email.com')", $sql_file_content);

        $this->assertNotContains("CREATE TABLE `users1`", $sql_file_content);
        $this->assertNotContains("CREATE TABLE `users3`", $sql_file_content);

        // start testing DB_2
        $envs = [
            'HOST' => $_ENV['DB_2_HOST'],
            'USER' => $_ENV['DB_2_USER'],
            'PASSWORD' => $_ENV['DB_2_PASSWORD'],
            'DATABASE' => $_ENV['DB_2_DATABASE'],
            'IGNORE_TABLE1' => $_ENV['DB_2_IGNORE_TABLE1'],
        ];
        $mysql = new Mysql($envs);
        $sql_file = $mysql->dump();

        $sql_file_content = file_get_contents(__DIR__.'/../storage/backup/'.$sql_file);
        exec('rm -Rf '.__DIR__.'/../storage/backup');

        $this->assertContains("CREATE TABLE `users1`", $sql_file_content);
        $this->assertContains("CREATE TABLE `users3`", $sql_file_content);
        $this->assertContains("(1,'AAA','aaa@email.com')", $sql_file_content);
        $this->assertContains("(2,'BBB','bbb@email.com')", $sql_file_content);

        $this->assertNotContains("CREATE TABLE `users2`", $sql_file_content);
    }
}
