<?php

class Db
{

    /**
     * connect to DataBase and return new PDO instance
     * @return PDO
     */
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $pdo = new PDO($dsn, $params['user'], $params['password'], $opt);

        return $pdo;
    }

    /**
     * create DataBase if not exists
     * create all tables
     */
    public static function setup()
    {
        self::createDataBase();
        self::createUsersTable();
        self::createPhotosTable();
        self::createLocationTable();
        self::createOnlineTable();
        self::createTagsTable();
        self::createUsers_TagsTable();
        self::createRatingTable();
        self::createSearchTagsTable();
        self::createFakeAccountsTable();
        self::createLikesTable();
        self::createBlockedTable();
        self::createMessagesTable();
        self::createNotificationsTable();
    }


    private static function createDataBase()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        $conn = new PDO("mysql:host={$params['host']}", $params['user'], $params['password']);
        $sql = "CREATE DATABASE IF NOT EXISTS {$params['dbname']}";
        $conn->exec($sql);
        $sql = "use {$params['dbname']}";
        $conn->exec($sql);
    }

    private static function createUsersTable()
    {
        $pdo = self::getConnection();

        $sql = '
            CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                email VARCHAR(255) NOT NULL,
                user_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                first_name VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                token VARCHAR(255),
                gender VARCHAR(255),
                sexual_preferences VARCHAR(255),
                about TEXT,
                birthday DATE,
                avatar INT,
                confirm ENUM(\'0\', \'1\') DEFAULT \'0\',
                PRIMARY KEY (id)
        )';

        $pdo->exec($sql);
    }

    private static function createPhotosTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS photos (
          id INT UNSIGNED AUTO_INCREMENT NOT NULL,
          user_id INT UNSIGNED NOT NULL,
          src VARCHAR(255) NOT NULL,
          PRIMARY KEY (id)
        )';

        $pdo->exec($sql);
    }

    private static function createLocationTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS location (
          user_id INT UNSIGNED NOT NULL,
          lat DOUBLE NOT NULL,
          lng DOUBLE NOT NULL,
          PRIMARY KEY (user_id)
        )';

        $pdo->exec($sql);
    }

    private static function createOnlineTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS online (          
          user_id INT UNSIGNED NOT NULL,
          `time` int(11) NOT NULL default \'0\',
          PRIMARY KEY (user_id)
        )';

        $pdo->exec($sql);
    }

    private static function createTagsTable()
    {
        $pdo = self::getConnection();

        $sql = '
            CREATE TABLE IF NOT EXISTS tags (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              tag_name VARCHAR(30),
              PRIMARY KEY (id)
            )
        ';

        $pdo->exec($sql);
    }

    private static function createUsers_TagsTable()
    {
        $pdo = self::getConnection();

        $sql = '
            CREATE TABLE IF NOT EXISTS users_tags (
              user_id INT UNSIGNED NOT NULL,
              tag_id INT UNSIGNED NOT NULL
            )
        ';

        $pdo->exec($sql);
    }

    private static function createRatingTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS rating (          
          user_id INT UNSIGNED NOT NULL,
          rating int(11) NOT NULL default \'0\',
          PRIMARY KEY (user_id)
        )';

        $pdo->exec($sql);
    }

    private static function createSearchTagsTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS searchTags (    
          user_id INT UNSIGNED NOT NULL,
          tag VARCHAR(255) NOT NULL
        )';

        $pdo->exec($sql);
    }

    private static function createFakeAccountsTable()
    {
        $pdo = self::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS fakeAccounts (    
          user_id INT UNSIGNED NOT NULL,
          PRIMARY KEY (user_id)
        )';

        $pdo->exec($sql);
    }

    private static function createLikesTable()
    {
        $pdo = Db::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS likes (
          user_id INT UNSIGNED NOT NULL,
          target_id INT UNSIGNED NOT NULL
        )';

        $pdo->exec($sql);
    }

    private static function createBlockedTable()
    {
        $pdo = Db::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS blocked (
          user_id INT UNSIGNED NOT NULL,
          blocked_id INt UNSIGNED NOT NULL
        )';

        $pdo->exec($sql);
    }

    private static function createMessagesTable()
    {
        $pdo = Db::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS messages (
          id_from  INT UNSIGNED NOT NULL,
          id_to INT UNSIGNED NOT NULL,
          message TEXT,
          send_time int(11) NOT NULL default \'0\'
        )';

        $pdo->exec($sql);
    }

    private static function createNotificationsTable()
    {
        $pdo = Db::getConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS notifications (
          id_from  INT UNSIGNED NOT NULL,
          id_to INT UNSIGNED NOT NULL,
          subject VARCHAR(255),
          time int(11) NOT NULL default \'0\',
          read_status ENUM(\'0\', \'1\') DEFAULT \'0\'
        )';

        $pdo->exec($sql);
    }
}