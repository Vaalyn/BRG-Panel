<?php

use Phinx\Migration\AbstractMigration;

class MigrationTrackHistoryTableChanges extends AbstractMigration
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
		$this->table('track_history')
			->addColumn('created_at', 'datetime', ['null' => false])
			->addColumn('updated_at', 'datetime', ['null' => false])
			->rename('history')
			->renameColumn('id', 'history_id')
			->update();
    }
}
