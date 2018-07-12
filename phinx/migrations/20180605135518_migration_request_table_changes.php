<?php

use Phinx\Migration\AbstractMigration;

class MigrationRequestTableChanges extends AbstractMigration
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
		$this->table('request')
			->addColumn('is_autodj', 'boolean', ['default' => false, 'null' => false])
			->addColumn('updated_at', 'datetime', ['null' => false])
			->addColumn('deleted_at', 'datetime', ['default' => null, 'null' => true])
			->changeColumn('skipped', 'boolean', ['after' => 'ip_address', 'default' => false, 'null' => false])
			->changeColumn('requested_time', 'boolean', ['after' => 'is_autodj', 'default' => false, 'null' => false])
			->renameColumn('id_request', 'request_id')
			->renameColumn('skipped', 'is_skipped')
			->renameColumn('requested_time', 'created_at')
			->update();

		$this->execute('UPDATE request SET updated_at = created_at');
		$this->execute('UPDATE request SET deleted_at = NOW() WHERE active = 0');

		$this->table('request')
			->removeColumn('active')
			->update();
    }
}
