<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_DBModel
 *
 * @author farid
 */
class MY_DBModel {

    public function __construct() {
        
    }

    /**
     * Returns the static model of the specified AR class.
     * The model returned is a static instance of the AR class.
     * It is provided for invoking class-level methods (something similar to static class methods.)
     *
     * EVERY derived AR class must override this method as follows,
     * <pre>
     * public static function model($className=__CLASS__)
     * {
     *     return parent::model($className);
     * }
     * </pre>
     *
     * @param string $className active record class name.
     * @return CActiveRecord active record model instance.
     */
    public static function model($className=__CLASS__) {
        if (isset(self::$_models[$className]))
            return self::$_models[$className];
        else {
            $model = self::$_models[$className] = new $className(null);
            $model->_md = new CActiveRecordMetaData($model);
            $model->attachBehaviors($model->behaviors());
            return $model;
        }
    }

    /**
     * Returns the meta-data for this AR
     * @return CActiveRecordMetaData the meta for this AR class.
     */
    public function getMetaData() {
        if ($this->_md !== null)
            return $this->_md;
        else
            return $this->_md = self::model(get_class($this))->_md;
    }

    /**
     * Refreshes the meta data for this AR class.
     * By calling this method, this AR class will regenerate the meta data needed.
     * This is useful if the table schema has been changed and you want to use the latest
     * available table schema. Make sure you have called {@link CDbSchema::refresh}
     * before you call this method. Otherwise, old table schema data will still be used.
     */
    public function refreshMetaData() {
        $finder = self::model(get_class($this));
        $finder->_md = new CActiveRecordMetaData($finder);
        if ($this !== $finder)
            $this->_md = $finder->_md;
    }

}

class CActiveRecordMetaData {

    /**
     * @var CDbTableSchema the table schema information
     */
    public $tableSchema;

    /**
     * @var array table columns
     */
    public $columns;

    /**
     * @var array list of relations
     */
    public $relations = array();

    /**
     * @var array attribute default values
     */
    public $attributeDefaults = array();
    private $_model;

    /**
     * Constructor.
     * @param CActiveRecord $model the model instance
     */
    public function __construct($model) {
        $this->_model = $model;

        $CI =& get_instance();
        
        $tableName = $model->tableName();
        if (($table = $model->getDbConnection()->getSchema()->getTable($tableName)) === null)
            throw new CDbException(Yii::t('yii', 'The table "{table}" for active record class "{class}" cannot be found in the database.', array('{class}' => get_class($model), '{table}' => $tableName)));
        if ($table->primaryKey === null) {
            $table->primaryKey = $model->primaryKey();
            if (is_string($table->primaryKey) && isset($table->columns[$table->primaryKey]))
                $table->columns[$table->primaryKey]->isPrimaryKey = true;
            else if (is_array($table->primaryKey)) {
                foreach ($table->primaryKey as $name) {
                    if (isset($table->columns[$name]))
                        $table->columns[$name]->isPrimaryKey = true;
                }
            }
        }
        $this->tableSchema = $table;
        $this->columns = $table->columns;

        foreach ($table->columns as $name => $column) {
            if (!$column->isPrimaryKey && $column->defaultValue !== null)
                $this->attributeDefaults[$name] = $column->defaultValue;
        }

        foreach ($model->relations() as $name => $config) {
            $this->addRelation($name, $config);
        }
    }

    /**
     * Adds a relation.
     *
     * $config is an array with three elements:
     * relation type, the related active record class and the foreign key.
     *
     * @throws CDbException
     * @param string $name $name Name of the relation.
     * @param array $config $config Relation parameters.
     * @return void
     * @since 1.1.2
     */
    public function addRelation($name, $config) {
        if (isset($config[0], $config[1], $config[2]))  // relation class, AR class, FK
            $this->relations[$name] = new $config[0]($name, $config[1], $config[2], array_slice($config, 3));
        else
            throw new CDbException(Yii::t('yii', 'Active record "{class}" has an invalid configuration for relation "{relation}". It must specify the relation type, the related active record class and the foreign key.', array('{class}' => get_class($this->_model), '{relation}' => $name)));
    }

    /**
     * Checks if there is a relation with specified name defined.
     *
     * @param string $name $name Name of the relation.
     * @return boolean
     * @since 1.1.2
     */
    public function hasRelation($name) {
        return isset($this->relations[$name]);
    }

    /**
     * Deletes a relation with specified name.
     *
     * @param string $name $name
     * @return void
     * @since 1.1.2
     */
    public function removeRelation($name) {
        unset($this->relations[$name]);
    }

}

?>
