<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddVoterTable extends AbstractMigration
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
		$this->table('voter', ['id' => false, 'primary_key' => ['voter_id']])
			->addColumn('voter_id',   'uuid',     [])
			->addColumn('origin',     'text',     ['null' => false])
			->addColumn('ip_address', 'string',   ['limit' => 255, 'null' => false])
			->addColumn('created_at', 'datetime', ['null' => false])
			->addColumn('updated_at', 'datetime', ['null' => false])
			->create();

		$this->execute('
			INSERT INTO voter (voter_id, origin, ip_address, created_at, updated_at)
			SELECT *
			FROM (
				SELECT
					voter_id,
					\'https://www.bronyradiogermany.com\',
					ip_address,
					created_at,
					updated_at
				FROM vote
				ORDER BY created_at ASC
				LIMIT 18446744073709551615
			) AS vote
			GROUP BY voter_id
		');
    }
}
