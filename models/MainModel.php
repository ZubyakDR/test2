<?php

namespace models;

class MainModel
{
    /**@var Mysql */
    protected $db;

    /**
     * MainModel constructor.
     */
    protected function __construct()
    {
        $this->setDb(Mysql::instance());
    }

    /**
     * @return Mysql
     */
    public function getDb(): Mysql
    {
        return $this->db;
    }

    /**
     * @param Mysql $db
     * @return MainModel
     */
    public function setDb(Mysql $db): MainModel
    {
        $this->db = $db;
        return $this;
    }

    /**
     * Получить все значения таблицы
     * @param $table string Название таблицы
     * @return array
     */
    public function findAll(string $table): array
    {
        return $this->getDb()->select("SELECT * FROM {$table}");
    }

    /**
     * Добавить запись в бд
     * @param $table string название таблицы
     * @param $meanings array массив с параметрами
     * @return int
     */
    public function save(string $table, array $meanings): int
    {
        return $this->getDb()->preparationOfRequestInsert($table, $meanings);
    }

    /**
     * Добавить записи в бд
     * @param $table string название таблицы
     * @param $meanings array массив с параметрами
     * @return bool
     */
    public function multipleAddition(string $table, array $meanings): bool
    {
        if ($this->getDb()->truncate($table)) {
            foreach ($meanings as $meaning) {
                $this->getDb()->preparationOfRequestMultiInsert($table, $meaning);
            }
        }
        return true;
    }
}