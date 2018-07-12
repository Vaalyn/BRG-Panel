<?php

use Phinx\Migration\AbstractMigration;

class MigrationTrackVotesTableChanges extends AbstractMigration
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
		$this->table('track_votes')
			->addColumn('updated_at', 'datetime', ['null' => false])
			->rename('vote')
			->renameColumn('id', 'vote_id')
			->renameColumn('trackid', 'track_id')
			->renameColumn('vote_time', 'created_at')
			->update();
    }
}
