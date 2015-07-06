<?php

namespace  Tinto;

use \SQLite3;

class Database
{

    protected $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        if ($db = new SQLite3(__DIR__ . '/../var/database.sqlite')) {
            $db->query(
                'CREATE TABLE IF NOT EXISTS windstrength (
                    timestamp INTEGER,
                    avg INTEGER,
                    max INTEGER,
                    min INTEGER,
                PRIMARY KEY (timestamp))'
            );

            $db->query(
                'CREATE TABLE IF NOT EXISTS winddirection (
                    timestamp INTEGER,
                    avg REAL,
                PRIMARY KEY (timestamp))'
            );

            $db->query(
                'CREATE TABLE IF NOT EXISTS temperature (
                    timestamp INTEGER,
                    avg REAL,
                PRIMARY KEY (timestamp))'
            );

            $db->query(
                'CREATE TABLE IF NOT EXISTS humidity (
                    timestamp INTEGER,
                    avg INTEGER,
                PRIMARY KEY (timestamp))'
            );

            $db->query(
                'CREATE TABLE IF NOT EXISTS brightness (
                    timestamp INTEGER,
                    avg INTEGER,
                PRIMARY KEY (timestamp))'
            );

            $db->query(
                'CREATE TABLE IF NOT EXISTS pressure (
                    timestamp INTEGER,
                    avg REAL,
                PRIMARY KEY (timestamp))'
            );

            $this->db = $db;
        } else {
            throw new \Exception("Can't create database file", 1);
        }
    }

    /**
     * Insert data into a table
     *
     * @param  Array  $data  Array of data lines
     * @param  string $table Table name
     *
     * @return void
     */
    public function insert(Array $data, $table)
    {
        foreach ($data as $item) {
            $this->insertOne($item, $table);
        }
    }

    /**
     * Insert one line to a table
     *
     * @param  array $item   Array of fields
     * @param  string $table [description]
     *
     * @return void
     */
    public function insertOne($item, $table)
    {
        $db = $this->db;

        $timestamp = new \DateTime($item[0]);
        $timestamp->modify('+1 month');

        switch ($table) {
            case 'windstrength':
                $stmt = $db->prepare(
                    'INSERT OR REPLACE INTO windstrength (timestamp, avg, min, max) VALUES
                    (:timestamp, :avg, :min, :max)'
                );
                $stmt->bindValue(':timestamp', $timestamp->getTimestamp(), SQLITE3_INTEGER);
                $stmt->bindValue(':avg', $item[1], SQLITE3_INTEGER);
                $stmt->bindValue(':min', $item[3], SQLITE3_INTEGER);
                $stmt->bindValue(':max', $item[2], SQLITE3_INTEGER);

                $stmt->execute();
                break;
            case 'winddirection':
            case 'temperature':
            case 'humidity':
            case 'brightness':
            case 'pressure':
                $stmt = $db->prepare(
                    'INSERT OR REPLACE INTO ' . $table . ' (timestamp, avg) VALUES
                    (:timestamp, :avg)'
                );

                $stmt->bindValue(':timestamp', $timestamp->getTimestamp(), SQLITE3_INTEGER);
                $stmt->bindValue(':avg', $item[1]);

                $stmt->execute();
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Get data from a table
     *
     * @param  string  $table Table name
     * @param  integer $now   Timestamp
     *
     * @return \SQLite3Result
     */
    public function getData($table, $now = null)
    {
        if ($now === null) {
            $now = time();
        }

        $db = $this->db;

        $stmt = $db->prepare(
            'SELECT * FROM ' . $table . ' WHERE timestamp < :now AND timestamp > :back'
        );
        $stmt->bindValue(':now', $now, SQLITE3_INTEGER);
        $stmt->bindValue(':back', $now - 86400, SQLITE3_INTEGER); // 24 hours

        $results = $stmt->execute();

        return $results;
    }
}
