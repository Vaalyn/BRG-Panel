<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddBestOfVoting extends AbstractMigration
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
        $this->table('setting')
            ->insert([
                [
                    'key' => 'best_of_voting_start_date',
                    'value' => '1970-01-01'
                ],
                [
                    'key' => 'best_of_voting_end_date',
                    'value' => '1970-01-01'
                ],
                [
                    'key' => 'best_of_voting_playlist_code',
                    'value' => ''
                ],
            ])
            ->saveData();

        $this->table('best_of_vote', ['id' => false, 'primary_key' => ['best_of_vote_id']])
            ->addColumn('best_of_vote_id', 'uuid',     [])
            ->addColumn('nickname',        'string',   ['limit' => 255, 'null' => false])
            ->addColumn('link_1',          'text',     ['null' => false])
            ->addColumn('songname_1',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('link_2',          'text',     ['null' => false])
            ->addColumn('songname_2',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('link_3',          'text',     ['null' => false])
            ->addColumn('songname_3',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('link_4',          'text',     ['null' => false])
            ->addColumn('songname_4',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('link_5',          'text',     ['null' => false])
            ->addColumn('songname_5',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('ip_address',      'string',   ['limit' => 255, 'null' => false])
            ->addColumn('created_at',      'datetime', ['null' => false])
            ->addColumn('updated_at',      'datetime', ['null' => false])
            ->create();
    }
}
