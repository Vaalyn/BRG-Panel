<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddRecoveryCodes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
		$this->table('recovery_code', ['id' => false, 'primary_key' => ['recovery_code_id']])
			->addColumn('recovery_code_id', 'integer',  ['identity' => true])
			->addColumn('user_id',          'integer',  ['null' => false])
			->addColumn('code',             'string',   ['limit' => 255, 'null' => false])
			->addColumn('created_at',       'datetime', ['null' => false])
			->addColumn('updated_at',       'datetime', ['null' => false])
			->addColumn('deleted_at',       'datetime', ['default' => null, 'null' => true])
			->save();
    }
}
