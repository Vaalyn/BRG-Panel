<?php

use Phinx\Migration\AbstractMigration;

class MigrationUserTableChanges extends AbstractMigration
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
		$this->table('user')
			->removeColumn('user_id')
			->removeColumn('username')
			->removeColumn('password')
			->removeColumn('salt')
			->removeColumn('admin')
			->removeColumn('usergroup')
			->update();

		$this->table('user')
			->renameColumn('id_user',      'user_id')
			->renameColumn('name',         'username')
			->renameColumn('password_new', 'password')
			->update();
    }
}
