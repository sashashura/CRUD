<?php

namespace Backpack\CRUD\app\Models\Traits;

use Backpack\CRUD\ModelSchema;
use DB;

/*
|--------------------------------------------------------------------------
| Methods for working with relationships inside select/relationship fields.
|--------------------------------------------------------------------------
*/
trait HasRelationshipFields
{
    /**
     * Register aditional types in doctrine schema manager for the current connection.
     *
     * @return DB
     */
    public function getConnectionWithExtraTypeMappings()
    {
        $conn = DB::connection($this->getConnectionName());

        // register the enum, and jsonb types
        $conn->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $conn->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('jsonb', 'json');

        return $conn;
    }

    /**
     * Get the model's table name, with the prefix added from the configuration file.
     *
     * @return string Table name with prefix
     */
    public function getTableWithPrefix()
    {
        $prefix = $this->getConnection()->getTablePrefix();
        $tableName = $this->getTable();

        return $prefix.$tableName;
    }

    /**
     * Get the column type for a certain db column.
     *
     * @param  string  $columnName  Name of the column in the db table.
     * @return string Db column type.
     */
    public function getColumnType($columnName)
    {
        $schema = new ModelSchema(new self);

        return $schema->getColumnType($columnName);
    }

    /**
     * Checks if the given column name is nullable.
     *
     * @param  string  $column_name  The name of the db column.
     * @return bool
     */
    public static function isColumnNullable($columnName)
    {
        $schema = new ModelSchema(new self);

        return $schema->columnIsNullable($columnName);
    }

    /**
     * Checks if the given column name has default value set.
     *
     * @param  string  $columnName  The name of the db column.
     * @return bool
     */
    public static function dbColumnHasDefault($columnName)
    {
        $schema = new ModelSchema(new self);

        return $schema->columnHasDefault($columnName);
    }

    /**
     * Return the db column default value.
     *
     * @param  string  $column_name  The name of the db column.
     * @return bool
     */
    public static function getDbColumnDefault($columnName)
    {
        $schema = new ModelSchema(new self);

        return $schema->getColumnDefault($columnName);
    }

    /**
     * Return the current model connection and table name.
     */
    public static function getConnectionAndTable()
    {
        $conn = $instance = new static();
        $conn = $instance->getConnectionWithExtraTypeMappings();
        $table = $instance->getTableWithPrefix();

        return [$conn, $table];
    }
}
