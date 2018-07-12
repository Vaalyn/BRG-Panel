<?php

use Phinx\Migration\AbstractMigration;

class MigrationTracksTableChanges extends AbstractMigration
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
		$this->table('tracks')
			->addColumn('created_at', 'datetime', ['null' => false])
			->addColumn('updated_at', 'datetime', ['null' => false])
			->rename('track')
			->renameColumn('id', 'track_id')
			->renameColumn('artistid', 'artist_id')
			->update();
    }
}
