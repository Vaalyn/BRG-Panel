<?php

use Phinx\Migration\AbstractMigration;

class MigrationCoinEventTableChanges extends AbstractMigration
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
		$this->table('coin_event')
			->addColumn('updated_at', 'datetime', ['after' => 'created_at', 'null' => false])
			->changeColumn('id_community_user', 'integer',  ['after' => 'coins', 'null' => false])
			->renameColumn('id', 'coin_event_id')
			->renameColumn('id_community_user', 'community_user_id')
			->update();
    }
}
