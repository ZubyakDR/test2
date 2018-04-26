<?php

namespace models;

use resources\Config;
use PDO;
use Exception;

class Mysql
{
    /** @var PDO */
    protected $db;

    /** @var array */
    protected $settingsForDb;

    /**
     * Получить экземпляр базы
     * @return Mysql aбстракция работы с БД
     */
    public static function instance(): Mysql
    {
        return new Mysql();
    }

    protected function __construct()
    {
        $this->setSettingsForDb(Config::DATABASES);
        $this->connectDb();
    }

    /**
     * @return array
     */
    public function getSettingsForDb(): array
    {
        return $this->settingsForDb;
    }

    /**
     * @param array $settingsForDb
     */
    public function setSettingsForDb(array $settingsForDb)
    {
        $this->settingsForDb = $settingsForDb;
    }

    /**
     * @return PDO
     */
    public function getDb(): PDO
    {
        return $this->db;
    }

    /**
     * @param PDO $db
     * @return Mysql
     */
    public function setDb(PDO $db): Mysql
    {
        $this->db = $db;
        return $this;
    }

    /**
     * Подключение к базе
     * @throws Exception Проблемы с подключением к базе
     */
    private function connectDb()
    {
        try {
            $settingDb = $this->getSettingsForDb();
            $connectDb = new PDO($settingDb['type'] . ':host=' . $settingDb['server'] . ';dbname=' .
                $settingDb['database'], $settingDb['user'], $settingDb['password'], [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            $this->setDb($connectDb);
            $dbCharset = $settingDb['charset'] ?? 'UTF8';
            $this->getDb()->exec('SET NAMES ' . $dbCharset);
        } catch (Exception $e) {
            echo 'PDO could not connect to database', $e->getCode(), $e;
        }
    }

    /**
     * Выбрать данные из базы
     * @param string $query Текст запроса
     * @param array $params Параметры запроса
     * @return array Ответ от базы
     * @throws
     */
    public function select(string $query, array $params = [])
    {
        try {
            $pdo = $this->getDb()->prepare($query);
            $pdo->execute($params);
            return $pdo->fetchAll();
        } catch (Exception $e) {
            throw new Exception('Bad select query ' . $query, $e->getCode(), $e);
        }
    }

    /**
     * @param $table string Имя таблицы
     * @param $meanings array массив данных
     * @return string Подготовленный запрос
     */
    public function preparationOfRequestInsert(string $table, array $meanings): string
    {
        $columns = [];
        $masks = [];

        foreach ($meanings as $key => $meaning) {

            $columns[] = $key;
            $masks[] = ":$key";

            if ($meaning === null) {
                $meanings[$key] = 'NULL';
            }
        }

        $glueColumns = implode(',', $columns);
        $glueMasks = implode(',', $masks);

        $query = "INSERT INTO {$table} ({$glueColumns}) VALUES ({$glueMasks})";
        return $this->insert($query, $meanings);
    }

    /**
     * @param $table string Имя таблицы
     * @param $meanings array массив данных
     * @return string Подготовленный запрос
     */
    public function preparationOfRequestMultiInsert(string $table, array $meanings): string
    {
        $column = [];
        $params = [];
        $preparedLine = false;
        $countMeanings = count($meanings);
        for ($i = 0; $i < $countMeanings; $i++) {
            if ($i != 0) {
                if (count($column) != count($meanings[$i])) {
                    continue;
                }
            }
            if ($preparedLine) {
                $preparedLine .= ' , ';
            }
            $preparedLine .= '( ';
            $countMeaning = count($meanings[$i]);
            foreach ($meanings[$i] as $key => $meaning) {
                if ($i == 0) {
                    $column[] = $key;
                } else {
                    if (!in_array($key, $column)) {
                        continue;
                    }
                }
                $preparedLine .= ":" . $key . '_' . $i;
                $params[":" . $key . '_' . $i] = $meaning;
                if ($countMeaning != 1) {
                    $preparedLine .= ',';
                }
                $countMeaning--;
            }
            $preparedLine .= ' )';
        }
        $columns = implode(',', $column);

        $query = "INSERT INTO {$table} ({$columns}) VALUES {$preparedLine}";

        return $this->insert($query, $params);
    }

    /**
     * @param $query string Подготовленный запрос
     * @param $meanings array Массив данных
     * @return int
     * @throws Exception
     */
    private function insert(string $query, array $meanings)
    {
        try {
            $pdo = $this->getDb()->prepare($query);
            $pdo->execute($meanings);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Bad insert query ' . $query, $e->getCode(), $e);
        }
    }

    /**
     * @param $table string Название таблицы
     * @return \PDOStatement
     * @throws Exception
     */
    public function truncate(string $table)
    {
        $query = "TRUNCATE TABLE $table";

        try {
            return $this->getDb()->query($query);
        } catch (Exception $e) {
            throw new Exception('Bad truncate query ' . $query, $e->getCode(), $e);
        }
    }
}